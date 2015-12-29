<?php

namespace App\Http\Controllers;

use App\Child;
use App\Family;
use App\Http\Requests\AddSchoolRequest;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Validator;

class FamiliesController extends Controller
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

    /**
     * @param Requests\AddSchoolRequest $
     * @return \Illuminate\View\View
     */

    public function index()
    {
       $families = \Auth::user()->families()->paginate(10);
       return view('families.index',compact('families'));
    }


    public function fambyalph()
    {
        if(\Request::ajax())
        {
            $caracter = \Input::get('caracter');
            $families =   Family::where('user_id',\Auth::user()->id)
                ->where('nom_pere', 'LIKE', $caracter .'%')
                ->where('responsable',1)->orWhere('nom_mere', 'LIKE', $caracter .'%')
                 ->where('responsable',0)
                ->get();
               foreach($families as $family)
               {


                   if($family->responsable == 0)
                       $resp = $family->nom_mere;
                   else
                       $resp = $family->nom_pere;
                   echo '<tr>
                            <td><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input type="checkbox" name="select[]" value=" '.$family->id.' ">

                                    </div>
                                </div></td>
                            <td><img class="avatar" src="images/avatar6.jpg"></td>
                            <td>'. $resp .' </td>

                            <td>'.  $family->children->count() .'</td>
                            <td><span class="label label-success label-mini"><i class="fa fa-money"></i></span></td>
                            <td>
                                <a href="#" class="actions_icons delete-family">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a class="archive-family" href="#"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>

                            <td><a href="'.action('FamiliesController@show',[$family->id]).'"><div  class="btn_details">Détails</div></a></td>
                        </tr>';
               }


            //echo json_encode($families);
            die();
        }
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $family = Family::findOrFail($id);
        if(!empty($family))
        {
            if($family->user_id == \Auth::user()->id)
            {
                return view('families.show',compact('family'));
            }
        }else{
            return  redirect('families');
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
        $family = Family::findOrFail($id);
        if(\Auth::user()->id  == $family->user_id)
        {
            return view('families.edit',compact('family'));
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
            'numero_fixe' =>$request->numero_fixe,
            'numero_portable' =>$request->numero_portable,
            'adresse' => $request->adresse,
            'photo' => $request->photo

        ],[
            'numero_fixe' => 'required',
            'numero_portable'=> 'required',
            'adresse'=> 'required',
            'photo' => 'image'
        ],
            [
                'numero_fixe.required' => "Le tel fixe est requis",
                'numero_portable.required' => "Le tel portable est requis",
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
                  $family =   Family::findOrFail($id);
                  $family->photo = $filename;
                  $family->numero_fixe =$request->numero_fixe;
                  $family->numero_portable =$request->numero_portable;
                  $family->adresse =$request->adresse;
                  $family->save();
              }else{
                  $family = Family::findOrFail($id);
                  if(isset($family->photo))
                  {
                      $filename = $family->photo;
                  }else{
                      $filename = null;
                  }
                  $family->numero_fixe =$request->numero_fixe;
                  $family->numero_portable =$request->numero_portable;
                  $family->adresse =$request->adresse;
                  $family->photo = $filename;
                  $family->save();
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

     // checkboxes ajax
    public function supprimer()
    {
        if(\Request::ajax())
        {
            $numbers = substr( \Input::get('boxes'),0,-1);
            $ids = explode(',',$numbers);
            $ids = array_unique($ids);
            foreach($ids as $id)
            {
                $family = Family::findOrFail($id);
               User::where('email',$family->email_responsable)->first()->delete();
                foreach($family->children as $child)
                {
                  $child->bills()->delete();
                    $child->attendances()->delete();

                }
                $family->children()->delete();
                $family->delete();

               $onlyTrashed =Family::onlyTrashed()->findOrFail($id);
                foreach($onlyTrashed->children as $c)
                {
                    $c->bills()->forceDelete();
                    $c->attendances()->forceDelete();
                }
               $onlyTrashed->children()->forceDelete();
                $onlyTrashed->forceDelete();

            }
        }
    }

    // checkboxes ajax
    public function archiver()
    {
        if(\Request::ajax())
        {
            $numbers = substr( \Input::get('boxesarchives'),0,-1);
            $ids = explode(',',$numbers);
            $ids = array_unique($ids);
            foreach($ids as $id)
            {
                $family = Family::findOrFail($id);
                foreach($family->children as $child)
                {
                    $child->bills()->delete();
                    $child->attendances()->delete();
                }
                $family->children()->delete();
                $family->delete();
            }
        }



    }

    /**
     * @param $id
     */
    public function delete($id)
      {
          $family = Family::findOrFail($id);
          foreach($family->children as $child)
          {
              $child->bills()->delete();
              $child->attendances()->delete();
          }
          $family->children()->delete();
          $family->delete();
          $f = Family::onlyTrashed()->findOrFail($id);
          User::where('email',$f->email_responsable)->first()->delete();
          foreach($f->children as $child)
          {
              $child->bills()->forceDelete();
              $child->attendances()->forceDelete();
          }
          $f->children()->forceDelete();
          $f->forceDelete();
          return redirect()->to('families');

      }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function archive($id)
     {
         $family = Family::findOrFail($id);
         foreach($family->children as $child)
         {
             $child->bills()->delete();
         }
         $family->children()->delete();
         $family->delete();
         return redirect()->to('families');

     }

    public function search()
    {
        $child = Child::where('nom_enfant', 'LIKE', '%'. \Input::get('terms') .'%')
            ->where('user_id',\Auth::user()->id)
            ->get();

        $family = Family::where('nom_pere', 'LIKE', '%'. \Input::get('terms') .'%')
            ->where('user_id',\Auth::user()->id)
            ->orWhere('nom_mere', 'LIKE', '%'. \Input::get('terms') .'%')
            ->get();


        return view('families.search')->with(['child'=>$child,'family'=>$family]);
    }

}
