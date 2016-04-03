<?php

namespace App\Http\Controllers;

use App\Bill;
use App\Branch;
use App\CategoryBill;
use App\Classroom;
use App\Events\BillEvent;
use App\Events\SendEmailToRespAfterRegistrationEvent;
use App\Family;
use App\Child;
use App\Grade;
use App\Http\Requests\ajouterEnfantRequest;
use App\Http\Requests\FormValidationChildFamilyRequest;
use App\Level;
use App\PriceBill;
use App\PromotionAdvance;
use App\PromotionExceptional;
use App\SchoolYear;
use App\Transport;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;
use URL;
use Validator;

class ChildrenController extends Controller
{

    public  $request;
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('Famille', ['only' => ['indexef', 'showef']]);
        $this->middleware('admin', ['except' => ['indexef', 'showef']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $children = \Auth::user()->children()->CurrentYear()->paginate(10);
        if(!$children->isEmpty())
        {
            return view('children.index', compact('children'));
        }else{
            return view('children.index', compact('children'));
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('children.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function store(FormValidationChildFamilyRequest $request )
    {
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

        $niveau_global =  \Auth::user()->grades()->where('id',$request->grade)->first()->name;

        // famille for family profile
        $famille = Family::where('user_id',\Auth::user()->id)->where('email_responsable',$request->email_responsable)->first();
        if(!$famille) {
            $family = new Family();
            $family->nom_pere = ucfirst($request->nom_pere);
            $family->nom_mere = ucfirst($request->nom_mere);
            $family->email_responsable = $request->email_responsable;
            $family->adresse = $request->adresse;
            $family->numero_fixe = $request->numero_fixe;
            $family->numero_portable = $request->numero_portable;
            $family->cin = strtoupper($request->cin);
            $family->responsable = $request->responsable;
            $family->user_id = \Auth::user()->id;
            $family->school_year_id = SchoolYear::getSchoolYearId();
            $family->save();


            if ($family->id) {
                $father = Family::findOrFail($family->id);
                $child = new Child();
                $child->date_naissance = Carbon::parse($request->date_naissance);
                $child->transport = $request->transport;
                $child->sexe = $request->sexe;


                $child->nom_enfant = ucfirst($request->nom_enfant);
                $child->age_enfant = $child->date_naissance->diffInYears(Carbon::now());
                $child->nationalite = \DB::table('countries')->where('id',$request->nationalite)->first()->nom_fr_fr;
                $child->user_id = \Auth::user()->id;
                $child->school_year_id = SchoolYear::getSchoolYearId();

                $image = Input::file('photo');
                if (!$image && empty($image)) {
                    $filename = '';

                } else {
                    $filename = $image->getClientOriginalName();
                    $path = public_path('uploads/' . $filename);
                    Image::make($image->getRealPath())->resize(313, 300)->save($path);
                }

                $child->photo = $filename;
                $child->family_id = $family->id;
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
                    /*if($niveau_global == 'Crèche')
                    {
                        $ch->classrooms()->attach([$request->classe]);
                    }*/

                    //classe
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
                            $bill->school_year_id =  SchoolYear::getSchoolYearId();
                            $bill->nbrMois =$request->nbr_month;

                        }else{
                            $bill->start = Carbon::now()->toDateString();
                            $bill->end = Carbon::now()->addMonths($request->nbr_month)->toDateString();
                            $bill->somme = PriceBill::countWhenNoPromotion($request->nbr_month,PriceBill::assignPrice($request->niveau,$request->transport));
                            $bill->reduction = 0;
                            $bill->school_year_id =  SchoolYear::getSchoolYearId();
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
                        $bill->school_year_id = SchoolYear::getSchoolYearId();
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
                                $bill->school_year_id = SchoolYear::getSchoolYearId();
                                $bill->nbrMois =$request->nbr_month;

                            }else{
                                $bill->start = Carbon::now()->toDateString();
                                $bill->end = Carbon::now()->addMonths($request->nbr_month)->toDateString();
                                $bill->somme = PriceBill::countWhenNoPromotion($request->nbr_month,PriceBill::assignPrice($request->niveau,$request->transport));
                                $bill->reduction = 0;
                                $bill->school_year_id = SchoolYear::getSchoolYearId();
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
                        $bill->school_year_id = SchoolYear::getSchoolYearId();
                        $bill->nbrMois =$request->nbr_month;
                    }




                    $bill->child_id = $child->id;
                    $bill->user_id = \Auth::user()->id;
                    $bill->save();


                    $enfant = Child::findOrFail($child->id);
                    if ($father->responsable == 0)
                        $resp = $father->nom_mere;
                    else
                        $resp = $father->nom_pere;
                    event(new SendEmailToRespAfterRegistrationEvent(
                        $child->id,
                        $resp,
                        $enfant->nom_enfant,
                        $enfant->created_at->toDateString(),
                        $enfant->created_at->addMonth()->toDateString(),
                        $father->email_responsable,
                        $father->responsable,
                        str_random(6)
                    ));
                }

            }
            return redirect()->back()->with('success', "l'élève et les parents ont bien été ajoutés! ");



        }else{
            // if the parent already in the database
            $child = new Child();
            $child->date_naissance = Carbon::parse($request->date_naissance);
            $child->nom_enfant = $request->nom_enfant ;
            $child->sexe = $request->sexe;
            $child->age_enfant =$child->date_naissance->diffInYears(Carbon::now());
            $child->nationalite =\DB::table('countries')->where('id',$request->nationalite)->first()->nom_fr_fr;
            $child->school_year_id = SchoolYear::getSchoolYearId();
            $child->transport = $request->transport;
            $child->user_id = \Auth::user()->id;

            $image = Input::file('photo');
            if(!$image && empty($image))
            {
                $filename = '';

            }else{
                $filename = $image->getClientOriginalName();
                $path = public_path('uploads/' . $filename);
                Image::make($image->getRealPath())->resize(313, 300)->save($path);
            }
            $child->photo = $filename;
            $child->family_id = $famille->id;
            $resp = Family::findOrFail($famille->id);
            $user =  User::where('email',$resp->email_responsable)->first();
            if($user)
            {
                $child->f_id =$user->id;
                $child->save();
                if($child->id)
                {

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
                    if($niveau_global == 'Crèche')
                    {
                        $ch->classrooms()->attach([$request->classe]);
                    }


                    $cr =  Classroom::where('user_id',\Auth::user()->id)->where('id',$request->classe)->first();
                    $cr->children()->attach([$child->id]);

                    $bill  = new Bill();
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
                            $bill->school_year_id =  SchoolYear::getSchoolYearId();
                            $bill->nbrMois =$request->nbr_month;

                        }else{
                            $bill->start = Carbon::now()->toDateString();
                            $bill->end = Carbon::now()->addMonths($request->nbr_month)->toDateString();
                            $bill->somme = PriceBill::countWhenNoPromotion($request->nbr_month,PriceBill::assignPrice($request->niveau,$request->transport));
                            $bill->reduction = 0;
                            $bill->school_year_id =  SchoolYear::getSchoolYearId();
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
                            $bill->school_year_id = SchoolYear::getSchoolYearId();
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
                                $bill->school_year_id = SchoolYear::getSchoolYearId();
                                $bill->nbrMois =$request->nbr_month;

                            }else{
                                $bill->start = Carbon::now()->toDateString();
                                $bill->end = Carbon::now()->addMonths($request->nbr_month)->toDateString();
                                $bill->somme = PriceBill::countWhenNoPromotion($request->nbr_month,PriceBill::assignPrice($request->niveau,$request->transport));
                                $bill->reduction = 0;
                                $bill->school_year_id = SchoolYear::getSchoolYearId();
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
                        $bill->school_year_id = SchoolYear::getSchoolYearId();
                        $bill->nbrMois =$request->nbr_month;
                    }


                    $bill->child_id =$child->id;
                    $bill->f_id = $user->id;
                    $bill->user_id = \Auth::user()->id;
                    $bill->save();
                }
            }


            return redirect()->back()->with('success',"l'élève a bien été ajouté! ");
        }

    }





    /**
     *afficher formulaire pour ajouter  un enfant dont le parent est dèja enregistré
     */
    public function create_enfant()
    {
        if(\Request::ajax())
        {
           $id_pere = Input::get('id_pere');
           $id_mere = Input::get('id_mere');
            if($id_pere)
            {
                $family = Family::findOrFail($id_pere);
                echo json_encode($family);
                die();
            }
            if($id_mere)
            {
                $family = Family::findOrFail($id_mere);
                echo json_encode($family);
                die();
            }
        }

      return view('children.ajouter_enfant');
    }

    /**
     * ajouter un enfant avec seulement l'id de parent
     * @param Request $request
     */
    public function store_enfant(ajouterEnfantRequest $request)
    {

            $child = new Child();
            $child->date_naissance = Carbon::parse($request->date_naissance);
            $child->nom_enfant = $request->nom_enfant ;
            $child->sexe = $request->sexe;
            $child->age_enfant =$child->date_naissance->diffInYears(Carbon::now());

            $child->transport = $request->transport;
            $child->user_id = \Auth::user()->id;

            $image = Input::file('photo');
            if(!$image && empty($image))
            {
                $filename = '';

            }else{
                $filename = $image->getClientOriginalName();
                $path = public_path('uploads/' . $filename);
                Image::make($image->getRealPath())->resize(313, 300)->save($path);
            }
                $child->photo = $filename;
                $child->family_id = $request->pere;
                 $resp = Family::findOrFail($request->pere);
                $user =  User::where('email',$resp->email_responsable)->first();
                if($user)
               {
                  $child->f_id =$user->id;
                  $child->save();
                   if($child->id)
                   {
                       $cr =  Classroom::where('user_id',\Auth::user()->id)->where('id',$request->classe)->first();
                       $cr->children()->attach([$child->id]);

                       $bill  = new Bill();
                       $bill->start =Carbon::now()->toDateString();
                       $bill->end = Carbon::now()->addMonth()->toDateString();
                       $bill->status = 0;
                       if($request->transport == 1)
                       {
                           if(Transport::where('user_id',\Auth::user()->id)->exists())
                           {
                               $transport_somme =  Transport::where('user_id',\Auth::user()->id)->first()->somme;
                               $bill_somme =CategoryBill::getYear(Carbon::parse($request->date_naissance));
                               $bill->somme = $transport_somme + $bill_somme;
                           }else{
                               $bill->somme = CategoryBill::getYear(Carbon::parse($request->date_naissance));
                           }
                       }else{
                           $bill->somme = CategoryBill::getYear(Carbon::parse($request->date_naissance));
                       }

                       $bill->child_id =$child->id;
                       $bill->f_id = $user->id;
                       $bill->user_id = \Auth::user()->id;
                       $bill->save();
                   }
               }


        return redirect()->back()->with('success',"l'enfant a bien été ajouté! ");
        }




    public function enfbyalph()
    {
        if(\Request::ajax())
        {
           $caracter = Input::get('caracter');
           $enfants =   Child::where('nom_enfant', 'LIKE', $caracter .'%')
               ->where('user_id',\Auth::user()->id)
               ->CurrentYear()
               ->get();
            foreach($enfants as $enfant)
            {
                foreach($enfant->bills as $e)
                {
                    if($e->status == 1)
                     $class = 'label-success';
                    else
                       $class = 'label-danger';
                }
                foreach($enfant->classrooms as $cr)
                {
                  $classe =  $cr->nom_classe;
                }


                if($enfant->photo)
                   $photo =  asset('uploads/'.$enfant->photo);
                else
                    $photo =  asset('images/avatar4.jpg');

                echo ' <tr>
                            <td class="no-print"><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input type="checkbox" name="select[]" value="'.$enfant->id.'">

                                    </div>
                                </div></td>
                            <td><img class="avatar" src=" '. $photo .' "></td>
                            <td>'. $enfant->nom_enfant .'</td>
                            <td>'.  $enfant->created_at->format('d-m-Y') .' </td>
                            <td>'.$classe.'</td>

                            <td class="paiement"><span class="label '.$class.' label-mini"><i class="fa fa-money"></i></span></td>
                            <td class="no-print">
                                <a href="'.action('ChildrenController@delete',[$enfant]).'" class="actions_icons delete-child">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                               <!-- <a class="archive-child" href="'.action('ChildrenController@archive',[$enfant]).'"><i class="fa fa-archive liste_icons"></i>
                                </a>-->
                            </td>

                            <td class="no-print"><a href="'. action('ChildrenController@show',[$enfant->id]).'"><div  class="btn_details">Détails</div></a></td>
                        </tr>';
            }



          //  echo json_encode($enfants);
            //die();
        }
    }

    // retourne la branche  dès le recoit de la classe  en ajax
    public function getBranchWhenClassid()
    {
        if(\Request::ajax())
        {
            $classe_id = \Input::get('classe_id');
            $classe = Classroom::where('id',$classe_id)->first();
            foreach($classe->branches->unique() as $branch)
            {
                echo '<option value="'.$branch->id.'">'.$branch->nom_branche.'</option>';
            }

        }
    }

    public function getClassroomWhenLevelId()
    {
        if(\Request::ajax()) {
            $level_id = \Input::get('level_id');
            $level = Level::where('id', $level_id)->where('user_id',\Auth::user()->id)->first();
            foreach ($level->classrooms as $cr) {
                echo '<option value="' . $cr->id . '">' . $cr->nom_classe . '</option>';
            }
            foreach ($level->lesClasses as $cr) {
                echo '<option value="' . $cr->id . '">' . $cr->nom_classe . '</option>';

            }
        }


    }




    //get level when grade is chosen

    public function getLevelWhenGradeIsChosen()
    {
        if(\Request::ajax()) {
            $grade_id = \Input::get('grade_id');
            $grade = Grade::where('id', $grade_id)->first();
            foreach ($grade->levels as $level) {
                echo '<option value="' . $level->id . '">' . $level->niveau . '</option>';

            }
        }
    }







    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $child =  \Auth::user()->children()->where('id',$id)->first();
        if($child)
        {
        return view('children.show',compact('child'));

        }else{
            return  response("Vous n'etes pas autorisé à voir cette page", 401);
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
       $child = Child::findOrFail($id);
        if(\Auth::user()->id  == $child->user_id)
        {
            return view('children.edit',compact('child'));
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
         //  'numero_fixe' =>$request->numero_fixe,
          // 'numero_portable' =>$request->numero_portable,
        //   'adresse' => $request->adresse,
           'photo' => $request->photo,
           'classe' => $request->classe,
           'niveau' => $request->niveau,
           'grade' => $request->grade

        ],[
            // 'numero_fixe' => 'required',
            // 'numero_portable'=> 'required',
         //    'adresse'=> 'required',
             'photo' => 'image',
             //'classe' => 'required|integer',
            // 'branche' => 'integer',
            // 'niveau' => 'required_with:branche|integer',
             'grade' => 'integer'
        ],
            [
               // 'numero_fixe.required' => "Le tel fixe est requis",
             //   'numero_portable.required' => "Le tel portable est requis",
             //   'adresse.required' => "L'adresse est requis",
                'photo.image' => "L'image doit etre de type valide JPEG\PNG",
               // 'branche.integer' => "vous devez choisir une branche",
              //  'niveau.integer' => "vous devez choisir un niveau",
               // 'classe.integer' => "vous devez choisir une classe",
                'grade.integer' => "vous devez choisir un niveau global",

            ]);
           if($validator->passes())
            {
                $niveau_global =  \Auth::user()->grades()->where('id',$request->grade)->first()->name;
                $enfant = Child::where('user_id',\Auth::user()->id)->where('id',$id)->first();
                $enfant->nationalite =\DB::table('countries')->where('id',$request->nationalite)->first()->nom_fr_fr;
                $enfant->save();
                if($niveau_global == 'Lycée')
                {
                    $enfant->branches()->sync([$request->branche]);
                }
                if($niveau_global == 'Maternelle' || $niveau_global == 'Primaire'
                    || $niveau_global == 'Collège' || $niveau_global == 'Lycée')
                {
                    $enfant->levels()->sync([$request->niveau]);
                }

              /*  if($niveau_global == 'Crèche')
                {
                    $enfant->classrooms()->sync([$request->classe]);
                }*/


               if($request->transport == 1)
               {
                 if(Transport::where('user_id',\Auth::user()->id)->first()->somme > 0)
                 {
                     $child = Child::where('user_id',\Auth::user()->id)->where('id',$id)->first();
                     $child->transport = 1;
                     $child->save();

                   }else{
                       return redirect()->back()->withErrors(["Vous n'avez pas encore précisé un prix pour le transport"]);
                   }
               }elseif($request->transport == 0)
               {
                   $child = Child::where('user_id',\Auth::user()->id)->where('id',$id)->first();
                       $child->transport = $request->transport;
                       $child->save();
               }
                $child->classrooms()->sync([$request->classe]);
               $family = Family::where('email_responsable',$request->em)->first();
                $family->adresse = $request->adresse;
                $family->numero_fixe  =$request->numero_fixe;
                $family->numero_portable = $request->numero_portable;
                $family->save();

                $image = $request->photo;
                if(isset($image) && !empty($image))
                {
                    $filename = $image->getClientOriginalName();
                    $path = public_path('uploads/' . $filename);
                    Image::make($image->getRealPath())->resize(313, 300)->save($path);
                    $child = Child::where('user_id',\Auth::user()->id)->where('id',$id)->first();
                    $child->photo = $filename;
                    $child->nationalite =\DB::table('countries')->where('id',$request->nationalite)->first()->nom_fr_fr;
                    $child->save();


                }else{
                    $pic = Child::findOrFail($id);
                    if(isset($pic->photo))
                    {
                        $filename = $pic->photo;
                    }else{
                        $filename = null;
                    }
                    $pic->photo = $filename;
                    $child->nationalite =\DB::table('countries')->where('id',$request->nationalite)->first()->nom_fr_fr;
                    $pic->save();
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



    public function getclassforcreche()
    {
        if(\Request::ajax())
        {
            $grade_id = \Input::get('grade_id');
            $grade = Grade::where('id', $grade_id)->first();
            foreach ($grade->classrooms as $cr) {
                echo '<option value="' . $cr->id . '">' . $cr->nom_classe . '</option>';

            }
        }
    }



 // supprimer par dropdown list ajax
    public function supprimer()
    {
        if(\Request::ajax())
        {
          $numbers = substr( \Input::get('boxes'),0,-1);
          $ids = explode(',',$numbers);
          $ids = array_unique($ids);
            foreach($ids as $id)
            {
              $child = Child::findOrFail($id);
                $child->bills()->delete();
                $child->attendances()->delete();
                $child->delete();
                if($child->trashed())
                {
                   $c=  Child::onlyTrashed()->findOrFail($id);
                    $c->bills()->forceDelete();
                    $c->attendances()->forceDelete();
                    $c->forceDelete();

                }
            }
        }
    }

 //  archiver par dropdown list ajax
    public function archiver()
    {
        if(\Request::ajax())
        {
            $numbers = substr( \Input::get('boxesarchives'),0,-1);
            $ids = explode(',',$numbers);
            $ids = array_unique($ids);
            foreach($ids as $id)
            {
                $child = Child::findOrFail($id);
                $child->bills()->delete();
                $child->attendances()->delete();
                $child->delete();
                if($child->trashed())
                {
                        echo 'oui';
                }
            }
        }
    }



    // delete a bill with click button
    public function delete($id)
    {
        $child =Child::findOrFail($id);
        $child->bills()->delete();
        $child->attendances()->delete();
           $child->delete();

        if($child->trashed())
        {
           $c = Child::onlyTrashed()->findOrFail($id);
            $c->bills()->forceDelete();
            $c->attendances()->forceDelete();
            $c->forceDelete();
        }
        return redirect('children')->with('success',"L'enfant a bien été supprimé");
    }
  // archive a bill with click button
    public function archive($id)
    {
        $child =Child::findOrFail($id);
        $child->bills()->delete();
        $child->attendances()->delete();
        $child->delete();

        if($child->trashed())
        {
            return redirect('children')->with('success',"L'enfant a bien été archivé");
        }

    }
    public function getage()
    {
        if(\Request::ajax())
        {
            $input = Input::get('inputd');
            $years =  Carbon::parse($input)->diffInYears(Carbon::now());
           $cats =  CategoryBill::where('user_id',\Auth::user()->id)->get();
            foreach($cats as $cat)
            {
                if($years >= $cat->age_de  && $years <= $cat->age_a)
                {
                    echo "Cet Elève de ". $years. " Ans Va payer ".$cat->prix .' Dhs';
                    break;
                }

            }



        }
    }
    public function total()
    {
        if(\Request::ajax())
        {
          $prix =  Input::get('prix');

          $trans =Transport::where('user_id',\Auth::user()->id)->exists();
            if($trans)
            {
               echo \Auth::user()->transport->somme + $prix;
            }
        }
    }
    public function checktransport()
    {
        if(\Request::ajax())
        {
            $trans =Transport::where('user_id',\Auth::user()->id)->exists();
            $details = Transport::where('user_id',\Auth::user()->id)->first();
            if($trans && $details->somme !== '')
            {
               echo 'oui';
            }
        }
    }

 // for registred families
    public function indexef()
    {
       return view('children.indexef');
    }

    public function showef($id)
    {
         $data='';
        foreach(Auth::user()->enfants as $enfant)
        {
          $data .=$enfant->id.',';
        }
       $data = explode(',',substr($data,0,-1));
        foreach($data as $d)
        {
            if($d == $id)
            {
              $child = Child::findOrFail($id);
                return view('children.showef',compact('child'));
            }
        }
        return  response('Unauthorized.', 401);
    }



    public function checkiffamily()
    {
        if(\Request::ajax())
        {
          $email =  \Input::get('email');


         $family =  Family::where('email_responsable',$email)
              ->where('user_id',\Auth::user()->id)->first();
            if($family)
            {
                echo json_encode($family);
               die();
             //   $count =  $family->children()->count();
               // echo  $family->nom_pere .' qui a '.$count. ' enfant(s)';

             /*   foreach($family->children as $enfant)
                {
                    echo ' ('.$enfant->nom_enfant.') ';
                }
                die();*/


            }

        }
    }

    public function checktoreturn(Request $request)
    {
             /* "email_resp" => "morethanchatter@gmail.com"
          "fix" => "0537451258"
          "portable" => "0663083611"
          "nom_pere" => "Hamid bouslami"
          "nom_mere" => "Samar fati"*/
         if(\Request::ajax())
         {
             $count = 0;
            $fix = Family::where('numero_fixe',$request->fix)->where('user_id',\Auth::user()->id)->first();
             if($fix)
                $count++;
             $portable = Family::where('numero_portable',$request->portable)->where('user_id',\Auth::user()->id)->first();
             if($portable)
                 $count++;
             $email = Family::where('email_responsable',$request->email_resp)->where('user_id',\Auth::user()->id)->first();
             if($email)
                 $count++;
             $pere = Family::where('nom_pere',$request->nom_pere)->where('user_id',\Auth::user()->id)->first();
             if($pere)
                 $count++;
             $mere = Family::where('nom_mere',$request->nom_mere)->where('user_id',\Auth::user()->id)->first();
             if($mere)
                 $count++;
             $cin = Family::where('cin','LIKE',$request->cin.'%')->where('user_id',\Auth::user()->id)->first();
               if($cin)
              $count++;
             if($count >=3)
             {
                 echo 'here';
             }
         }
    }

    /***********************Excel part ***********************
     * @param $ids
     */

    public function exportEleve($ids = null)
    {
        $ids =  explode(',',substr($ids,0,-1));
        $ids =   array_unique($ids);

            $model = Child::whereIn('id',$ids)->where('user_id', \Auth::user()->id)->get(['id','nom_enfant','created_at']);
            Excel::create('La liste des Elèves', function ($excel) use ($model) {
                $excel->sheet('La liste des Elèves', function ($sheet) use ($model) {
                        foreach ($model as $child) {
                                       $count = Bill::where('user_id',\Auth::user()->id)
                                       ->where('child_id',$child->id)
                                       ->where('status',0)
                                        ->count();
                            if ($count == 0) {
                                $child->status = 'Réglée';
                            } else {
                                $child->status = 'Non Réglée';
                            }
                            foreach($child->classrooms as $cr)
                            {
                                $child->classe = $cr->nom_classe;
                            }

                            $child->created_at = $child->created_at->toDateString();
                            $child->id ='';

                    }
                    $sheet->setWidth('A',0);
                    $sheet->setWidth('B',20);
                    $sheet->setWidth('C',20);
                    $sheet->setWidth('D',20);
                    $sheet->setWidth('E',20);
                    $sheet->fromModel($model);
                    $sheet->setStyle(array(
                        'font' => array(
                            'name'      =>  'Calibri',
                            'size'      =>  13,
                        )
                    ));
                    $sheet->setAllBorders('thin');
                    $sheet->setAutoFilter();
                    $sheet->cells('A1:E1',function($cells){
                      $cells->setBackground('#97efee');

                        $cells->setFont(array(
                            'family'     => 'Calibri',
                            'size'       => '14',
                            'bold'       =>  true
                        ));
                    });
                    $sheet->row(1, array('',
                        'Nom Elève', 'Date d\'inscription', 'Statut de Paiement ','Classe'
                    ));

                });
            })->export('xls');

    }


    /**
     * @param $ids
     */
    public function exportPdf($ids = null )
{
    $ids =  explode(',',substr($ids,0,-1));
    $ids =   array_unique($ids);

        $model = Child::whereIn('id',$ids)->where('user_id', \Auth::user()->id)->get(['id','nom_enfant','created_at']);
       Excel::create('La liste des Elèves', function ($excel) use ($model,$ids) {
            $excel->sheet('La liste des Elèves', function ($sheet) use ($model, $ids) {
                foreach ($model as $child) {
                    $child->time = $child->created_at->toDateString();
                    $count = Bill::where('user_id',\Auth::user()->id)
                        ->where('child_id',$child->id)
                        ->where('status',0)
                        ->count();
                    if ($count == 0) {
                        $child->status = 'Réglée';
                    } else {
                        $child->status = 'Non Réglée';
                    }
                    foreach($child->classrooms as $cr)
                    {
                        $child->classe = $cr->nom_classe;
                    }

                    unset($child->created_at);
                   unset($child->id);
                }


               // $sheet->setWidth('D',20);

                $sheet->fromModel($model);
                $sheet->setAllBorders('thin');
                $sheet->setFontFamily('OpenSans');
                $sheet->setFontSize(13);
                $sheet->setFontBold(false);

                for($i = 1; $i <= count($ids) + 1; $i++)
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
                    'Nom Elève','Date d\'inscription', 'Statut de Paiement', 'Classe'
                ));

            });

        })->export('pdf');

}



}
