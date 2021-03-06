<?php

namespace App\Http\Controllers;

use App\Family;
use App\Http\Requests\TeacherRequest;
use App\Matter;
use App\Teacher;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;
use URL;
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
       $teachers = \Auth::user()->teachers()->whereNotIn('fonction',['Administrateur'])->paginate(10);
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
    public function store(TeacherRequest  $request)
    {
        if($request->fonction  == 'professeur' && !$request->admin)
        {
        $teacher = new Teacher();
        $teacher->nom_teacher = $request->nom_teacher;
        $teacher->date_naissance = $request->date_naissance;
        $teacher->poste = Matter::where('user_id',\Auth::user()->id)->where('id',$request->poste)->first()->nom_matiere;
        $teacher->fonction = $request->fonction;
        $teacher->sexe = $request->sexe;
        $teacher->nationalite =\DB::table('countries')->where('id',$request->nationalite)->first()->nom_fr_fr;
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
        }elseif($request->fonction == 'rh' && !$request->admin){
            $teacher = new Teacher();
            $teacher->nom_teacher = $request->nom_teacher;
            $teacher->date_naissance = $request->date_naissance;
            $teacher->poste = 'Ressources Humains';
            $teacher->fonction = $request->fonction;
            $teacher->sexe = $request->sexe;
            $teacher->email = $request->email;
            $teacher->num_fix = $request->num_fix;
            $teacher->num_portable = $request->num_portable;
            $teacher->nationalite =\DB::table('countries')->where('id',$request->nationalite)->first()->nom_fr_fr;
            $teacher->adresse = $request->adresse;
            $teacher->cin = $request->cin;
            $teacher->salaire = $request->salaire;
            $teacher->user_id = \Auth::user()->id;
            $teacher->save();
        }else{
            $teacher = new Teacher();
            $teacher->nom_teacher = $request->nom_teacher;
            $teacher->date_naissance = $request->date_naissance;
            $teacher->poste = 'Ressources Humains';
            $teacher->fonction = 'Administrateur';
            $teacher->sexe = $request->sexe;
            $teacher->email = $request->email;
            $teacher->num_fix = $request->num_fix;
            $teacher->num_portable = $request->num_portable;
            $teacher->nationalite =\DB::table('countries')->where('id',$request->nationalite)->first()->nom_fr_fr;
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
            'photo' => $request->photo,
            'salaire' => $request->salaire

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
                 $teacher->nationalite =\DB::table('countries')->where('id',$request->nationalite)->first()->nom_fr_fr;

                 $teacher->adresse =$request->adresse;
                 $teacher->salaire = $request->salaire;
                 $teacher->save();
             }else{
                 $teacher = Teacher::findOrFail($id);
                 if(isset($teacher->photo))
                 {
                     $filename = $teacher->photo;
                 }else{
                     $filename = null;
                 }
                 $teacher->num_fix =$request->num_fix;
                 $teacher->num_portable =$request->num_portable;
                 $teacher->adresse =$request->adresse;
                 $teacher->nationalite =\DB::table('countries')->where('id',$request->nationalite)->first()->nom_fr_fr;
                 $teacher->salaire = $request->salaire;
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
                            <td class="no-print"><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input type="checkbox" value="'. $teacher->id.' "  name="select[]">

                                    </div>
                                </div></td>
                            <td><img class="avatar" src="'. $photo .'"></td>
                            <td>'.  $teacher->nom_teacher .'</td>
                            <td>'. $teacher->poste .'</td>

                            <td class="no-print">
                                <a href="'.action('TeachersController@delete',[$teacher->id]).'" class="actions_icons  delete-teacher">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <!--<a class="archive-teacher" href="'.action('TeachersController@archive',[$teacher->id]).'">
                                <i class="fa fa-archive liste_icons"></i>
                                </a>-->
                            </td>

                            <td class="no-print"><a href="'. action('TeachersController@show',[$teacher->id]) .'"><div  class="btn_details">Détails</div></a></td>
                        </tr>
                ';
            }



            //  echo json_encode($enfants);
            //die();
        }
    }


    /**
     * @param $ids
     */
    public function exportExcel($ids = null)
    {
        $ids =  explode(',',substr($ids,0,-1));
        $ids =   array_unique($ids);

            $model = Teacher::whereIn('id',$ids)->where('user_id', \Auth::user()->id)->get(['nom_teacher','fonction','poste']);
            Excel::create('La liste des Professeurs et RH', function ($excel) use ($model) {
                $excel->sheet('La liste des Professeurs et RH', function ($sheet) use ($model) {

                    $sheet->fromModel($model);
                    $sheet->setStyle(array(
                        'font' => array(
                            'name'      =>  'Calibri',
                            'size'      =>  13,
                        )
                    ));
                    $sheet->setAllBorders('thin');
                    $sheet->cells('A1:C1',function($cells){
                        $cells->setBackground('#97efee');

                        $cells->setFont(array(
                            'family'     => 'Calibri',
                            'size'       => '14',
                            'bold'       =>  true
                        ));
                    });
                    $sheet->row(1, array(
                         'Nom Complet', 'Fonction','Poste'
                    ));

                });
            })->export('xls');

    }

    public function exportPdf($ids = null)
    {
        $ids =  explode(',',substr($ids,0,-1));
        $ids =   array_unique($ids);

            $model = Teacher::whereIn('id',$ids)->where('user_id', \Auth::user()->id)->get(['nom_teacher','fonction','poste']);
            Excel::create('La liste des Professeurs et RH', function ($excel) use ($model, $ids) {
                $excel->sheet('La liste des Professeurs et RH', function ($sheet) use ($model, $ids) {

                    $sheet->fromModel($model);
                    $sheet->setAllBorders('thin');
                    $sheet->setFontFamily('OpenSans');
                    $sheet->setFontSize(13);
                    $sheet->setFontBold(false);
                    $sheet->setAllBorders('thin');


                    for($i = 1; $i <= count($ids) +1 ; $i++)
                    {
                        $sheet->setHeight($i, 25);
                        $sheet->row($i,function($rows){
                            $rows->setFontColor('#556b7b');
                            $rows->setAlignment('center');
                        });


                        $sheet->cells('A'.$i.':'.'C'.$i,function($cells){
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
                    $sheet->cells('A1:C1',function($cells){
                        $cells->setBackground('#e9f1f3');
                        $cells->setFontColor('#556b7b');
                        $cells->setFont(array(
                            'family'     => 'OpenSans',
                            'size'       => '15',
                            'bold'       =>  true,
                        ));

                    });



                    $sheet->row(1, array(
                        'Nom Complet', 'Fonction','Poste'
                    ));

                });
            })->export('pdf');

    }

}
