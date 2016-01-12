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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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

            }
        }
    }

}
