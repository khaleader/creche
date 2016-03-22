<?php

namespace App\Http\Controllers;

use App\Bus;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Validator;

class BusesController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buses =\Auth::user()->buses()->paginate(10);
        return view('buses.index',compact('buses'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('buses.create');
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
            'marque' =>$request->marque,
            'modele' =>$request->modele,
            'matricule' =>$request->matricule,
            'chauffeur' =>$request->chauffeur,
            'capacite' =>$request->capacite,
        ],[
            'marque' =>'required',
            'modele' =>'required',
            'matricule' =>'required',
            'chauffeur' =>'required',
            'capacite' =>'required',
        ],
            [
                'marque.required' => "la marque est requis",
                'modele.required' => "le modèle  est requis",
                'matricule.required' => "le matricule est requis",
                'chauffeur.required' => "le chauffeur  est requis",
                'capacite.required' => "la capacité  est requis",


            ]);


        if($validator->passes())
        {
            $bus = new Bus();
            $bus->marque = $request->marque;
            $bus->modele = $request->modele;
            $bus->matricule = $request->matricule;
            $bus->chauffeur = $request->chauffeur;
            $bus->capacite = $request->capacite;
            $bus->user_id = \Auth::user()->id;
            $bus->save();
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
      $bus =  Bus::where('user_id',\Auth::user()->id)->where('id',$id)->first();
       return view('buses.show',compact('bus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bus =  Bus::where('user_id',\Auth::user()->id)->where('id',$id)->first();
        return view('buses.edit',compact('bus'));
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
            'marque' =>$request->marque,
            'modele' =>$request->modele,
            'matricule' =>$request->matricule,
            'chauffeur' =>$request->chauffeur,
            'capacite' =>$request->capacite,
        ],[
            'marque' =>'required',
            'modele' =>'required',
            'matricule' =>'required',
            'chauffeur' =>'required',
            'capacite' =>'required',
        ],
            [
                'marque.required' => "la marque est requis",
                'modele.required' => "le modèle  est requis",
                'matricule.required' => "le matricule est requis",
                'chauffeur.required' => "le chauffeur  est requis",
                'capacite.required' => "la capacité  est requis",


            ]);


        if($validator->passes())
        {
            $bus =  Bus::where('user_id',\Auth::user()->id)->where('id',$id)->first();
            $bus->marque = $request->marque;
            $bus->modele = $request->modele;
            $bus->matricule = $request->matricule;
            $bus->chauffeur = $request->chauffeur;
            $bus->capacite = $request->capacite;
            $bus->user_id = \Auth::user()->id;
            $bus->save();
            return redirect()->action('StatisticsController@gestion')
                ->with('success','Informations bien enregistrées');
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

    public function delete($id)
    {
        $cr = Bus::where('user_id',\Auth::user()->id)->where('id',$id)->first();
        $cr->delete();
        return redirect('buses')->with('success',"l'autocar a bien été supprimé");
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
                $b =   Bus::where('user_id',\Auth::user()->id)->where('id',$id)->first();
                $b->delete();
            }
        }
    }

      /********************************Export Excel ********************************************/

    public function exportExcel($ids = null)
    {
        $ids =  explode(',',substr($ids,0,-1));
        $ids =   array_unique($ids);

        $model = Bus::whereIn('id',$ids)->where('user_id', \Auth::user()->id)
            ->get(['marque','modele','matricule','chauffeur','capacite']);
        Excel::create('La liste des autocars', function ($excel) use ($model) {
            $excel->sheet('La liste des autocar', function ($sheet) use ($model) {

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
                    'Marque','Modèle',"Matricule","Chauffeur","Capacité"
                ));


            });
        })->export('xls');
    }

    public function exportPdf($ids = null)
    {
        $ids =  explode(',',substr($ids,0,-1));
        $ids =   array_unique($ids);

        $model = Bus::whereIn('id',$ids)->where('user_id', \Auth::user()->id)
            ->get(['marque','modele','matricule','chauffeur','capacite']);

        Excel::create('La liste des autocars', function ($excel) use ($model,$ids) {
            $excel->sheet('La liste des autocars', function ($sheet) use ($model, $ids) {

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
                    'Marque','Modèle',"Matricule","Chauffeur","Capacité"
                ));


            });
        })->export('pdf');

    }


}
