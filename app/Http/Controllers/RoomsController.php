<?php

namespace App\Http\Controllers;

use App\Room;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use URL;
use Validator;

class RoomsController extends Controller
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
       $rooms = Room::where('user_id',\Auth::user()->id)->paginate(10);
       return view('rooms.index',compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('rooms.create');
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
            'nom_salle' =>$request->nom_salle,
            'capacite_salle' =>$request->capacite_salle


        ],[
            'nom_salle' => 'required',
            'capacite_salle'=> 'required|integer'
        ],
            [
                'nom_salle.required' => "le nom de la salle est requis",
                'capacite_salle.required' => "la capacité de salle est requis",
                'capacite_salle.integer' => "le nombre doit etre un entier",
            ]);


        if($validator->passes())
        {

            Room::create([
               'nom_salle'=> $request->nom_salle,
                'capacite_salle' => $request->capacite_salle,
                'color' => '#525252',
                'user_id'=>\Auth::user()->id
            ]);

            return redirect()->back()->with('success','Informations bien enregistrées');
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
       $room = Room::where('user_id',\Auth::user()->id)->where('id',$id)->first();
        return view('rooms.show',compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $room =  Room::where('user_id',\Auth::user()->id)->where('id',$id)->first();
        return view('rooms.edit',compact('room'));
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
            'nom_salle' =>$request->nom_salle,
            'capacite_salle' =>$request->capacite_salle


        ],[
            'nom_salle' => 'required',
            'capacite_salle'=> 'required|integer'
        ],
            [
                'nom_salle.required' => "le nom de la salle est requis",
                'capacite_salle.required' => "la capacité de salle est requis",
                'capacite_salle.integer' => "le nombre doit etre un entier",
            ]);
        if($validator->passes())
        {

            $l =  Room::where('user_id',\Auth::user()->id)->where('id',$id)->first();
            $l->nom_salle = $request->nom_salle;
            $l->capacite_salle = $request->capacite_salle;
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
        $cr = Room::where('user_id',\Auth::user()->id)->where('id',$id)->first();
        $cr->delete();
        return redirect('rooms')->with('success',"la salle a bien été supprimé");
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
                $b =   Room::where('user_id',\Auth::user()->id)->where('id',$id)->first();
                $b->delete();
            }
        }
    }


    public function exportExcel($ids = null)
    {
        $ids =  explode(',',substr($ids,0,-1));
        $ids =   array_unique($ids);

            $model = Room::whereIn('id',$ids)->where('user_id', \Auth::user()->id)
                ->get(['nom_salle','capacite_salle']);
            Excel::create('La liste des salles', function ($excel) use ($model) {
                $excel->sheet('La liste des salles', function ($sheet) use ($model) {
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
                        'Salle', 'Capacité de la Salle'
                    ));


                });
            })->export('xls');

    }

    public function exportPdf($ids = null)
    {
        $ids =  explode(',',substr($ids,0,-1));
        $ids =   array_unique($ids);
            $model = Room::whereIn('id',$ids)->where('user_id', \Auth::user()->id)
                ->get(['nom_salle','capacite_salle']);
            Excel::create('La liste des salles', function ($excel) use ($model,$ids) {
                $excel->sheet('La liste des salles', function ($sheet) use ($model,$ids) {
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
                        'Salle', 'Capacité de la Salle'
                    ));


                });
            })->export('pdf');

    }




}
