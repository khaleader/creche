<?php

namespace App\Http\Controllers;

use App\Bill;
use App\Child;
use App\Classroom;
use App\Events\SendEmailToRespAfterRegistrationEvent;
use App\Family;
use App\Http\Requests\FormValidationChildFamilyRequest;
use App\Level;
use App\PriceBill;
use App\PromotionAdvance;
use App\PromotionExceptional;
use App\SchoolYear;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class EarlySubscriptionsController extends Controller
{
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
        $ynow = \Carbon\Carbon::now()->year;
        $ynext = \Carbon\Carbon::now()->year + 1;
        $both =$ynow.'-'.$ynext;
        $month = \Carbon\Carbon::now()->month;
        $result = \Auth::user()->schoolyears()->where('ann_scol',$both)->first();
        if($result)
        {

            return view('earlysubscriptions.create')->with(['nextyearid'=>$result->id]);
        }


    }


    public function getClassWhenLevelid()
    {
        if(\Request::ajax()) {
            $nextYearId =\Input::get('nextYearId');
            $level_id = \Input::get('level_id');
            $level = Level::where('id', $level_id)->where('user_id',\Auth::user()->id)->first();
            foreach ($level->classrooms()->where('school_year_id',$nextYearId)->get() as $cr) {
                echo '<option value="' . $cr->id . '"> ' . $cr->nom_classe .' ( '.$cr->schoolYear->ann_scol.' ) '. '</option>';
            }
            foreach ($level->lesClasses()->where('school_year_id',$nextYearId)->get() as $cr) {
                echo '<option value="' . $cr->id . '"> ' . $cr->nom_classe .' ( '.$cr->schoolYear->ann_scol.' ) '. '</option>';

            }
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormValidationChildFamilyRequest $request)
    {


        $cr = Classroom::where('user_id', \Auth::user()->id)->where('id', $request->classe)->first();

        if($cr->children()->where('school_year_id',$request->id_ann_scol)->count() > $cr->capacite_classe)
        {
            return redirect()->back()->withErrors("la classe est saturée");
        }

        // promotion Exceptional check
        if(PromotionExceptional::checkExceptionalPromotion())
        {
            if(PromotionExceptional::checkExcTimeOfPromotionIfExpired())
            {
                if(PromotionExceptional::checkExcPriceandReturnIt() == 'no')
                {
                    return redirect()->back()->withErrors("la promotion Exceptionnelle est active mais aucun prix n'est défini")->withInput();
                }else{
                    $prix_exc =  PromotionExceptional::checkExcPriceandReturnIt();
                }
            }else{
                return redirect()->back()->withErrors("la promotion Exceptionnelle est active mais la durée est expirée");
            }
        }

        // promotion advanced check
        $prix_advance ='';
        if(PromotionAdvance::checkAdvancePromotion())
        {
            if($request->nbr_month > 1 )
            {
                if(PromotionAdvance::checkAdvIfPriceIsSet($request->nbr_month) !== false)
                {
                    $prix_advance = PromotionAdvance::checkAdvIfPriceIsSet($request->nbr_month);
                }else{
                    return redirect()->back()->withErrors("Aucun prix n'est
                    défini pour cette Promotion de ".$request->nbr_month.' Mois');

                }
            }
        }

        $niveau_global =  \Auth::user()->grades()->where('id',$request->grade)->first()->name;

        // famille for family profile
        $famille = Family::where('user_id',\Auth::user()->id)->where('email_responsable',$request->email_responsable)->first();
        if(!$famille) {
            $family = new Family();
            $family->nom_pere = ucfirst($request->nom_pere);
            $family->nom_mere = ucfirst($request->nom_mere);
            $family->email_responsable = $request->email_responsable;
            $family->adresse = $request->adresse;
            $family->numero_fixe = $request->numero_fixe;
            $family->numero_portable = $request->numero_portable;
            $family->cin = strtoupper($request->cin);
            $family->responsable = $request->responsable;
            $family->user_id = \Auth::user()->id;
            $family->school_year_id = $request->id_ann_scol;
            $family->save();


            if ($family->id) {
                $father = Family::findOrFail($family->id);
                $child = new Child();
                $child->date_naissance = Carbon::parse($request->date_naissance);
                $child->transport = $request->transport;
                $child->sexe = $request->sexe;


                $child->nom_enfant = ucfirst($request->nom_enfant);
                $child->age_enfant = $child->date_naissance->diffInYears(Carbon::now());
                $child->nationalite = \DB::table('countries')->where('id',$request->nationalite)->first()->nom_fr_fr;
                $child->user_id = \Auth::user()->id;
                $child->school_year_id = $request->id_ann_scol;

                $image = \Input::file('photo');
                if (!$image && empty($image)) {
                    $filename = '';

                } else {
                    $filename = $image->getClientOriginalName();
                    $path = public_path('uploads/' . $filename);
                    Image::make($image->getRealPath())->resize(313, 300)->save($path);
                }

                $child->photo = $filename;
                $child->family_id = $family->id;
                $child->save();


                if ($child->id) {
                    $ch =Child::find($child->id);
                    if($niveau_global == 'Lycée')
                    {
                        $ch->branches()->attach([$request->branche]);
                    }
                    if($niveau_global == 'Maternelle' || $niveau_global == 'Primaire'
                        || $niveau_global == 'Collège' || $niveau_global == 'Lycée' || $niveau_global == 'Crèche')
                    {
                        $ch->levels()->attach([$request->niveau]);
                    }
                    /*if($niveau_global == 'Crèche')
                    {
                        $ch->classrooms()->attach([$request->classe]);
                    }*/

                    //classe
                    $cr = Classroom::where('user_id', \Auth::user()->id)->where('id', $request->classe)->first();
                    $cr->children()->attach([$child->id]);



                    $bill = new Bill();
                    $bill->status = 0;

                    // if no promotion is active
                    if(!PromotionAdvance::checkAdvancePromotion()  && !PromotionExceptional::checkExceptionalPromotion())
                    {
                        if(isset($request->reduction) &&  !empty($request->reduction)  && !is_null($request->reduction))
                        {


                            $bill->start = SchoolYear::find($request->id_ann_scol)->startch1->firstOfMonth()->toDateString();
                            $bill->end = SchoolYear::find($request->id_ann_scol)->startch1->firstOfMonth()->addMonths($request->nbr_month)->toDateString();
                            $bill->somme =  PriceBill::countWhenNoPromotionButReduction($request->nbr_month,PriceBill::assignPrice($request->niveau,$request->transport),$request->reduction);
                            $bill->reductionPrix = $request->reduction;
                            $bill->reduction = 1;
                            $bill->school_year_id =  SchoolYear::getSchoolYearId();
                            $bill->nbrMois =$request->nbr_month;

                        }else{
                            $bill->start = SchoolYear::find($request->id_ann_scol)->startch1->firstOfMonth()->toDateString();
                            $bill->end = SchoolYear::find($request->id_ann_scol)->startch1->firstOfMonth()->addMonths($request->nbr_month)->toDateString();
                            $bill->somme = PriceBill::countWhenNoPromotion($request->nbr_month,PriceBill::assignPrice($request->niveau,$request->transport));
                            $bill->reduction = 0;
                            $bill->school_year_id =  $request->id_ann_scol;
                            $bill->nbrMois =$request->nbr_month;
                        }
                    }

                    if(PromotionAdvance::checkAdvancePromotion())
                    {
                        if($request->nbr_month >=3)
                        {
                            $bill->start = SchoolYear::find($request->id_ann_scol)->startch1->firstOfMonth()->toDateString();
                            $bill->end = SchoolYear::find($request->id_ann_scol)->startch1->firstOfMonth()->addMonths($request->nbr_month)->toDateString();
                            $bill->somme =PromotionAdvance::countAccordingTo($prix_advance,PriceBill::assignPrice($request->niveau,$request->transport),$request->nbr_month);
                            $bill->reduction = 1;
                            $bill->reductionPrix  = $prix_advance;
                            $bill->school_year_id = $request->id_ann_scol;
                            $bill->nbrMois =$request->nbr_month;
                        }
                        if($request->nbr_month == 1)
                        {
                            if(isset($request->reduction) &&  !empty($request->reduction)  && !is_null($request->reduction))
                            {
                                $bill->start = SchoolYear::find($request->id_ann_scol)->startch1->firstOfMonth()->toDateString();
                                $bill->end = SchoolYear::find($request->id_ann_scol)->startch1->firstOfMonth()->addMonths($request->nbr_month)->toDateString();
                                $bill->somme =  PriceBill::countWhenNoPromotionButReduction($request->nbr_month,PriceBill::assignPrice($request->niveau,$request->transport),$request->reduction);
                                $bill->reductionPrix = $request->reduction;
                                $bill->reduction = 1;
                                $bill->school_year_id = SchoolYear::getSchoolYearId();
                                $bill->nbrMois =$request->nbr_month;

                            }else{
                                $bill->start = SchoolYear::find($request->id_ann_scol)->startch1->firstOfMonth()->toDateString();
                                $bill->end = SchoolYear::find($request->id_ann_scol)->startch1->firstOfMonth()->addMonths($request->nbr_month)->toDateString();
                                $bill->somme = PriceBill::countWhenNoPromotion($request->nbr_month,PriceBill::assignPrice($request->niveau,$request->transport));
                                $bill->reduction = 0;
                                $bill->school_year_id = $request->id_ann_scol;
                                $bill->nbrMois =$request->nbr_month;
                            }
                        }
                    }
                    if(PromotionExceptional::checkExceptionalPromotion())
                    {
                        $bill->start = SchoolYear::find($request->id_ann_scol)->startch1->firstOfMonth()->toDateString();
                        $bill->end = SchoolYear::find($request->id_ann_scol)->startch1->firstOfMonth()->addMonths($request->nbr_month)->toDateString();
                        $bill->somme = PromotionExceptional::countAccordingTo($request->nbr_month,PriceBill::assignPrice($request->niveau,$request->transport),$prix_exc);
                        $bill->reductionPrix  = $prix_exc;
                        $bill->reduction = 1;
                        $bill->school_year_id = $request->id_ann_scol;
                        $bill->nbrMois =$request->nbr_month;
                    }




                    $bill->child_id = $child->id;
                    $bill->user_id = \Auth::user()->id;
                    $bill->save();


                    $enfant = Child::findOrFail($child->id);
                    if ($father->responsable == 0)
                        $resp = $father->nom_mere;
                    else
                        $resp = $father->nom_pere;
                    event(new SendEmailToRespAfterRegistrationEvent(
                        $child->id,
                        $resp,
                        $enfant->nom_enfant,
                        $enfant->created_at->toDateString(),
                        $enfant->created_at->addMonth()->toDateString(),
                        $father->email_responsable,
                        $father->responsable,
                        str_random(6)
                    ));
                }

            }
            return redirect()->back()->with('success', "l'élève et les parents ont bien été ajoutés! ");



        }else{
            // if the parent already in the database
            $child = new Child();
            $child->date_naissance = Carbon::parse($request->date_naissance);
            $child->nom_enfant = $request->nom_enfant ;
            $child->sexe = $request->sexe;
            $child->age_enfant =$child->date_naissance->diffInYears(Carbon::now());
            $child->nationalite =\DB::table('countries')->where('id',$request->nationalite)->first()->nom_fr_fr;
            $child->school_year_id = $request->id_ann_scol;
            $child->transport = $request->transport;
            $child->user_id = \Auth::user()->id;

            $image = \Input::file('photo');
            if(!$image && empty($image))
            {
                $filename = '';

            }else{
                $filename = $image->getClientOriginalName();
                $path = public_path('uploads/' . $filename);
                Image::make($image->getRealPath())->resize(313, 300)->save($path);
            }
            $child->photo = $filename;
            $child->family_id = $famille->id;
            $resp = Family::findOrFail($famille->id);
            $user =  User::where('email',$resp->email_responsable)->first();
            if($user)
            {
                $child->f_id =$user->id;
                $child->save();
                if($child->id)
                {

                    $ch =Child::find($child->id);
                    if($niveau_global == 'Lycée')
                    {
                        $ch->branches()->attach([$request->branche]);
                    }
                    if($niveau_global == 'Maternelle' || $niveau_global == 'Primaire'
                        || $niveau_global == 'Collège' || $niveau_global == 'Lycée' || $niveau_global == 'Crèche')
                    {
                        $ch->levels()->attach([$request->niveau]);
                    }
                    if($niveau_global == 'Crèche')
                    {
                        $ch->classrooms()->attach([$request->classe]);
                    }


                    $cr =  Classroom::where('user_id',\Auth::user()->id)->where('id',$request->classe)->first();
                    $cr->children()->attach([$child->id]);

                    $bill  = new Bill();
                    $bill->status = 0;
                    if(!PromotionAdvance::checkAdvancePromotion()  && !PromotionExceptional::checkExceptionalPromotion())
                    {
                        if(isset($request->reduction) &&  !empty($request->reduction)  && !is_null($request->reduction))
                        {
                            $bill->start = SchoolYear::find($request->id_ann_scol)->startch1->firstOfMonth()->toDateString();
                            $bill->end = SchoolYear::find($request->id_ann_scol)->startch1->firstOfMonth()->addMonths($request->nbr_month)->toDateString();
                            $bill->somme =  PriceBill::countWhenNoPromotionButReduction($request->nbr_month,PriceBill::assignPrice($request->niveau,$request->transport),$request->reduction);
                            $bill->reductionPrix = $request->reduction;
                            $bill->reduction = 1;
                            $bill->school_year_id =  $request->id_ann_scol;
                            $bill->nbrMois =$request->nbr_month;

                        }else{
                            $bill->start = SchoolYear::find($request->id_ann_scol)->startch1->firstOfMonth()->toDateString();
                            $bill->end = SchoolYear::find($request->id_ann_scol)->startch1->firstOfMonth()->addMonths($request->nbr_month)->toDateString();
                            $bill->somme = PriceBill::countWhenNoPromotion($request->nbr_month,PriceBill::assignPrice($request->niveau,$request->transport));
                            $bill->reduction = 0;
                            $bill->school_year_id =  $request->id_ann_scol;
                            $bill->nbrMois =$request->nbr_month;
                        }
                    }

                    if(PromotionAdvance::checkAdvancePromotion())
                    {
                        if($request->nbr_month >=3)
                        {
                            $bill->start = SchoolYear::find($request->id_ann_scol)->startch1->firstOfMonth()->toDateString();
                            $bill->end = SchoolYear::find($request->id_ann_scol)->startch1->firstOfMonth()->addMonths($request->nbr_month)->toDateString();
                            $bill->somme =PromotionAdvance::countAccordingTo($prix_advance,PriceBill::assignPrice($request->niveau,$request->transport),$request->nbr_month);
                            $bill->reduction = 1;
                            $bill->reductionPrix  = $prix_advance;
                            $bill->school_year_id = $request->id_ann_scol;
                            $bill->nbrMois =$request->nbr_month;
                        }
                        if($request->nbr_month == 1)
                        {
                            if(isset($request->reduction) &&  !empty($request->reduction)  && !is_null($request->reduction))
                            {
                                $bill->start = SchoolYear::find($request->id_ann_scol)->startch1->firstOfMonth()->toDateString();
                                $bill->end = SchoolYear::find($request->id_ann_scol)->startch1->firstOfMonth()->addMonths($request->nbr_month)->toDateString();
                                $bill->somme =  PriceBill::countWhenNoPromotionButReduction($request->nbr_month,PriceBill::assignPrice($request->niveau,$request->transport),$request->reduction);
                                $bill->reductionPrix = $request->reduction;
                                $bill->reduction = 1;
                                $bill->school_year_id = $request->id_ann_scol;
                                $bill->nbrMois =$request->nbr_month;

                            }else{
                                $bill->start = SchoolYear::find($request->id_ann_scol)->startch1->firstOfMonth()->toDateString();
                                $bill->end = SchoolYear::find($request->id_ann_scol)->startch1->firstOfMonth()->addMonths($request->nbr_month)->toDateString();
                                $bill->somme = PriceBill::countWhenNoPromotion($request->nbr_month,PriceBill::assignPrice($request->niveau,$request->transport));
                                $bill->reduction = 0;
                                $bill->school_year_id = $request->id_ann_scol;
                                $bill->nbrMois =$request->nbr_month;
                            }
                        }
                    }
                    if(PromotionExceptional::checkExceptionalPromotion())
                    {
                        $bill->start = SchoolYear::find($request->id_ann_scol)->startch1->firstOfMonth()->toDateString();
                        $bill->end = SchoolYear::find($request->id_ann_scol)->startch1->firstOfMonth()->addMonths($request->nbr_month)->toDateString();
                        $bill->somme = PromotionExceptional::countAccordingTo($request->nbr_month,PriceBill::assignPrice($request->niveau,$request->transport),$prix_exc);
                        $bill->reductionPrix  = $prix_exc;
                        $bill->reduction = 1;
                        $bill->school_year_id = $request->id_ann_scol;
                        $bill->nbrMois =$request->nbr_month;
                    }


                    $bill->child_id =$child->id;
                    $bill->f_id = $user->id;
                    $bill->user_id = \Auth::user()->id;
                    $bill->save();
                }
            }


            return redirect()->back()->with('success',"l'élève a bien été ajouté! ");
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
}
