<?php

namespace App\Http\Controllers;
use App\Child;
use App\Events\SchoolSendEmailEvent;
use App\Http\Requests\AddSchoolRequest;
use App\PriceBill;
use App\Profile;
use App\SchoolYear;
use App\Transport;
use App\User;
use App\CategoryBill;
use Carbon\Carbon;
use DB;
use Google_Client;
use Google_Service_Gmail;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use Validator;
use Intervention\Image\Facades\Image;

class SchoolsController extends Controller
{



    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('Famille',['only'=> 'editef','updatepassef','upimage']);
        $this->middleware('oblivius',['except'=> ['edit','update','updatepass','category','show_price_bills',
            'price_bills_store','promotion','gestion_users','check_gestion_users',
            'show_cat_bills','editef','updatepassef','upimage','upimageecole','profile','editer']]);


    }


    public function boite()
    {
        $client = new Google_Client();
        $client->setClientId('548520090024-i8jmtdmdi5ijvj3mn2sbqe2u3a431gh6.apps.googleusercontent.com');
        $client->setClientSecret('IX-SilXd0ctCrKUX1a5oP9is');
        $client->setRedirectUri('http://petite-enfance.oblivius.fr/schools/boite');
        $client->addScope('https://mail.google.com');
        $service = new Google_Service_Gmail($client);
       return view('schools.boite')->with(['client'=> $client, 'service'=> $service]);
    }


    public function promotion()
    {

       $total =  SchoolYear::countTotalYear();
        return view('schools.promotion',compact('total'));
    }


    // check password of admin
    public function check_gestion_users()
    {
        if(\Request::ajax())
        {
            $pass = \Input::get('pass');
            $rh_id = \Input::get('id_rh');
                if(isset($pass) && !empty($pass))
                {

                    $user = \Auth::user()->teachers()
                        ->where('fonction','Administrateur')->where('pass',$pass)->first();
                    if($user)
                    {
                        echo 'oui';
                    }else{
                        echo 'no';
                    }
                }

            // delete
            if(isset($rh_id) && !empty($rh_id))
            {
              $rh_user =  \Auth::user()->teachers()
                    ->where('fonction','rh')->where('id',$rh_id)->first();
                $rh_user->pass = null;
                $rh_user->save();
                echo 'deleted';
            }


        }
    }

    public function gestion_users(Request $request, $id = null)
    {
          if(\Request::isMethod('get'))
          {

              if($id == \Auth::user()->id)
              {
                  return view('schools.gestion_schools');
              }
          }elseif(\Request::isMethod('post'))
          {
              $validator = Validator::make($request->all(),[
                  'rh' => 'required',
                  'pass' => 'required|min:6|confirmed',
              ],[
                  'pass.required'=>'Le champ Clé d\'utilisation  est Requis',
                  'pass.min' => 'Le champ Clé d\'utilisation doit avoir au minimum 6 caractères',
                  'pass.confirmed' => "la confirmation n'est pas identique  ",
                  'rh.required' => "L'utilisateur est requis"

              ]);

              if($validator->passes())
              {
                  $rh = $request->rh;

                 $user = \Auth::user()->teachers()
                      ->where('id',$rh)
                      ->first();
                 if($user)
                 {
                     $user->pass = $request->pass;
                     $user->save();
                 }
                  return redirect()->back()->with('success',"La Clé a bien été enregistré");

              }else{
                  return redirect()->back()->withErrors($validator);
              }

          }


    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $ecoles = User::where('type','ecole')->paginate(10);
        return view('schools.index',compact('ecoles'));
    }

    public function schoolbyalph()
    {
        if(\Request::ajax())
        {
            $caracter = Input::get('caracter');
            $ecoles =   User::where('type','ecole')
                -> where('name', 'LIKE', $caracter .'%')
                ->get();
            foreach($ecoles as $ecole)
            {
                echo '<tr>
                            <td><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input value="'. $ecole->id .'" type="checkbox" name="select[]" >

                                    </div>
                                </div></td>
                            <td>'.$ecole->name.'</td>
                            <td>'.$ecole->created_at->format('d-m-Y') .'</td>
                            <td><span class="label label-success label-mini"><i class="fa fa-money"></i></span></td>
                            <td>
                                <a href="#" class="actions_icons">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a href="#"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>

                            <td><a href="'.action('SchoolsController@show',[$ecole->id]).'"><div  class="btn_details">Détails</div></a></td>
                        </tr> ';
            }

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('schools.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddSchoolRequest $request)
    {
        event(new SchoolSendEmailEvent(
            $request->nom_ecole,
            'ecole',
            $request->email_ecole,
            str_random(6),
            $request->nom_responsable,
            $request->tel_fix,
            $request->tel_por,
            $request->ecole_adresse,
            $request->ecole_ville,
            $request->country,
            $request->typeCompte,
            $request->sexe
        ));
        return redirect()->back()->with('success','Bien enregistré');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $ecole = User::findOrFail($id);
        if($ecole->type == 'ecole')
        {
            return view('schools.show',compact('ecole'));
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
        $school = User::findOrFail($id);
        if($school->type == 'ecole' && $school->id == \Auth::user()->id)
        {
            return view('schools.edit',compact('school'));
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
        $validator = Validator::make($request->all(),[
            'nom_responsable' => 'required',
            'tel_fixe' => 'required',
            'tel_portable'=> 'required',
            'adresse'=> 'required',
            'ville'=> 'required'
        ]);
        if($validator->passes())
        {
          /*  $image = $request->photo;
            if(isset($image))
            {
                $filename = $image->getClientOriginalName();
                $path = public_path('uploads/' . $filename);
                Image::make($image->getRealPath())->resize(313, 300)->save($path);
            }else{
                $pic = User::where('id',\Auth::user()->id)->first();
                if(isset($pic->photo))
                {
                    $filename = $pic->photo;
                }else{
                    $filename = null;
                }
            }*/
            $check = User::where('id',\Auth::user()->id)->first();
            if($check)
            {
                $user =  \Auth::user();
                $user->name = $request->name;
                $user->nom_responsable = $request->nom_responsable;
                $user->tel_fixe = $request->tel_fixe;
                $user->tel_portable = $request->tel_portable;
                $user->email = $request->email;
                $user->adresse = $request->adresse;
                $user->ville = $request->ville;
                $user->save();
                return redirect()->back()->with('success','Les Informations Ont bien été Enregistrés');
            }
        }else{
            return redirect()->back()->withErrors($validator);
        }



    }

    public function upimageecole(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'photo' => 'image|required',
        ],      [
            'photo.required'=>'Vous devez insérer une image',
            'photo.image' => "le type de l'image doit etre valide JPEG\PNG"
        ]);

        if($validator->passes())
        {
            $image = $request->photo;
            if(isset($image) && !empty($image))
            {
                $filename = $image->getClientOriginalName();
                $path = public_path('uploads/' . $filename);
                Image::make($image->getRealPath())->resize(313, 300)->save($path);
                $user =  User::findOrFail(\Auth::user()->id);
                $user->photo = $filename;
                $user->save();
                return redirect()->back()->with('success','L\'Image a bien été Modifée');
            }
        }else{
            return redirect()->back()->withErrors($validator);
        }
    }



    public function profile(Request $request,$id = null)
    {
        if(\Request::isMethod('get'))
        {
            return view('schools.profile');
        }else{
          $a_user = User::where('id',\Auth::user()->id)->first();
            $a_user->name  = $request->name;
            $a_user->nom_responsable  = $request->nom_responsable;
            $a_user->tel_fixe  = $request->tel_fixe;
            $a_user->adresse  = $request->adresse;
            $a_user->ville  = $request->ville;
            $a_user->save();

            $image = $request->photo;
            if(isset($image) && !empty($image))
            {
                $filename = $image->getClientOriginalName();
                $path = public_path('uploads/' . $filename);
                Image::make($image->getRealPath())->resize(313, 300)->save($path);
                $user = User::where('id',\Auth::user()->id)->where('id',$id)->first();
                $user->photo = $filename;
                $user->save();
            }else{
                $pic = User::findOrFail(\Auth::user()->id);
                if(isset($pic->photo))
                {
                    $filename = $pic->photo;
                }else{
                    $filename = null;
                }
                $pic->photo = $filename;
                $pic->save();
            }




            $profile =  Profile::where('user_id',\Auth::user()->id)->first();
          $profile->site_web = $request->site_web;
            $profile->page_facebook = $request->page_facebook;
            $profile->patente = $request->patente;
            $profile->registre_du_commerce = $request->registre_du_commerce;
            $profile->identification_fiscale = $request->identification_fiscale;
            $profile->cnss = $request->cnss;
            $profile->rib = $request->rib;
            $profile->ice = $request->ice;
            $profile->save();
             return redirect()->back()->with('success','Modifications réussies');
        }

    }


    public function editer($id)
    {

          return view('schools.editer');
    }

    public function updatepass(Request $request)
    {
      $validator = Validator::make($request->all(),[
           'actualpass' => 'required|min:6',
          'password' => 'required|min:6|confirmed'
       ],[
          'actualpass.required'=>'Le champ Mot de Pass actuel est Requis',
          'actualpass.min' => 'Le password doit avoir au minimum 6 caractères',
          'password.min' => 'Le Nouveau mot de pass  doit avoir au minimum 6 caractères'
      ]);
        if($validator->passes())
        {
          if(\Hash::check($request->actualpass ,\Auth::user()->getAuthPassword()))
        {
           $user =  User::findOrFail(\Auth::user()->id);
             $user->password =  \Hash::make($request->password);
            $user->save();
           return redirect()->back()->with('success','Le Mot De pass a bien été modifié !');
        }else{
           return redirect()->back()->withErrors([
               'Le Mot de pass Actuel est incorrect'
           ]);
          }
        }else{
            return redirect()->back()->withErrors($validator);
        }
    }


    public function  category(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'age_de' => 'required|integer|min:0',
            'age_a' => 'required|integer|greater_than_field:age_de',
            'prix' => 'required',
            'categories' => 'required|integer'
        ],[

            'age_de.integer'=>"L'age De doit etre un nombre entier",
            'age_a.integer'=>"L'age A doit etre un nombre entier",
            'prix.required'=>"Le prix de Catégorie est requis",
            'categories.required' => 'Vous devez choisir une Catégorie',
            'categories.integer' => 'Vous devez choisir une Catégorie',
            'age_a.greater_than_field' => "le champ Age de doit etre strictement Inférieur à Age A "
        ]);
        if($validator->passes())
        {
            $cat = CategoryBill::where('name',$request->categories)->where('user_id',\Auth::user()->id)->get();
            $trans = Transport::where('user_id',\Auth::user()->id)->get();
            if(!$trans->isEmpty())
            {
                foreach($trans as $t)
                {
                    $t->somme = $request->somme;
                    $t->save();
                }
            }
            else{
                Transport::create([
                    'somme' => $request->somme,
                    'user_id' => \Auth::user()->id
                ]);
            }

            if(!$cat->isEmpty())
            {
                foreach($cat as $c)
                {
                    $c->age_de = $request->age_de;
                    $c->age_a = $request->age_a;
                    $c->prix = $request->prix;
                    $c->save();
                }
            }else{
                $newcat = new CategoryBill();
                $newcat->user_id = \Auth::user()->id;
                $newcat->name = $request->categories;
                $newcat->age_de = $request->age_de;
                $newcat->age_a = $request->age_a;
                $newcat->prix = $request->prix;
                $newcat->save();

            }
            return redirect()->back()->with('success','Bien Enregistré dans la base de données');
        }else{
            return redirect()->back()->withErrors($validator);
        }

    }




    // show categories bills ajax

    public function show_cat_bills()
    {
        if(\Request::ajax())
        {
           $cat =  Input::get('cat');
          $check =  CategoryBill::where('user_id',\Auth::user()->id)->where('name',$cat)->get();
            if(!$check->isEmpty())
            {
                foreach($check as $c)
                {
                    echo json_encode($c);
                    die();
                }

            }else{
                $tab = [
                  'age_de'=> 0,
                    'age_a' => 0,
                    'prix' => 0
                ];
                echo json_encode($tab);
                die();
            }

        }
    }


    /**
     *
     */
    public function show_price_bills()
    {
        if(\Request::ajax())
        {
            $niveau_id =  Input::get('niveau_id');
            $checkPrice =  PriceBill::where('user_id',\Auth::user()->id)
                ->where('niveau',$niveau_id)
                ->where('ann_scol','2015-2016')
                 ->first();
            if($checkPrice)
            {
                echo json_encode($checkPrice);
                die();
            }else{
                $tab = [
                    'prix'=> '',

                ];
                echo json_encode($tab);
                die();
            }
        }
    }


    public function price_bills_store(Request $request)
    {
        $trans = Transport::where('user_id',\Auth::user()->id)->first();
        if($trans)
        {

            $trans->somme = $request->somme;
            $trans->save();

        }
        else{
            Transport::create([
                'somme' => $request->somme,
                'user_id' => \Auth::user()->id
            ]);
        }

        $niveau_id = $request->niveau;
        $price = $request->price;
        $user_id = \Auth::user()->id;
        $ann_scol = '2015-2016';


        $checkPrice =  PriceBill::where('user_id',$user_id)
            ->where('niveau',$niveau_id)
            ->where('ann_scol',$ann_scol)
            ->first();
        if($checkPrice)
        {
            $checkPrice->prix = $price;
            $checkPrice->save();
        }else{
            $priceBill = new PriceBill();
            $priceBill->niveau = $niveau_id;
            $priceBill->prix = $price;
            $priceBill->ann_scol = $ann_scol;
            $priceBill->user_id = $user_id;
            $priceBill->save();
        }
        return redirect()->back()->with('success','Bien enregistré');
    }





    public function editef($id)
    {
      if(\Auth::user() && \Auth::user()->isFamily())
      {
         $school = User::findOrFail($id);
          return view('schools.editef',$school);
      }
    }

    public function updatepassef(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'actualpass' => 'required|min:6',
            'password' => 'required|min:6|confirmed',
        ],[
            'actualpass.required'=>'Le champ Mot de Pass actuel est Requis',
            'actualpass.min' => 'Le password doit avoir au minimum 6 caractères',
            'password.min' => 'Le Nouveau mot de pass  doit avoir au minimum 6 caractères',
        ]);
        if($validator->passes())
        {

            if(\Hash::check($request->actualpass ,\Auth::user()->getAuthPassword()))
            {
                $user =  User::findOrFail(\Auth::user()->id);
                $user->password =  \Hash::make($request->password);
                $user->save();
                return redirect()->back()->with('success','Modifications réussies');
            }else{
                return redirect()->back()->withErrors([
                    'Le Mot de pass Actuel est incorrect'
                ]);
            }
        }else{
            return redirect()->back()->withErrors($validator);
        }
    }

    // upload image compte famille with ajax
    public function upimage(Request $request)
    {
     $validator = Validator::make($request->all(),
        ['photo'=>'image|required'],
            [
                'photo.required'=>'Vous devez insérer une image',
                'photo.image' => "le type de l'image doit etre valide JPEG\PNG"
            ]
            );
        if($validator->passes())
        {
            $image = $request->photo;
            if(isset($image) && !empty($image))
            {
                $filename = $image->getClientOriginalName();
                $path = public_path('uploads/' . $filename);
                Image::make($image->getRealPath())->resize(313, 300)->save($path);
                $user =  User::findOrFail(\Auth::user()->id);
                $user->photo = $filename;
                $user->save();
                return redirect()->back()->with('success','L\'Image a bien été Modifée');
            }/*else{
                $pic = User::where('id',\Auth::user()->id)->where('type','famille')->first();
                if(isset($pic->photo))
                {
                    $filename = $pic->photo;
                }else{
                    $filename = null;
                }
            }*/

        }else{
            return redirect()->back()->withErrors($validator);
        }



      // dd($request->all());
       // return redirect()->back();

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


    // delete schools
    public function deleteSchools()
    {
        if(\Request::ajax())
        {
            $numbers = substr(Input::get('schools'),0,-1);
            $ids = explode(',',$numbers);
            $ids = array_unique($ids);
            foreach($ids as $id)
            {
                $school = User::where('type','ecole')->where('id',$id)->first();
                $school->lesgamins()->delete(); // archive only due to soft delete
                foreach($school->lesfamilles as $f)
                {
                    $famille = User::where('email',$f->email_responsable)->first();
                    if(!is_null())
                    {
                        $famille->delete();
                    }

                }
                $school->lesfamilles()->delete(); // archive only due to soft delete
                $school->lesfactures()->delete();// archive only due to soft delete
                $school->lespointages()->delete();// archive only due to soft delete
                 $school->lesteachers()->delete();// archive only due to soft delete
                $school->lesgamins()->forceDelete(); // real delete
                $school->lesfamilles()->forceDelete();// real delete
                $school->lesfactures()->forceDelete();// real delete
                $school->lespointages()->forceDelete();// real delete
                $school->lesteachers()->forceDelete();// real delete

                 $school->lescategoriesbills()->delete(); // -> direct delete
                 $school->letransport()->delete(); // -> direct delete
                 $school->lesmatieres()->delete(); // -> direct delete
                 $school->lesbranches()->delete(); // -> direct delete
                 $school->lesrooms()->delete(); // -> direct delete
                 $school->lesclassrooms()->delete(); // -> direct delete
                $school->leslevels()->delete(); // -> direct delete
                $school->grades()->delete();  // -> direct delete
                $school->occasions()->delete();  // -> direct delete
                $school->buses()->delete();
                $school->profile()->delete();
                $school->pricebills()->delete();
                $school->PromotionsStatuses()->delete();
                $school->schoolyears()->delete();
                $school->PromotionsAdvances()->delete();
                $school->PromotionsExceptionals()->delete();


                DB::table('classroom_matter_teacher')->where('user_id',$school->id)->delete(); // -> direct download
                 $school->lestimesheets()->delete(); // -> direct delete

                // the last part is to delete The School
              $school->delete();
            }
        }
    }


    public function bloquer()
    {
     if(\Request::ajax())
     {
         $numbers = substr(Input::get('blocked'),0,-1);
         $ids = explode(',',$numbers);
         $ids = array_unique($ids);
         foreach($ids as $id)
         {
             $school = User::where('type','ecole')->where('id',$id)->first();
             $school->blocked = 1;
             $school->save();
         }
     }
    }
    public function debloquer()
    {
        if(\Request::ajax())
        {
            $numbers = substr(Input::get('nblocked'),0,-1);
            $ids = explode(',',$numbers);
            $ids = array_unique($ids);
            foreach($ids as $id)
            {
                $school = User::where('type','ecole')->where('id',$id)->first();
                $school->blocked = 0;
                $school->save();
            }
        }
    }


    public function offess()
    {
        if(\Request::ajax())
        {
            $status = \Input::get('status');
            if ($status == 0) {
                $schools = User::where('type','ecole')
                ->where('typeCompte', 0)->get();

                foreach ($schools as $ecole) {
                    if($ecole->blocked == 0)
                        $block = '<i class="fa fa-unlock fa-3x liste_icons"></i>';
                    else
                        $block = ' <i class="fa fa-lock fa-3x liste_icons"></i>';
                    echo '     <tr>
                            <td><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input value=" '.$ecole->id.'" type="checkbox" name="select[]" >

                                    </div>
                                </div></td>
                            <td>'. $ecole->name.'</td>
                            <td>'. Carbon::parse($ecole->created_at)->format('d-m-Y') .' </td>
                            <td>
                              Essai

                            </td>
                            <td>'.$block.'</td>
                            <td><span class="label label-success label-mini"><i class="fa fa-money"></i></span></td>
                            <td>
                                <a href="'.action('SchoolsController@delete',[$ecole]).'" class="actions_icons delete-school">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a href="#"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>

                            <td><a href="'. action('SchoolsController@show',[$ecole->id]) .'"><div  class="btn_details">Détails</div></a></td>
                        </tr>';
                }

            }else {
                $schools = User::where('type', 'ecole')
                    ->where('typeCompte', 1)->get();

                foreach ($schools as $ecole) {
                    if($ecole->blocked == 0)
                        $block = '<i class="fa fa-unlock fa-3x liste_icons"></i>';
                    else
                        $block = ' <i class="fa fa-lock fa-3x liste_icons"></i>';
                    echo '     <tr>
                            <td><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input value=" ' . $ecole->id . '" type="checkbox" name="select[]" >

                                    </div>
                                </div></td>
                            <td>' . $ecole->name . '</td>
                            <td>' . Carbon::parse($ecole->created_at)->format('d-m-Y') . ' </td>
                            <td>
                              Officiel

                            </td>
                                 <td>'.$block.'</td>
                            <td><span class="label label-success label-mini"><i class="fa fa-money"></i></span></td>
                            <td>
                                <a href="'.action('SchoolsController@delete',[$ecole]).'" class="actions_icons delete-school">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a href="#"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>

                            <td><a href="' . action('SchoolsController@show', [$ecole->id]) . '"><div  class="btn_details">Détails</div></a></td>
                        </tr>';
                }
            }
        }
    }


    public function delete($id)
    {
        $school = User::where('type','ecole')->where('id',$id)->first();
        $school = User::where('type','ecole')->where('id',$id)->first();
        $school->lesgamins()->delete(); // archive only due to soft delete
        foreach($school->lesfamilles as $f)
        {
            $famille = User::where('email',$f->email_responsable)->first();
            if(!is_null($famille))
            {
                $famille->delete();
            }

        }
        $school->lesfamilles()->delete(); // archive only due to soft delete
        $school->lesfactures()->delete();// archive only due to soft delete
        $school->lespointages()->delete();// archive only due to soft delete
        $school->lesteachers()->delete();// archive only due to soft delete
        $school->lesgamins()->forceDelete(); // real delete
        $school->lesfamilles()->forceDelete();// real delete
        $school->lesfactures()->forceDelete();// real delete
        $school->lespointages()->forceDelete();// real delete
        $school->lesteachers()->forceDelete();// real delete

        $school->lescategoriesbills()->delete(); // -> direct delete
        $school->letransport()->delete(); // -> direct delete
        $school->lesmatieres()->delete(); // -> direct delete
        $school->lesbranches()->delete(); // -> direct delete
        $school->lesrooms()->delete(); // -> direct delete
        $school->lesclassrooms()->delete(); // -> direct delete
        $school->leslevels()->delete(); // -> direct delete
        $school->grades()->delete();  // -> direct delete
        $school->occasions()->delete();  // -> direct delete
        $school->profile()->delete();
        $school->buses()->delete();
        $school->pricebills()->delete();
        $school->PromotionsStatuses()->delete();
        $school->schoolyears()->delete();
        $school->PromotionsAdvances()->delete();
        $school->PromotionsExceptionals()->delete();


        DB::table('classroom_matter_teacher')->where('user_id',$school->id)->delete(); // -> direct download
        $school->lestimesheets()->delete(); // -> direct delete


        // the last part is to delete The School
        $school->delete();
        return redirect()->to('schools')->with('success',"La suppression a bien été effectuée");

    }

}
