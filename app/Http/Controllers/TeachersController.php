<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherRequest;
use App\Matter;
use App\Teacher;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
use Validator;

class TeachersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $teachers = \Auth::user()->teachers()->paginate(10);
       return view('teachers.index',compact('teachers'));
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
    public function store(TeacherRequest $request)
    {

        if($request->fonction  == 'professeur')
        {
        $teacher = new Teacher();
        $teacher->nom_teacher = $request->nom_teacher;
        $teacher->date_naissance = $request->date_naissance;
        $teacher->poste = Matter::where('user_id',\Auth::user()->id)->where('id',$request->poste)->first()->nom_matiere;
        $teacher->fonction = $request->fonction;
        $teacher->sexe = $request->sexe;
        $teacher->email = $request->email;
        $teacher->num_fix = $request->num_fix;
        $teacher->num_portable = $request->num_portable;
        $teacher->adresse = $request->adresse;
        $teacher->cin = $request->cin;
        $teacher->salaire = $request->salaire;
        $teacher->user_id =  \Auth::user()->id;
        $teacher->save();
        if($teacher)
        {
            $teacher->matters()->sync([$request->poste]);
        }
        }else{
            $teacher = new Teacher();
            $teacher->nom_teacher = $request->nom_teacher;
            $teacher->date_naissance = $request->date_naissance;
            $teacher->poste = 'Ressources Humains';
            $teacher->fonction = $request->fonction;
            $teacher->sexe = $request->sexe;
            $teacher->email = $request->email;
            $teacher->num_fix = $request->num_fix;
            $teacher->num_portable = $request->num_portable;
            $teacher->adresse = $request->adresse;
            $teacher->cin = $request->cin;
            $teacher->salaire = $request->salaire;
            $teacher->user_id = \Auth::user()->id;
            $teacher->save();
        }
        return redirect()->back()->with('success',"Les Informations Ont Bien été Enregistrés ! ");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $teacher = Teacher::findOrFail($id);
        if(!empty($teacher))
        {
            if($teacher->user_id == \Auth::user()->id)
            {
                return view('teachers.show',compact('teacher'));
            }
        }else{
            return response('Unauthorized',401);
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
        $teacher = Teacher::findOrFail($id);
        if(\Auth::user()->id  == $teacher->user_id)
        {
            return view('teachers.edit',compact('teacher'));
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
            'num_fix' =>$request->num_fix,
            'num_portable' =>$request->num_portable,
            'adresse' => $request->adresse,
            'photo' => $request->photo

        ],[
            'num_fix' => 'required',
            'num_portable'=> 'required',
            'adresse'=> 'required',
            'photo' => 'image'
        ],
            [
                'num_fix.required' => "Le tel fixe est requis",
                'num_portable.required' => "Le tel portable est requis",
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
                 $teacher =  Teacher::findOrFail($id);
                 $teacher->photo = $filename;
                 $teacher->num_fix =$request->num_fix;
                 $teacher->num_portable =$request->num_portable;
                 $teacher->adresse =$request->adresse;
                 $teacher->save();
             }else{
                 $teacher = Family::findOrFail($id);
                 if(isset($teacher->photo))
                 {
                     $filename = $teacher->photo;
                 }else{
                     $filename = null;
                 }
                 $teacher->num_fix =$request->num_fix;
                 $teacher->num_portable =$request->num_portable;
                 $teacher->adresse =$request->adresse;
                 $teacher->photo = $filename;
                 $teacher->save();
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



    public function supprimer()
    {
        if(\Request::ajax())
        {
            $numbers = substr( \Input::get('boxes'),0,-1);
            $ids = explode(',',$numbers);
            $ids = array_unique($ids);
            foreach($ids as $id)
            {
                $teacher = Teacher::findOrFail($id);
                $teacher->delete();
                if($teacher->trashed())
                {
                    Teacher::onlyTrashed()->findOrFail($id)->forceDelete();
                }
            }
        }
    }

    public function archiver()
    {
        if(\Request::ajax())
        {
            $numbers = substr( \Input::get('boxesarchives'),0,-1);
            $ids = explode(',',$numbers);
            $ids = array_unique($ids);
            foreach($ids as $id)
            {
                $teacher = Teacher::findOrFail($id);
                $teacher->delete();
                if($teacher->trashed())
                {
                    echo 'oui';
                }
            }
        }
    }

    public function delete($id)
    {

        $teacher =Teacher::findOrFail($id);
        $teacher->delete();
        if($teacher->trashed())
        {
            Teacher::onlyTrashed()->findOrFail($id)->forceDelete();
        }
        return redirect('teachers')->with('success',"L'opération de suppression a été effectué avec succès");
    }
    public function archive($id)
    {
        $teacher =Teacher::findOrFail($id);
        $teacher->delete();
        if($teacher->trashed())
        {
            return redirect('teachers')->with('success',"L'opération d'archivage a été effectué avec succès");
        }
    }

    public function teacherbyalph()
    {
        if(\Request::ajax())
        {
            $caracter = Input::get('caracter');
            $teachers =   Teacher::where('nom_teacher', 'LIKE', $caracter .'%')
                ->where('user_id',\Auth::user()->id)
                ->get();
            foreach($teachers as $teacher)
            {
                if($teacher->photo)
                    $photo = asset('uploads/'.$teacher->photo);
                else
                    $photo = asset('images/no_avatar.jpg');
                echo '
                    <tr>
                            <td><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input type="checkbox" value="'. $teacher->id.' "  name="select[]">

                                    </div>
                                </div></td>
                            <td><img class="avatar" src="'. $photo .'"></td>
                            <td>'.  $teacher->nom_teacher .'</td>
                            <td>'. $teacher->poste .'</td>

                            <td>
                                <a href="'.action('TeachersController@delete',[$teacher->id]).'" class="actions_icons  delete-teacher">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <!--<a class="archive-teacher" href="'.action('TeachersController@archive',[$teacher->id]).'">
                                <i class="fa fa-archive liste_icons"></i>
                                </a>-->
                            </td>

                            <td><a href="'. action('TeachersController@show',[$teacher->id]) .'"><div  class="btn_details">Détails</div></a></td>
                        </tr>
                ';
            }



            //  echo json_encode($enfants);
            //die();
        }
    }

}
