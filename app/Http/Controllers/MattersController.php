<?php

namespace App\Http\Controllers;

use App\Matter;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use URL;
use Validator;


class MattersController extends Controller
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
        $matters = Matter::where('user_id',\Auth::user()->id)->paginate(10);
       return view('matters.index',compact('matters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('matters.create');
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

            'nom_matiere' =>$request->nom_matiere,
            'code_matiere' =>$request->code_matiere,
             'color' => $request->color
        ],[
            'nom_matiere' => 'required',
            'code_matiere'=> 'required',
            'color' => 'required'
        ],
            [
                'nom_matiere.required' => "le nom de la matière est requis",
                'code_matiere.required' => "le Code de la matière est requis",
                'color.required' => 'la couleur de la matière est requis'
            ]);


        if($validator->passes())
        {

            Matter::create([
                'nom_matiere'=> $request->nom_matiere,
                'code_matiere' => $request->code_matiere,
                'color' => '#'.$request->color,
                'user_id'=>\Auth::user()->id
            ]);

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
        $matiere = Matter::where('user_id',\Auth::user()->id)->where('id',$id)->first();
        return view('matters.show',compact('matiere'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $matter =  Matter::where('user_id',\Auth::user()->id)->where('id',$id)->first();
        return view('matters.edit',compact('matter'));
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
            'nom_matiere' => 'required',
            'code_matiere'=> 'required',
            'color' => 'required'
        ],
            [
                'nom_matiere.required' => "le nom de la matière est requis",
                'code_matiere.required' => "le Code de la matière est requis",
                'color.required' => 'la couleur de la matière est requis'
            ]
            );
        if($validator->passes())
        {

            $l =  Matter::where('user_id',\Auth::user()->id)->where('id',$id)->first();
            $l->nom_matiere = $request->nom_matiere;
                $l->code_matiere = $request->code_matiere;
                $l->color = '#'.$request->color;
                $l->user_id =\Auth::user()->id;
                 $l->save();
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
        $cr = Matter::where('user_id',\Auth::user()->id)->where('id',$id)->first();
        $cr->delete();
        return redirect('matters')->with('success',"la Matière a bien été supprimé");
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
                $b =   Matter::where('user_id',\Auth::user()->id)->where('id',$id)->first();
                $b->delete();
            }
        }
    }


    /***********************Excel part ***********************
     * @param $ids
     */

    public function exportMatiere($ids = null)
    {
        $ids =  explode(',',substr($ids,0,-1));
        $ids =   array_unique($ids);

            $model = Matter::whereIn('id',$ids)->where('user_id', \Auth::user()->id)->get(['nom_matiere','code_matiere']);
            Excel::create('La liste des Matières', function ($excel) use ($model) {
                $excel->sheet('La liste des Matières', function ($sheet) use ($model) {
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
                        'Nom Matière', 'Code Matière'
                    ));


                });
            })->export('xls');

    }



    public function exportPdf($ids = null)
    {
        $ids =  explode(',',substr($ids,0,-1));
        $ids =   array_unique($ids);
            $model = Matter::whereIn('id',$ids)->where('user_id', \Auth::user()->id)->get(['nom_matiere','code_matiere']);
            Excel::create('La liste des Matières', function ($excel) use ($model,$ids) {
                $excel->sheet('La liste des Matières', function ($sheet) use ($model,$ids) {
                    $sheet->fromModel($model);
                    // $sheet->setBorder('A1:B1', 'thin');

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
                        'Nom Matière', 'Code Matière'
                    ));


                });
            })->export('pdf');

    }








}
