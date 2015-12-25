<?php

namespace App\Http\Controllers;
use App\Events\SchoolSendEmailEvent;
use App\Http\Requests\AddSchoolRequest;
use App\Transport;
use App\User;
use App\CategoryBill;
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
        $this->middleware('Famille',['only'=> 'editef']);
        $this->middleware('oblivius',['except'=> ['edit','update','updatepass','category','show_cat_bills','editef']]);


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
           $request->country
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
            'ville'=> 'required',
            'pays'=> 'required',
        ]);
        if($validator->passes())
        {
            $image = $request->photo;
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
            }
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
                $user->photo = $filename;
                $user->save();
                return redirect()->back()->with('success','Les Informations Ont bien été Enregistrés');
            }
        }else{
            return redirect()->back()->withErrors($validator);
        }



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
           return redirect()->back()->with('success','Le Mot De pass a bien été modifié');
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
            'age_de' => 'required|integer',
            'age_a' => 'required|integer',
            'prix' => 'required',
            'categories' => 'required|integer'
        ],[

            'age_de.integer'=>"L'age De doit etre un nombre entier",
            'age_a.integer'=>"L'age A doit etre un nombre entier",
            'prix.required'=>"Le prix de Catégorie est requis",
            'categories.required' => 'Vous devez choisir une Catégorie',
            'categories.integer' => 'Vous devez choisir une Catégorie',
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

    public function editef($id)
    {
      if(\Auth::user() && \Auth::user()->isFamily())
      {
         $school = User::findOrFail($id);
          return view('schools.editef',$school);
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
}
