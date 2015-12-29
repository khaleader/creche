<?php

namespace App\Http\Controllers;

use App\Bill;
use App\CategoryBill;
use App\Events\BillEvent;
use App\Events\SendEmailToRespAfterRegistrationEvent;
use App\Family;
use App\Child;
use App\Http\Requests\ajouterEnfantRequest;
use App\Transport;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
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
        $children = \Auth::user()->children()->paginate(10);
        return view('children.index', compact('children'));
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
    public function store(Requests\FormValidationChildFamilyRequest $request)
    {
        // famille for family profile
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
        $family->save();


        if ($family->id) {
            $father = Family::findOrFail($family->id);
            $child = new Child();
            $child->date_naissance = Carbon::parse($request->date_naissance);
            $child->transport = $request->transport;
            $child->sexe = $request->sexe;
            $child->nom_enfant = ucfirst($request->nom_enfant);
            $child->age_enfant = $child->date_naissance->diffInYears(Carbon::now());
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
                $child->family_id = $family->id;
                $child->save();
                if($child->id) {
                   $bill = new Bill();
                    $bill->start = Carbon::now()->toDateString();
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
                        str_random(6)
                    ));
                }

        }


       return redirect()->back()->with('success', "l'enfant et les parents ont bien été ajoutés! ");
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
                if($enfant->photo)
                   $photo =  asset('uploads/'.$enfant->photo);
                else
                    $photo =  asset('images/avatar4.jpg');

                echo ' <tr>
                            <td><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input type="checkbox" name="select[]" value="'.$enfant->id.'">

                                    </div>
                                </div></td>
                            <td><img class="avatar" src=" '. $photo .' "></td>
                            <td>'. $enfant->nom_enfant .'</td>
                            <td>'.  $enfant->date_naissance->format('d-m-Y') .' </td>
                            <td><span class="label '.$class.' label-mini"><i class="fa fa-money"></i></span></td>
                            <td>
                                <a href="#" class="actions_icons delete-child">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a class="archive-child" href="#"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>

                            <td><a href="'. action('ChildrenController@show',[$enfant->id]).'"><div  class="btn_details">Détails</div></a></td>
                        </tr>';
            }



          //  echo json_encode($enfants);
            //die();
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
       $child =  Child::findOrFail($id);
        if(!empty($child))
        {
         if($child->user_id == \Auth::user()->id)
         {
             return view('children.show',compact('child'));
         }
        }else{
            return  response('Unauthorized.', 401);
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
               if($request->transport == 1)
               {
                 if(Transport::where('user_id',\Auth::user()->id)->first()->somme > 0)
                 {
                  $child = Child::findOrFail($id);
                   if($child->transport == 0)
                   {
                    $bill = Bill::where('child_id',$child->id)->orderBy('id','desc')->first();
                       $bill->somme = ($bill->somme) + (Transport::where('user_id',\Auth::user()->id)->first()->somme);
                       $bill->save();
                       $child->transport = 1;
                       $child->save();
                    }
                   }else{
                       return redirect()->back()->withErrors(["Vous n'avez pas encore précisé un prix pour le transport"]);
                   }
               }elseif($request->transport == 0)
               {
                   $child = Child::findOrFail($id);
                   if($child->transport == 1)
                   {
                       // anuuler le transport
                       $bill = Bill::where('child_id',$child->id)->orderBy('id','desc')->first();
                       $bill->somme = ($bill->somme) - (Transport::where('user_id',\Auth::user()->id)->first()->somme);
                       $bill->save();
                       $child->transport = 0;
                       $child->save();
                   }
               }

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
                 $child =   Child::findOrFail($id);
                    $child->photo = $filename;
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
            $c->forceDelete();
        }
        return redirect('children')->with('success',"L'enfant a bien été supprimé");
    }
  // archive a bill with click button
    public function archive($id)
    {
        $child =Child::findOrFail($id);
        $child->bills()->delete();
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
                    echo "Cet Enfant de ". $years. " Ans Va payer ".$cat->prix .' Dhs';
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



}
