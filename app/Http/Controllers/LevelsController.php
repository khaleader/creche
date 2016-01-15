<?php

namespace App\Http\Controllers;

use App\Level;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;

class LevelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
            $level->save();
            return redirect()->back()->with('success','Bien Enregistré');
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
}
