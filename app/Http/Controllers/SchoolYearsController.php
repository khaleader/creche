<?php

namespace App\Http\Controllers;

use App\Http\Requests\schoolYearsRequest;
use App\SchoolYear;
use App\Transport;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SchoolYearsController extends Controller
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
        //
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

public function verifyRange()
{
    if(\Request::ajax())
    {
        $dateNow = Carbon::parse(\Input::get('now'));
        $currentYear = \Auth::user()->schoolyears()->where('current',1)->first();
        if($currentYear) {
            if ($currentYear->type == 'Semis') {
                if ($dateNow->between($currentYear->startch1, $currentYear->endch2)) {

                } else {
                    echo 'no';
                }
            } else {
                if ($dateNow->between($currentYear->startch1, $currentYear->endch3)) {

                } else {
                    echo 'no';
                }
            }
        }else{
            echo "regler";
        }


    }
}


    // fill dates when select semis or trim
    public function getdates()
    {
        if(\Request::ajax())
        {
            $user_id =  \Auth::user()->id;
            $ann_scol = \Input::get('ann_scol');
            $type = \Input::get('type');
            $checkYear =  SchoolYear::where('user_id',$user_id)
                ->where('ann_scol',$ann_scol)
                ->where('type',$type)
                ->first();
            if($checkYear)
            {
                echo json_encode($checkYear);
                die();
            }else{
/*
               $tab = [
                    'startch1'=> '',
                   'endch1' => '',
                   'startch2' => '',
                   'endch2' => '',

                ];*/
                $tab = [];
                echo json_encode($tab);
                die();
            }
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(schoolYearsRequest $request)
    {

       $tableau = explode('-',$request->ann_scol);
        $year1 = $tableau[0];
        $year2 = $tableau[1];

        $yearNow = Carbon::now()->year;
        $year_prec =Carbon::now()->year - 1;
        $year_next = Carbon::now()->year + 1;

        if($year1 > $yearNow && $year2  > $year_next)
        {
            return redirect()->back()
                ->withErrors("Désolé vous ne pouvez pas ajouter cette année scolaire en ce moment !");
        }
        $ann_scol = $request->ann_scol;
        $trim_semis = $request->TrimSemis;
        $champ1start =Carbon::parse($request->champ1start);
        $champ1end = Carbon::parse($request->champ1end);
        $champ2start =Carbon::parse($request->champ2start);
        $champ2end = Carbon::parse($request->champ2end);
        if(!is_null($request->champ3start) && !is_null($request->champ3end))
        {
            $champ3start = Carbon::parse($request->champ3start);
            $champ3end = Carbon::parse($request->champ3end);
        }

        // vérifier l'enchainement semistrielle
        if($trim_semis == 'Semis')
        {
            if($champ1start < $champ1end && $champ1end < $champ2start
                && $champ2start < $champ2end &&
                $champ1start->diffInMonths($champ2end) >=8
                && $champ1start->year == $year1
                && $champ2end->year == $year2
            )
            {

            }else{
                return redirect()->back()
                    ->withErrors("l'enchainement des dates est incorrect
                    ou durée totale est moins de 8 mois
                    ou Correspondance avec l'année scolaire est incorrecte ");


            }
        }
        // vérifier l'enchainement trimistrielle
        if($trim_semis == 'Trim')
        {
            if($champ1start < $champ1end && $champ1end < $champ2start &&
                $champ2start < $champ2end && $champ2end < $champ3start
                && $champ3start < $champ3end  && $champ1start->diffInMonths($champ3end) >=8
                && $champ1start->year == $year1
                && $champ3end->year == $year2
            )
            {

            }else{
                return redirect()->back()
                    ->withErrors("l'enchainement des dates est
                    incorrect ou durée totale est moins de 8 mois ou
                     Correspondance avec l'année scolaire est incorrecte");
            }
        }



        // early inscription for Next Year
        if(Carbon::now()->month >=1  && $year1 == $yearNow && $year2 == $year_next
          && $champ1start->month == 9 || $champ1start->month == 10)
        {
            // si trouvé une mise à jour
            $sc_year = SchoolYear::where('user_id',\Auth::user()->id)
                ->where('ann_scol',$ann_scol)
                ->first();
            if($sc_year)
            {
                $sc_year->startch1 = $champ1start;
                $sc_year->endch1 = $champ1end;
                $sc_year->startch2 = $champ2start;
                $sc_year->endch2 = $champ2end;
                if($trim_semis == 'Trim')
                {
                    $sc_year->startch3 = $champ3start;
                    $sc_year->endch3 = $champ3end;
                }else{
                    $sc_year->startch3 = null;
                    $sc_year->endch3 = null;
                }
                $sc_year->type = $trim_semis;
                $sc_year->current =0;
                $sc_year->save();
            }else{
                // créer l'année scolaire pour l'année prochaine
                $sc= new SchoolYear();
                $sc->ann_scol = $ann_scol;
                $sc->type = $trim_semis;
                $sc->startch1 = $champ1start;
                $sc->endch1 = $champ1end;
                $sc->startch2 = $champ2start;
                $sc->endch2 = $champ2end;
                $sc->current = 0;
                if($trim_semis == 'Trim')
                {
                    $sc->startch3 = $champ3start;
                    $sc->endch3 = $champ3end;
                }
                $sc->user_id = \Auth::user()->id;
                $sc->save();
            }
        }
        if($year1 == $year_prec && $year2 == $yearNow && Carbon::now()->month <= 6)
        {
          $sc_year = SchoolYear::where('user_id',\Auth::user()->id)
              ->where('ann_scol',$ann_scol)
              ->first();
          if($sc_year)
          {
              $sc_year->startch1 = $champ1start;
              $sc_year->endch1 = $champ1end;
              $sc_year->startch2 = $champ2start;
              $sc_year->endch2 = $champ2end;
              if($trim_semis == 'Trim')
              {
                  $sc_year->startch3 = $champ3start;
                  $sc_year->endch3 = $champ3end;
              }else{
                  $sc_year->startch3 = null;
                  $sc_year->endch3 = null;
              }
              $sc_year->type = $trim_semis;
              $sc_year->save();
          }else {
              $sc = new SchoolYear();
              $sc->ann_scol = $ann_scol;
              $sc->type = $trim_semis;
              $sc->startch1 = $champ1start;
              $sc->endch1 = $champ1end;
              $sc->startch2 = $champ2start;
              $sc->endch2 = $champ2end;
              $sc->current = 1;
              if ($trim_semis == 'Trim') {
                  $sc->startch3 = $champ3start;
                  $sc->endch3 = $champ3end;
              }
              $sc->user_id = \Auth::user()->id;
              $sc->save();
             /* if ($sc->id) {
                  $forCurrentYear = SchoolYear::where('user_id', \Auth::user()->id)
                      ->get();
                  foreach ($forCurrentYear as $ok) {
                      $yes = SchoolYear::where('user_id', \Auth::user()->id)
                          ->where('id', '!=', $sc->id)->first();
                      if ($yes) {
                          $yes->current = 0;
                          $yes->save();
                      }


                  }
              }*/
          }
          }
        return redirect()->back()->with('success','Bien Enregistrés');
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
}
