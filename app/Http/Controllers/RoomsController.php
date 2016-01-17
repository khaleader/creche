<?php

namespace App\Http\Controllers;

use App\Room;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
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

}
