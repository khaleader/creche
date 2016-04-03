<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Child;
use App\Classroom;
use App\Level;
use App\Matter;
use App\SchoolYear;
use App\Timesheet;
use DB;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use URL;
use Validator;

class ClassroomsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        $this->middleware('Famille',['only'=>['indexef','showef']]);
        $this->middleware('auth');
        $this->middleware('admin',['except'=>['indexef','showef']]);
    }
    public function index()
    {
        $classrooms = Classroom::where('user_id',\Auth::user()->id)->CurrentYear()->paginate(10);
        $branches = Branch::where('user_id',\Auth::user()->id)->get();
        $niveaux = Level::where('user_id',\Auth::user()->id)->get();
        return view('classrooms.index')->with([
            'classrooms' => $classrooms,
            'branches' => $branches,
            'niveaux' => $niveaux
        ]);
    }

    public function indexelc($id)
    {
        $cr =Classroom::where('user_id',\Auth::user()->id)->where('id',$id)->first();
        $id =  Classroom::where('user_id',\Auth::user()->id)->where('id',$id)->first();
        $classroom = $cr->children()->CurrentYear()->paginate(10);
        return view('classrooms.indexelc',compact('classroom','id'));
    }


    /*index tri */
    public function getLevel()
    {
        if(\Request::ajax())
        {
            $niveau_id = \Input::get('niveau_id');
            $level = Level::where('id',$niveau_id)->first();
            foreach($level->branches->unique() as $branch)
            {
                echo '<li><a class="branch" data-id="'. $branch->id .'" href="#">'. $branch->nom_branche .'</a></li>';

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
       $matieres = Matter::where('user_id',\Auth::user()->id)->get();
        return view('classrooms.create',compact('matieres'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {



        $validator = Validator::make([
            $request->all(),
            'nom_classe' =>$request->nom_classe,
            'code_classe' =>$request->code_classe,
            'capacite_classe' =>$request->capacite_classe,
            'niveau' =>$request->niveau,
            'branche' => $request->branche,
            'grade' => $request->grade


        ],[
            'nom_classe' => 'required',
            'code_classe'=> 'required',
            'capacite_classe' => 'required|integer',
            'grade' => 'required|integer',

        ],
            [
                'nom_classe.required' => "le nom de la classe est requis",
                'code_classe.required' => "le Code de la classe est requis",
                'capacite_classe.required' => "la capacité de la classe est requis",
                'capacite_classe.integer' => "la capacité de la classe doit etre un nombre entier",
                'niveau.integer' => "Le Niveau est requis",
                'grade.integer' => "Le Niveau Global est requis",
            ]);




        if($validator->passes())
        {
            $niveau_global =  \Auth::user()->grades()->where('id',$request->grade)->first()->name;
             $cr = new Classroom();
            $cr->nom_classe = $request->nom_classe;
            $cr->code_classe = $request->code_classe;
            $cr->capacite_classe = $request->capacite_classe;

            $cr->niveau = $request->niveau;
            $cr->school_year_id = SchoolYear::getSchoolYearId();


            if($niveau_global == 'Lycée')
            {
                $cr->branche = $request->branche;
            }else{
                $cr->branche ='';
            }

            $cr->user_id = \Auth::user()->id;
            $cr->save();

           $ts = new Timesheet();
            $ts->user_id = \Auth::user()->id;
            $ts->classroom_id  = $cr->id;
            $ts->school_year_id = SchoolYear::getSchoolYearId();
            $ts->save();

          $level = Level::find($request->niveau);
            if($niveau_global == 'Lycée')
            {
                DB::table('branch_classroom_level')->insert([
                    'classroom_id' => $cr->id,
                    'branch_id' => $request->branche,
                    'level_id'=> $level->id
                ]);
            }
            else{
                $level->lesClasses()->attach([$cr->id]);
            }
           if($cr)
            {
                if(isset($request->select))
                {
                    $classe =  Classroom::where('user_id',\Auth::user()->id)->where('id',$cr->id)->first();
                    $classe->matters()->attach($request->select);
                }

            }



            return redirect()->action('StatisticsController@gestion')
                ->with('success','Informations bien enregistrées');
        }else{
            return redirect()->back()->withErrors($validator);
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
        $cr = Classroom::where('user_id',\Auth::user()->id)->where('id',$id)->first();
        return view('classrooms.show',compact('cr'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cr = Classroom::where('user_id',\Auth::user()->id)->where('id',$id)->first();
        $br = $cr->branches->lists('id');
        $lv = $cr->levels->lists('id');
        return view('classrooms.edit',compact('cr','br','lv'));
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
            'nom_classe' =>$request->nom_classe,
            'code_classe' =>$request->code_classe,
            'capacite_classe' =>$request->capacite_classe,
            'niveau' =>$request->niveau,
            'branche' => $request->branche,
            'select' => $request->select,
             'grade' => $request->grade

        ],[
            'nom_classe' => 'required',
            'code_classe'=> 'required',
            'capacite_classe' => 'required|integer',
            'select' => 'required',
            'grade' => 'required|integer',

        ],
            [
                'nom_classe.required' => "le nom de la classe est requis",
                'code_classe.required' => "le Code de la classe est requis",
                'capacite_classe.required' => "la capacité de la classe est requis",
                'capacite_classe.integer' => "la capacité de la classe doit etre un nombre entier",
                'select.required' => 'Vous devez cocher au moins une matière',
                'grade.integer' => "Le Niveau Global est requis",
            ]);

        if($validator->passes())
        {
            $niveau_global =  \Auth::user()->grades()->where('id',$request->grade)->first()->name;
           $cr = Classroom::where('user_id',\Auth::user()->id)->where('id',$id)->first();
            $cr->nom_classe = $request->nom_classe;
            $cr->code_classe = $request->code_classe;
            $cr->capacite_classe = $request->capacite_classe;

                $cr->niveau = $request->niveau;


            if($niveau_global == 'Lycée')
            {
                $cr->branche = $request->branche;
            }else{
                $cr->branche ='';
            }

            $cr->user_id = \Auth::user()->id;
            $cr->save();

            $classe =  Classroom::where('user_id',\Auth::user()->id)->where('id',$cr->id)->first();
            $classe->matters()->sync($request->select);

            $level = Level::find($request->niveau);
            if($niveau_global == 'Lycée')
            {
                DB::table('branch_classroom_level')->where('classroom_id', $cr->id)->update([
                    'branch_id' => $request->branche,
                    'level_id' => $level->id
                ]);
            }
            else{
                $level->lesClasses()->sync([$cr->id]);
            }


            return redirect()->back()->with('success','Modifications réussies');

        }else{
            return redirect()->back()->withErrors($validator);
        }


    }

    // only for lycée get the branche when level is chosen
    public function getBranchWhenLevelIsChosen()
    {
        if(\Request::ajax()) {
            $niveau_id = \Input::get('niveau_id');
            $level = Level::where('user_id',\Auth::user()->id)->where('id', $niveau_id)->first();
            foreach ($level->onbranches as $branch) {
                echo '<option value="' . $branch->id . '">' . $branch->nom_branche . '</option>';

            }
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


    public function delete($id)
    {
       $cr = Classroom::where('user_id',\Auth::user()->id)->where('id',$id)->first();
     DB::table('classroom_matter_teacher')->where('user_id',\Auth::user()->id)->where('classroom_id',$id)->delete();
        $cr->timesheets()->delete();
        $cr->delete();
        return redirect('classrooms')->with('success',"la classe a bien été supprimé");
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
                $b =   Classroom::where('user_id',\Auth::user()->id)->where('id',$id)->first();
                 DB::table('classroom_matter_teacher')->where('user_id',\Auth::user()->id)->where('classroom_id',$id)->delete();
                $b->timesheets()->delete();
                $b->delete();

            }
        }
    }

    public function detach()
    {
        if(\Request::ajax())
        {
           $matiere = \Input::get('matiere');
           $teacher = \Input::get('teacher');
            $cr = \Input::get('cr');
            DB::table('classroom_matter_teacher')
                ->where('classroom_id',$cr)
                ->where('teacher_id',$teacher)
                ->where('matter_id',$matiere)
                ->where('user_id',\Auth::user()->id)
                ->delete();
            echo 'deleted';
        }
    }

    public function trierparniveau()
    {
        if(\Request::ajax())
        {
            $niveau_id=  \Input::get('niveau_id');
            $niveaux = Classroom::where('user_id',\Auth::user()->id)->where('niveau',$niveau_id)->get();
            foreach ($niveaux as $level) {
                if($level->niveau)
                {
                    $niveau = \Auth::user()->leslevels()->where('id',$level->niveau)->first()->niveau;
                }else{
                    $niveau ='--';
                }
                if($level->branche)
                {
                    $branche = \Auth::user()->branches()->where('id',$level->branche)->first()->nom_branche;
                }else{
                    $branche ='--';
                }
                echo '         <tr>
                            <td class="no-print"><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input type="checkbox"  value="'.$level->id.' " name="select[]">

                                    </div>
                                </div></td>
                            <td> '.$level->nom_classe.' </td>
                            <td> '. $level->code_classe .'</td>
                            <td> '. $level->capacite_classe.'  élèves</td>
                             <td>'. $level->children()->CurrentYear()->count().'</td>
                            <td> '. $niveau .'</td>
                            <td>'. $branche .'</td>

                            <td class="no-print">
                                <a href="'.  action('ClassroomsController@delete',[$level]) .'" class="actions_icons delete-classe">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <!--<a href="#"><i class="fa fa-archive liste_icons"></i>
                                </a>-->
                            </td>

                            <td class="no-print"><a href="'.action('ClassroomsController@indexelc',[$level]).'"><div  class="btn_details">Détails</div></a></td>
                        </tr>';
            }
        }
    }



    public function trierparbranche()
    {
        if(\Request::ajax())
        {
            $branch_id =  \Input::get('branch_id');
            $branches = Branch::where('user_id',\Auth::user()->id)->where('id',$branch_id)->first();
            foreach ($branches->classrooms as $branch) {
                if($branch->niveau)
                {
                    $niveau = \Auth::user()->leslevels()->where('id',$branch->niveau)->first()->niveau;
                }else{
                    $niveau ='--';
                }
                if($branch->branche)
                {
                    $branche = \Auth::user()->branches()->where('id',$branch->branche)->first()->nom_branche;
                }else{
                    $branche ='--';
                }


                echo '<tr>
                            <td class="no-print"><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input type="checkbox"  value="'.$branch->id.' " name="select[]">

                                    </div>
                                </div></td>
                            <td> '.$branch->nom_classe.' </td>
                            <td> '. $branch->code_classe .'</td>
                            <td> '. $branch->capacite_classe.'  élèves</td>
                            <td>'. $branch->children()->CurrentYear()->count().'</td>
                            <td> '. $niveau.'</td>
                            <td>'. $branche .'</td>

                            <td class="no-print">
                                <a href="'.  action('ClassroomsController@delete',[$branch]) .'" class="actions_icons delete-classe">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <!--<a href="#"><i class="fa fa-archive liste_icons"></i>
                                </a>-->
                            </td>

                            <td class="no-print"><a href="'.action('ClassroomsController@indexelc',[$branch]).'"><div  class="btn_details">Détails</div></a></td>
                        </tr>';
            }
        }



    }



    public function addMatterandProfToCr($id)
    {
       if(\Request::isMethod('get'))
       {
           $cr = Classroom::where('user_id',\Auth::user()->id)->where('id',$id)->first();
           return  view('classrooms.addMatterandProfToCr',compact('cr'));
       }
    }


    /************************Export Excel***********************************
     * @param $ids
     */

    public function exportExcel($ids = null)
    {
        $ids =  explode(',',substr($ids,0,-1));
        $ids =   array_unique($ids);

            $model = Classroom::whereIn('id',$ids)->where('user_id', \Auth::user()->id)
                ->get(['nom_classe','code_classe','capacite_classe','niveau','branche']);
            Excel::create('La liste des Classes', function ($excel) use ($model) {
                $excel->sheet('La liste des Classes', function ($sheet) use ($model) {
                    foreach ($model as $item) {
                        if($item->niveau)
                        $item->niveau = \Auth::user()->leslevels()->where('id',$item->niveau)->first()->niveau;
                        else
                            $item->niveau ='--';
                         if($item->branche)
                        $item->branche = \Auth::user()->branches()->where('id',$item->branche)->first()->nom_branche;
                        else
                            $item->branche = '--';
                    }


                    $sheet->fromModel($model);
                    // $sheet->setBorder('A1:B1', 'thin');
                    $sheet->setStyle(array(
                        'font' => array(
                            'name'      =>  'Calibri',
                            'size'      =>  13,

                        )
                    ));
                    $sheet->setAllBorders('thin');
                    $sheet->cells('A1:E1',function($cells){
                        $cells->setBackground('#97efee');
                        // header only
                        $cells->setFont(array(
                            'family'     => 'Calibri',
                            'size'       => '14',
                            'bold'       =>  true
                        ));
                    });

                    $sheet->row(1, array(
                        'Nom de la Classe', 'Code de la Classe','Capacité de la Classe','Niveau','Branche'
                    ));


                });
            })->export('xls');

    }
    public function exportPdf($ids = null)
    {
        $ids =  explode(',',substr($ids,0,-1));
        $ids =   array_unique($ids);
            $model = Classroom::whereIn('id',$ids)->where('user_id', \Auth::user()->id)
                ->get(['nom_classe','code_classe','capacite_classe','niveau','branche']);
            Excel::create('La liste des Classes', function ($excel) use ($model,$ids) {
                $excel->sheet('La liste des Classes', function ($sheet) use ($model,$ids) {

                    foreach ($model as $item) {
                        if($item->niveau)
                            $item->niveau = \Auth::user()->leslevels()->where('id',$item->niveau)->first()->niveau;
                        else
                            $item->niveau ='--';
                        if($item->branche)
                            $item->branche = \Auth::user()->branches()->where('id',$item->branche)->first()->nom_branche;
                        else
                            $item->branche = '--';
                    }
                    $sheet->setWidth('A',15);
                    $sheet->setWidth('B',15);
                    $sheet->setWidth('C',15);
                    $sheet->setWidth('D',15);
                    $sheet->setWidth('E',15);
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


                        $sheet->cells('A'.$i.':'.'E'.$i,function($cells){
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
                    $sheet->cells('A1:E1',function($cells){
                        $cells->setBackground('#e9f1f3');
                        $cells->setFontColor('#556b7b');
                        $cells->setFont(array(
                            'family'     => 'OpenSans',
                            'size'       => '15',
                            'bold'       =>  true,
                        ));

                    });



                    $sheet->row(1, array(
                        'Nom de la Classe', 'Code de la Classe','Capacité de la Classe','Niveau','Branche'
                    ));


                });
            })->export('pdf');

    }



    /**********************************  Compte Famille         ************/

    public function indexef()
    {
        $children = Child::where('f_id',\Auth::user()->id)->get();
        return view('classrooms.indexef',compact('children'));
    }

    public function showef($id)
    {
        $ts = Timesheet::where('classroom_id',$id)->first();
        return view('classrooms.showef',compact('ts'));
    }






}
