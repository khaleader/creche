<?php

namespace App\Http\Controllers;

use App\Branch;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use URL;
use Validator;

class BranchesController extends Controller
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
       $branches = Branch::where('user_id',\Auth::user()->id)->paginate(10);
        return view('branches.index',compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('branches.create');
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
            'nom_branche' =>$request->nom_branche,
            'code_branche' =>$request->code_branche


        ],[
            'nom_branche' => 'required',
            'code_branche'=> 'required'
        ],
            [
                'nom_branche.required' => "le nom de la branche est requis",
                'code_branche.required' => "le Code de la branche est requis",
            ]);


        if($validator->passes())
        {

            Branch::create([
                'nom_branche'=> $request->nom_branche,
                'code_branche' => $request->code_branche,
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
        $branch = Branch::where('user_id',\Auth::user()->id)->where('id',$id)->first();
        return view('branches.show',compact('branch'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $branch =  Branch::where('user_id',\Auth::user()->id)->where('id',$id)->first();
        return view('branches.edit',compact('branch'));
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
            'nom_branche' =>$request->nom_branche,
            'code_branche' =>$request->code_branche


        ],[
            'nom_branche' => 'required',
            'code_branche'=> 'required'
        ],
            [
                'nom_branche.required' => "le nom de la branche est requis",
                'code_branche.required' => "le Code de la branche est requis",
            ]);
        if($validator->passes())
        {

            $l =  Branch::where('user_id',\Auth::user()->id)->where('id',$id)->first();
            $l->nom_branche = $request->nom_branche;
            $l->code_branche = $request->code_branche;
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
        $cr = Branch::where('user_id',\Auth::user()->id)->where('id',$id)->first();
        $cr->delete();
        return redirect('branches')->with('success',"la branche a bien été supprimé");
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
           $b =   Branch::where('user_id',\Auth::user()->id)->where('id',$id)->first();
                $b->delete();
            }
        }
    }


    /********************************Export Excel ********************************************
     * @param null $ids
     */

    public function exportExcel($ids =null )
    {
        $ids =  explode(',',substr($ids,0,-1));
        $ids =   array_unique($ids);

            $model = Branch::whereIn('id',$ids)->where('user_id', \Auth::user()->id)
                ->get(['id','nom_branche','code_branche']);
            Excel::create('La liste des Branches', function ($excel) use ($model) {
                $excel->sheet('La liste des Branches', function ($sheet) use ($model) {
                    foreach($model as $branch)
                    {
                        $branch->nbr = $branch->children()->count();
                        unset($branch->id);
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
                    $sheet->cells('A1:C1',function($cells){
                        $cells->setBackground('#97efee');
                        // header only
                        $cells->setFont(array(
                            'family'     => 'Calibri',
                            'size'       => '14',
                            'bold'       =>  true
                        ));
                    });

                    $sheet->row(1, array(
                        'Nom de la Branche','Code de La Branche',"Nombre d'élèves"
                    ));


                });
            })->export('xls');

    }


    public function exportPdf($ids = null)
    {
        $ids =  explode(',',substr($ids,0,-1));
        $ids =   array_unique($ids);

            $model = Branch::whereIn('id',$ids)->where('user_id', \Auth::user()->id)
                ->get(['id','nom_branche','code_branche']);

            Excel::create('La liste des Branches', function ($excel) use ($model,$ids) {
                $excel->sheet('La liste des Branches', function ($sheet) use ($model, $ids) {
                    foreach($model as $branch)
                    {
                        $branch->nbr = $branch->children()->count();
                        unset($branch->id);
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
                        'Nom de la Branche','Code de La Branche',"Nombre d'élèves"
                    ));


                });
            })->export('pdf');

    }

}
