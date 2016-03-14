<?php

namespace App\Http\Controllers;

use App\Grade;
use App\Level;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use URL;
use Validator;

class LevelsController extends Controller
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

    public function index()
    {
        $grade =  Grade::where('user_id',\Auth::user()->id)->first();
        if(!$grade)
        {
           $sc = new Grade();
            $sc->name = 'Primaire';
            $sc->user_id = \Auth::user()->id;
            $sc->save();

            $col = new Grade();
            $col->name = 'Collège';
            $col->user_id = \Auth::user()->id;
            $col->save();

            $lyc = new Grade();
            $lyc->name = 'Lycée';
            $lyc->user_id = \Auth::user()->id;
            $lyc->save();

        }

      $levels = Level::where('user_id',\Auth::user()->id)->paginate(10);
        return view('levels.index',compact('levels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('levels.create');
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
            'niveau' =>$request->niveau,
        ],[
            'niveau' => 'required',
        ],
            [
                'niveau.required' => "le nom du niveau est requis"
            ]);


        if($validator->passes())
        {
            $level = new Level();
            $level->niveau = $request->niveau;
            $level->user_id = \Auth::user()->id;
            $level->grade_id = $request->grade;
            $level->save();
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
        $level = Level::where('user_id',\Auth::user()->id)->where('id',$id)->first();
        return view('levels.show',compact('level'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $level =  Level::where('user_id',\Auth::user()->id)->where('id',$id)->first();
        return view('levels.edit',compact('level'));
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
            'niveau' => 'required',

        ]);
        if($validator->passes())
        {

            $l =  Level::where('user_id',\Auth::user()->id)->where('id',$id)->first();
            $l->niveau = $request->niveau;
            $l->grade_id = $request->grade;
             $l->save();
              return redirect()->back()->with('success','Les Informations Ont bien été Enregistrés');
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

    public function delete($id)
    {
       $lev = Level::where('user_id',\Auth::user()->id)->where('id',$id)->first();
        $lev->delete();
        return redirect('levels')->with('success',"le niveau a bien été supprimé");
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
                $b =   Level::where('user_id',\Auth::user()->id)->where('id',$id)->first();
                $b->delete();
            }
        }
    }


    /*********************Excel export******************************************
     * @param $ids
     */

    public function exportExcel($ids = null)
    {
        $ids =  explode(',',substr($ids,0,-1));
        $ids =   array_unique($ids);

            $model = Level::whereIn('id',$ids)->where('user_id', \Auth::user()->id)
                ->get(['id','niveau']);
            Excel::create('Niveaux', function ($excel) use ($model) {
                $excel->sheet('Niveaux', function ($sheet) use ($model) {
                    foreach($model as $level)
                    {
                        $level->nbr = $level->children()->count();
                        unset($level->id);
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
                    $sheet->cells('A1:B1',function($cells){
                        $cells->setBackground('#97efee');
                        // header only
                        $cells->setFont(array(
                            'family'     => 'Calibri',
                            'size'       => '14',
                            'bold'       =>  true
                        ));
                    });

                    $sheet->row(1, array(
                        'Le Niveau',"Nombre d'élèves"
                    ));


                });
            })->export('xls');

    }




    public function exportPdf($ids = null )
    {
        $ids =  explode(',',substr($ids,0,-1));
        $ids =   array_unique($ids);

            $model = Level::whereIn('id',$ids)->where('user_id', \Auth::user()->id)
                ->get(['id','niveau']);
            Excel::create('Niveaux', function ($excel) use ($model,$ids) {
                $excel->sheet('Niveaux', function ($sheet) use ($model,$ids) {
                    foreach($model as $level)
                    {
                        $level->nbr = $level->children()->count();
                        unset($level->id);
                    }
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


                        $sheet->cells('A'.$i.':'.'B'.$i,function($cells){
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
                    $sheet->cells('A1:B1',function($cells){
                        $cells->setBackground('#e9f1f3');
                        $cells->setFontColor('#556b7b');
                        $cells->setFont(array(
                            'family'     => 'OpenSans',
                            'size'       => '15',
                            'bold'       =>  true,
                        ));

                    });


                    $sheet->row(1, array(
                        'Le Niveau',"Nombre d'élèves"
                    ));


                });
            })->export('pdf');

    }
}
