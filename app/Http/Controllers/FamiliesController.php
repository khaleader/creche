<?php

namespace App\Http\Controllers;

use App\Bill;
use App\CategoryBill;
use App\Child;
use App\Classroom;
use App\Family;
use App\Http\Requests\AddSchoolRequest;
use App\Http\Requests\ajouterEnfantRequest;
use App\PriceBill;
use App\PromotionAdvance;
use App\PromotionExceptional;
use App\Transport;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;
use URL;
use Validator;

class FamiliesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * @param Requests\AddSchoolRequest $
     * @return \Illuminate\View\View
     */

    public function index()
    {
       $families = \Auth::user()->families()->CurrentYear()->paginate(10);
       return view('families.index',compact('families'));
    }


    public function addchild(Request $request, $id = null)
    {
        if(\Request::isMethod('get'))
        {
          $family =  Family::where('user_id',\Auth::user()->id)->where('id',$id)->first();
            return view('families.addchild',compact('family'));
        }elseif(\Request::isMethod('post')) {
            // promotion Exceptional check
            if(PromotionExceptional::checkExceptionalPromotion())
            {
                if(PromotionExceptional::checkExcTimeOfPromotionIfExpired())
                {
                    if(PromotionExceptional::checkExcPriceandReturnIt() == 'no')
                    {
                        return redirect()->back()->withErrors("la promotion Exceptionnelle est active mais aucun prix n'est défini")->withInput();
                    }else{
                        $prix_exc =  PromotionExceptional::checkExcPriceandReturnIt();
                    }
                }else{
                    return redirect()->back()->withErrors("la promotion Exceptionnelle est active mais la durée est expirée");
                }
            }

            // promotion advanced check
            $prix_advance ='';
            if(PromotionAdvance::checkAdvancePromotion())
            {
                if($request->nbr_month > 1 )
                {
                    if(PromotionAdvance::checkAdvIfPriceIsSet($request->nbr_month) !== false)
                    {
                        $prix_advance = PromotionAdvance::checkAdvIfPriceIsSet($request->nbr_month);
                    }else{
                        return redirect()->back()->withErrors("Aucun prix n'est
                    défini pour cette Promotion de ".$request->nbr_month.' Mois');

                    }
                }
            }





            $validator = Validator::make([
                $request->all(),
                'nom_enfant' =>$request->nom_enfant,
                'date_naissance' => $request->date_naissance,
                'photo' => $request->photo,
                'classe' => $request->classe,
                'branche' => $request->branche,
                'niveau' => $request->niveau

            ], [
                'nom_enfant' => 'required',
                'date_naissance' => 'required',
                'photo' => 'image',
                'niveau' => 'integer',
                'classe' => 'integer',
                'grade' => 'integer'
            ],
                [
                    'photo.image' => "L'image doit etre de type valide JPEG\PNG",
                    'nom_enfant.required' => 'Le Nom de L\'enfant est obligatoire',
                    'date_naissance.required' => 'La Date de Naissance est Obligatoire',
                    'classe.integer' => "vous devez choisir une classe",
                    'niveau.integer' => "vous devez choisir un niveau",
                    'grade.integer' => "Vous devez chosir un niveau global"

                ]);


            // if the parent already in the database
            if ($validator->passes()) {
                $niveau_global =  \Auth::user()->grades()->where('id',$request->grade)->first()->name;


            $child = new Child();
            $child->date_naissance = Carbon::parse($request->date_naissance);
            $child->nom_enfant = $request->nom_enfant;
            $child->sexe = $request->sexe;
            $child->age_enfant = $child->date_naissance->diffInYears(Carbon::now());
             $child->nationalite =\DB::table('countries')->where('id',$request->nationalite)->first()->nom_fr_fr;
             $child->school_year_id = SchoolYear::getSchoolYearId();

                $child->transport = $request->transport;
            $child->user_id = \Auth::user()->id;

            $image = \Input::file('photo');
            if (!$image && empty($image)) {
                $filename = '';

            } else {
                $filename = $image->getClientOriginalName();
                $path = public_path('uploads/' . $filename);
                Image::make($image->getRealPath())->resize(313, 300)->save($path);
            }
            $child->photo = $filename;
            $child->family_id = $request->familyid;
            $resp = Family::findOrFail($request->familyid);
            $user = User::where('email', $resp->email_responsable)->first();
            if ($user) {
                $child->f_id = $user->id;
                $child->save();
                if ($child->id) {

                    $ch =Child::find($child->id);
                    if($niveau_global == 'Lycée')
                    {
                        $ch->branches()->attach([$request->branche]);
                    }
                    if($niveau_global == 'Maternelle' || $niveau_global == 'Primaire'
                        || $niveau_global == 'Collège' || $niveau_global == 'Lycée' || $niveau_global == 'Crèche')
                    {
                        $ch->levels()->attach([$request->niveau]);
                    }

                  /*  if($niveau_global == 'Crèche')
                    {
                        $ch->classrooms()->attach([$request->classe]);
                    }*/



                    $cr = Classroom::where('user_id', \Auth::user()->id)->where('id', $request->classe)->first();
                    $cr->children()->attach([$child->id]);

                    $bill = new Bill();
                    $bill->status = 0;

                    if(!PromotionAdvance::checkAdvancePromotion()  && !PromotionExceptional::checkExceptionalPromotion())
                    {
                        if(isset($request->reduction) &&  !empty($request->reduction)  && !is_null($request->reduction))
                        {
                            $bill->start = Carbon::now()->toDateString();
                            $bill->end = Carbon::now()->addMonths($request->nbr_month)->toDateString();
                            $bill->somme =  PriceBill::countWhenNoPromotionButReduction($request->nbr_month,PriceBill::assignPrice($request->niveau,$request->transport),$request->reduction);
                            $bill->reductionPrix = $request->reduction;
                            $bill->reduction = 1;
                            $bill->school_year_id = \Auth::user()->schoolyears()->where('current',1)->first()->id;
                            $bill->nbrMois =$request->nbr_month;

                        }else{
                            $bill->start = Carbon::now()->toDateString();
                            $bill->end = Carbon::now()->addMonths($request->nbr_month)->toDateString();
                            $bill->somme = PriceBill::countWhenNoPromotion($request->nbr_month,PriceBill::assignPrice($request->niveau,$request->transport));
                            $bill->reduction = 0;
                            $bill->school_year_id = \Auth::user()->schoolyears()->where('current',1)->first()->id;
                            $bill->nbrMois =$request->nbr_month;
                        }
                    }

                    if(PromotionAdvance::checkAdvancePromotion())
                    {
                        if($request->nbr_month >=3)
                        {
                            $bill->start = Carbon::now()->toDateString();
                            $bill->end = Carbon::now()->addMonths($request->nbr_month)->toDateString();
                            $bill->somme =PromotionAdvance::countAccordingTo($prix_advance,PriceBill::assignPrice($request->niveau,$request->transport),$request->nbr_month);
                            $bill->reduction = 1;
                            $bill->reductionPrix  = $prix_advance;
                            $bill->school_year_id = \Auth::user()->schoolyears()->where('current',1)->first()->id;
                            $bill->nbrMois =$request->nbr_month;
                        }
                        if($request->nbr_month == 1)
                        {
                            if(isset($request->reduction) &&  !empty($request->reduction)  && !is_null($request->reduction))
                            {
                                $bill->start = Carbon::now()->toDateString();
                                $bill->end = Carbon::now()->addMonths($request->nbr_month)->toDateString();
                                $bill->somme =  PriceBill::countWhenNoPromotionButReduction($request->nbr_month,PriceBill::assignPrice($request->niveau,$request->transport),$request->reduction);
                                $bill->reductionPrix = $request->reduction;
                                $bill->reduction = 1;
                                $bill->school_year_id = \Auth::user()->schoolyears()->where('current',1)->first()->id;
                                $bill->nbrMois =$request->nbr_month;

                            }else{
                                $bill->start = Carbon::now()->toDateString();
                                $bill->end = Carbon::now()->addMonths($request->nbr_month)->toDateString();
                                $bill->somme = PriceBill::countWhenNoPromotion($request->nbr_month,PriceBill::assignPrice($request->niveau,$request->transport));
                                $bill->reduction = 0;
                                $bill->school_year_id = \Auth::user()->schoolyears()->where('current',1)->first()->id;
                                $bill->nbrMois =$request->nbr_month;
                            }
                        }
                    }
                    if(PromotionExceptional::checkExceptionalPromotion())
                    {
                        $bill->start = Carbon::now()->toDateString();
                        $bill->end = Carbon::now()->addMonths($request->nbr_month)->toDateString();
                        $bill->somme = PromotionExceptional::countAccordingTo($request->nbr_month,PriceBill::assignPrice($request->niveau,$request->transport),$prix_exc);
                        $bill->reductionPrix  = $prix_exc;
                        $bill->reduction = 1;
                        $bill->school_year_id = \Auth::user()->schoolyears()->where('current',1)->first()->id;
                        $bill->nbrMois =$request->nbr_month;
                    }



                    $bill->child_id = $child->id;
                    $bill->f_id = $user->id;
                    $bill->user_id = \Auth::user()->id;
                    $bill->save();
                }
            }
                 return redirect()->back()->with('success',"l'élève a bien été ajouté! ");
           }else{
                return redirect()->back()->withErrors($validator);

            }



        }

    }


    public function fambyalph()
    {
        if(\Request::ajax())
        {
            $caracter = \Input::get('caracter');
            $families =   Family::where('user_id',\Auth::user()->id)
                ->where('nom_pere', 'LIKE', $caracter .'%')
                ->where('responsable',1)->orWhere('nom_mere', 'LIKE', $caracter .'%')
                 ->where('responsable',0)
                ->CurrentYear()
                ->get();
                $count =0;



               foreach($families as $family)
               {
                   if($family->responsable == 0)
                       $resp = $family->nom_mere;
                   else
                       $resp = $family->nom_pere;
                   if($family->photo)
                   {
                       $photo = asset('uploads/'.$family->photo);
                   }else{
                       $photo = asset('images/no_avatar.jpg');
                   }

                   foreach ($family->children as $c )
                   {
                       foreach($c->bills as $b)
                       {
                           if($b->status == 0)
                           {
                               $count += 1;
                           }
                       }
                   }
                   if($count > 0)
                   {
                       $class = 'label-danger';
                   }
                   else{
                       $class = 'label-success';
                   }

                   echo '<tr>
                            <td class="no-print"><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input type="checkbox" name="select[]" value=" '.$family->id.' ">

                                    </div>
                                </div></td>
                            <td><img class="avatar" src="'.$photo.'"></td>
                            <td>'. $resp .' </td>

                            <td>'.  $family->children->count() .'</td>
                            <td class="paiement"><span class="label '.$class.' label-mini"><i class="fa fa-money"></i></span></td>
                            <td class="no-print">
                                <a href="'.action('FamiliesController@delete',[$family]).'" class="actions_icons delete-family">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                               <!-- <a class="archive-family" href="'.action('FamiliesController@archive',[$family]).'"><i class="fa fa-archive liste_icons"></i>
                                </a> -->
                            </td>

                            <td class="no-print"><a href="'.action('FamiliesController@show',[$family->id]).'"><div  class="btn_details">Détails</div></a></td>
                        </tr>';
               }


            //echo json_encode($families);
            die();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $family = Family::findOrFail($id);
        if(!empty($family))
        {
            if($family->user_id == \Auth::user()->id)
            {
                return view('families.show',compact('family'));
            }
        }else{
            return  redirect('families');
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $family = Family::findOrFail($id);
        if(\Auth::user()->id  == $family->user_id)
        {
            return view('families.edit',compact('family'));
        }else{
            return response("Vous n'etes pas autorisé à voir cette page");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
          $validator = Validator::make([
            $request->all(),
            'numero_fixe' =>$request->numero_fixe,
            'numero_portable' =>$request->numero_portable,
            'adresse' => $request->adresse,
            'photo' => $request->photo

        ],[
            'numero_fixe' => 'required',
            'numero_portable'=> 'required',
            'adresse'=> 'required',
            'photo' => 'image'
        ],
            [
                'numero_fixe.required' => "Le tel fixe est requis",
                'numero_portable.required' => "Le tel portable est requis",
                'adresse.required' => "L'adresse est requis",
                'photo.image' => "L'image doit etre de type valide JPEG\PNG"

            ]);
          if($validator->passes())
          {



              $image = $request->photo;
              if(isset($image) && !empty($image))
              {
                  $filename = $image->getClientOriginalName();
                  $path = public_path('uploads/' . $filename);
                  Image::make($image->getRealPath())->resize(313, 300)->save($path);
                  $family =   Family::findOrFail($id);
                  $family->photo = $filename;
                  $family->numero_fixe =$request->numero_fixe;
                  $family->numero_portable =$request->numero_portable;
                  $family->adresse =$request->adresse;
                  $family->save();
              }else{
                  $family = Family::findOrFail($id);
                  if(isset($family->photo))
                  {
                      $filename = $family->photo;
                  }else{
                      $filename = null;
                  }
                  $family->numero_fixe =$request->numero_fixe;
                  $family->numero_portable =$request->numero_portable;
                  $family->adresse =$request->adresse;
                  $family->photo = $filename;
                  $family->save();
              }

              return redirect()->back()->with('success','Modifications réussies !');
          }else{
              return redirect()->back()->withErrors($validator);
          }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

     // checkboxes ajax
    public function supprimer()
    {
        if(\Request::ajax())
        {
            $numbers = substr( \Input::get('boxes'),0,-1);
            $ids = explode(',',$numbers);
            $ids = array_unique($ids);
            foreach($ids as $id)
            {
                $family = Family::findOrFail($id);
               User::where('email',$family->email_responsable)->first()->delete();
                foreach($family->children as $child)
                {
                  $child->bills()->delete();
                    $child->attendances()->delete();

                }
                $family->children()->delete();
                $family->delete();

               $onlyTrashed =Family::onlyTrashed()->findOrFail($id);
                foreach($onlyTrashed->children as $c)
                {
                    $c->bills()->forceDelete();
                    $c->attendances()->forceDelete();
                }
               $onlyTrashed->children()->forceDelete();
                $onlyTrashed->forceDelete();

            }
        }
    }

    // checkboxes ajax
    public function archiver()
    {
        if(\Request::ajax())
        {
            $numbers = substr( \Input::get('boxesarchives'),0,-1);
            $ids = explode(',',$numbers);
            $ids = array_unique($ids);
            foreach($ids as $id)
            {
                $family = Family::findOrFail($id);
                foreach($family->children as $child)
                {
                    $child->bills()->delete();
                    $child->attendances()->delete();
                }
                $family->children()->delete();
                $family->delete();
            }
        }



    }

    /**
     * @param $id
     */
    public function delete($id)
      {
          $family = Family::findOrFail($id);
          foreach($family->children as $child)
          {
              $child->bills()->delete();
              $child->attendances()->delete();
          }
          $family->children()->delete();
          $family->delete();
          $f = Family::onlyTrashed()->findOrFail($id);
          User::where('email',$f->email_responsable)->first()->delete();
          foreach($f->children as $child)
          {
              $child->bills()->forceDelete();
              $child->attendances()->forceDelete();
          }
          $f->children()->forceDelete();
          $f->forceDelete();
          return redirect()->to('families');

      }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function archive($id)
     {
         $family = Family::findOrFail($id);
         foreach($family->children as $child)
         {
             $child->bills()->delete();
         }
         $family->children()->delete();
         $family->delete();
         return redirect()->to('families');

     }

    public function search()
    {
        $child = Child::where('user_id',\Auth::user()->id)
         ->where('nom_enfant', 'LIKE',\Input::get('terms') .'%')
            ->get();

        $familp = Family::where('user_id',\Auth::user()->id)
            ->where('nom_pere', 'LIKE',\Input::get('terms') .'%')
            ->get();
        $familym = Family::where('user_id',\Auth::user()->id)
            ->where('nom_mere', 'LIKE',\Input::get('terms') .'%')
            ->get();
        $family = $familp->merge($familym);


        return view('families.search')->with(['child'=>$child,'family'=>$family]);
    }


    /****************************Excel export********************************
     * @param $ids
     */

    public function exportExcel($ids =null)
    {

        $ids =  explode(',',substr($ids,0,-1));
        $ids =   array_unique($ids);
            $family = Family::whereIn('id',$ids)->where('user_id', \Auth::user()->id)->get(['id','responsable','nom_pere','nom_mere']);
            Excel::create('La liste des familles', function ($excel) use ($family) {
                $excel->sheet('La liste des familles', function ($sheet) use ($family) {


                    foreach ($family as $f) {
                        $count = 0;
                        if ($f->responsable == 0) {
                            $f->responsable = $f->nom_mere;
                        } else {
                            $f->responsable = $f->nom_pere;
                        }
                        foreach ($f->children as $c) {
                            foreach ($c->bills as $b) {
                                if ($b->status == 0) {
                                    $count += 1;
                                }
                            }

                        }
                        if($count > 0)
                        {
                            $f->status = 'Non Réglée';
                        }else{
                            $f->status = 'Réglée';
                        }
                    }


                    $sheet->setWidth('A',0);
                    $sheet->setWidth('B',20);
                    $sheet->setWidth('C',20);
                    $sheet->setWidth('D',20);
                    $sheet->setWidth('E',20);

                    $sheet->fromModel($family);
                    $sheet->setStyle(array(
                        'font' => array(
                            'name'      =>  'Calibri',
                            'size'      =>  13,
                        )
                    ));
                    $sheet->setAllBorders('thin');
                    $sheet->cells('A1:E1',function($cells){
                        $cells->setBackground('#97efee');

                        $cells->setFont(array(
                            'family'     => 'Calibri',
                            'size'       => '14',
                            'bold'       =>  true
                        ));
                    });
                    $sheet->row(1, array(
                        '', 'Responsable','Nom Père','Nom Mère','Statut de Paiement'
                    ));

                });
            })->export('xls');

    }


    /**
     * @param $ids
     */
    public function exportPdf($ids=null)
    {
        $ids =  explode(',',substr($ids,0,-1));
        $ids =   array_unique($ids);

            $family = Family::whereIn('id',$ids)->where('user_id', \Auth::user()->id)->get(['id','responsable','nom_pere','nom_mere']);
            Excel::create('La liste des familles', function ($excel) use ($family,$ids) {
                $excel->sheet('La liste des familles', function ($sheet) use ($family,$ids) {


                    foreach ($family as $f) {
                        $count = 0;
                        if ($f->responsable == 0) {
                            $f->responsable = $f->nom_mere;
                        } else {
                            $f->responsable = $f->nom_pere;
                        }
                        foreach ($f->children as $c) {
                            foreach ($c->bills as $b) {
                                if ($b->status == 0) {
                                    $count += 1;
                                }
                            }

                        }
                        if($count > 0)
                        {
                            $f->status = 'Non Réglée';
                        }else{
                            $f->status = 'Réglée';
                        }
                      unset($f->id);
                    }


                    $sheet->setWidth('A',20);
                    $sheet->setWidth('B',20);
                    $sheet->setWidth('C',20);
                    $sheet->setWidth('D',20);

                    $sheet->fromModel($family);

                    $sheet->setAllBorders('thin');
                    $sheet->setFontFamily('OpenSans');
                    $sheet->setFontSize(13);
                    $sheet->setFontBold(false);

                    for($i = 1; $i <= count($ids) +1 ; $i++)
                    {
                        $sheet->setHeight($i, 25);
                        $sheet->row($i,function($rows){
                            $rows->setFontColor('#556b7b');
                            $rows->setAlignment('center');
                        });


                        $sheet->cells('A'.$i.':'.'D'.$i,function($cells){
                            $cells->setValignment('middle');
                            $cells->setFontColor('#556b7b');
                            $cells->setFont(array(
                                'family'     => 'OpenSans',
                                'size'       => '13',
                                'bold'       =>  false,
                            ));

                        });
                    }
                    // normal header
                    $sheet->cells('A1:D1',function($cells){
                        $cells->setBackground('#e9f1f3');
                        $cells->setFontColor('#556b7b');
                        $cells->setFont(array(
                            'family'     => 'OpenSans',
                            'size'       => '15',
                            'bold'       =>  true,
                        ));

                    });






                    $sheet->row(1, array(
                         'Responsable','Nom Père','Nom Mère','Statut de Paiement'
                    ));

                });
            })->export('pdf');

    }

}
