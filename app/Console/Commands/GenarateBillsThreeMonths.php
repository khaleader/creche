<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class GenarateBillsThreeMonths extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'GenarateBills:billsThreeMonths';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $users = User::where('type','ecole')->get();
        foreach($users as $user)
        {
            $sc = SchoolYear::where('user_id',$user->id)->where('current',1)->first();
            if($sc->type == 'Semis' && Carbon::now()->between($sc->startch1,$sc->endch2))
            {
                foreach($user->children as $child)
                {
                    foreach($child->bills as $bill) {
                        $getChild = Bill::where('child_id', $bill->child_id)
                            ->where('reduction', 1)
                            ->where('school_year_id', $sc->id)
                            ->where('nbrMois',3)
                            ->orderBy('id','desc')
                            ->first();
                        if ($getChild) {
                            // give us from the end of bill to 3 months ahead
                            $fromStartToNbrMois = $getChild->end->addMonths($getChild->nbrMois);

                            if ($fromStartToNbrMois <= $sc->endch2) {
                                if (Carbon::now() >= $getChild->end) {
                                    $facture = new Bill();
                                    $facture->start = $getChild->end->toDateString();
                                    $facture->end = $getChild->end->addMonths($getChild->nbrMois)->toDateString();
                                    $facture->status = 0;
                                    $facture->user_id = $getChild->user_id;
                                    $facture->nbrMois = $getChild->nbrMois;
                                    $facture->reductionPrix = $getChild->reductionPrix;
                                    $facture->school_year_id = $getChild->school_year_id;
                                    $facture->reduction = 1;
                                    $enfant = Child::where('user_id', $getChild->user_id)->where('id', $getChild->child_id)->first();
                                    $taman = '';
                                    if ($getChild->reduction == 1) {
                                        if ($enfant->transport == 1) {
                                            foreach ($enfant->levels as $level) {
                                                $getPriceOfLevel = PriceBill::where('niveau', $level->id)
                                                    ->where('user_id', $getChild->user_id)->first();
                                                $taman = $getPriceOfLevel->prix;
                                            }
                                            $reductionTotalOnMonths = ($getChild->reductionPrix * $getChild->nbrMois);
                                            $total_transport = Transport::where('user_id', $getChild->user_id)->first()->somme * $getChild->nbrMois;
                                            $prix_according_to_months = $taman * $getChild->nbrMois;
                                            $prix_finale = ($prix_according_to_months - $reductionTotalOnMonths) + $total_transport;
                                            $facture->somme = $prix_finale;

                                        } elseif ($enfant->transport == 0) {

                                            foreach ($enfant->levels as $level) {
                                                $getPriceOfLevel = PriceBill::where('niveau', $level->id)
                                                    ->where('user_id', $getChild->user_id)->first();
                                                $taman = $getPriceOfLevel->prix;
                                            }
                                            $reductionTotalOnMonths = ($getChild->reductionPrix * $getChild->nbrMois);
                                            $prix_according_to_months = $taman * $getChild->nbrMois;
                                            $prix_finale = ($prix_according_to_months - $reductionTotalOnMonths);
                                            $facture->somme = $prix_finale;
                                        }
                                    }
                                    $facture->child_id = $getChild->child_id;
                                    $facture->f_id = $getChild->f_id;
                                    $facture->save();
                                    break;
                                }

                            }   elseif($fromStartToNbrMois > $sc->endch2) {
                                $last_bill = Bill::where('child_id', $getChild->child_id)
                                    ->where('reduction', 1)
                                    ->where('school_year_id', $sc->id)
                                    ->where('nbrMois', 1)
                                    ->orderBy('id', 'desc')
                                    ->first();
                                if (!$last_bill && Carbon::now() > $getChild->end) {
                                    $facture = new Bill();
                                    $facture->start = $getChild->end->toDateString();
                                    $facture->end = $getChild->end->addMonths(1)->toDateString();
                                    $facture->status = 0;
                                    $facture->user_id = $getChild->user_id;
                                    $facture->nbrMois = 1;
                                    $facture->reductionPrix = $getChild->reductionPrix;
                                    $facture->school_year_id = $getChild->school_year_id;
                                    $facture->reduction = 1;
                                    $enfant = Child::where('user_id', $getChild->user_id)->where('id', $getChild->child_id)->first();
                                    $taman = '';
                                    if ($getChild->reduction == 1) {
                                        if ($enfant->transport == 1) {
                                            foreach ($enfant->levels as $level) {
                                                $getPriceOfLevel = PriceBill::where('niveau', $level->id)
                                                    ->where('user_id', $getChild->user_id)->first();
                                                $taman = $getPriceOfLevel->prix;
                                            }
                                            $reductionTotalOnMonths = ($getChild->reductionPrix * 1);
                                            $total_transport = Transport::where('user_id', $getChild->user_id)->first()->somme * 1;
                                            $prix_according_to_months = $taman * 1;
                                            $prix_finale = ($prix_according_to_months - $reductionTotalOnMonths) + $total_transport;
                                            $facture->somme = $prix_finale;

                                        } elseif ($enfant->transport == 0) {

                                            foreach ($enfant->levels as $level) {
                                                $getPriceOfLevel = PriceBill::where('niveau', $level->id)
                                                    ->where('user_id', $getChild->user_id)->first();
                                                $taman = $getPriceOfLevel->prix;
                                            }
                                            $reductionTotalOnMonths = ($getChild->reductionPrix * 1);
                                            $prix_according_to_months = $taman * 1;
                                            $prix_finale = ($prix_according_to_months - $reductionTotalOnMonths);
                                            $facture->somme = $prix_finale;
                                        }
                                    }
                                    $facture->child_id = $getChild->child_id;
                                    $facture->f_id = $getChild->f_id;
                                    $facture->save();
                                    break;

                                }

                            }
                        }

                    }
                }


            }elseif($sc->type == 'Trim' && Carbon::now()->between($sc->startch1,$sc->endch3))
            {
                foreach($user->children as $child)
                {
                    foreach($child->bills as $bill)
                    {
                        $getChild = Bill::where('child_id',$bill->child_id)
                            ->where('reduction',1)
                            ->where('school_year_id',$sc->id)
                            ->where('nbrMois',3)
                            ->orderBy('id','desc')
                            ->first();

                        if($getChild) {
                            // give is from the end of bill to 3 months ahead
                            $fromStartToNbrMois = $getChild->end->addMonths($getChild->nbrMois);


                            if ($fromStartToNbrMois <= $sc->endch3) {
                                if (Carbon::now() >= $getChild->end) {
                                    $facture = new Bill();
                                    $facture->start = $getChild->end->toDateString();
                                    $facture->end = $getChild->end->addMonths($getChild->nbrMois)->toDateString();
                                    $facture->status = 0;
                                    $facture->user_id = $getChild->user_id;
                                    $facture->nbrMois = $getChild->nbrMois;
                                    $facture->reductionPrix = $getChild->reductionPrix;
                                    $facture->school_year_id = $getChild->school_year_id;
                                    $facture->reduction = 1;
                                    $enfant = Child::where('user_id', $getChild->user_id)->where('id', $getChild->child_id)->first();
                                    $taman = '';
                                    if ($getChild->reduction == 1) {
                                        if ($enfant->transport == 1) {
                                            foreach ($enfant->levels as $level) {
                                                $getPriceOfLevel = PriceBill::where('niveau', $level->id)
                                                    ->where('user_id', $getChild->user_id)->first();
                                                $taman = $getPriceOfLevel->prix;
                                            }
                                            $reductionTotalOnMonths = ($getChild->reductionPrix * $getChild->nbrMois);
                                            $total_transport = Transport::where('user_id', $getChild->user_id)->first()->somme * $getChild->nbrMois;
                                            $prix_according_to_months = $taman * $getChild->nbrMois;
                                            $prix_finale = ($prix_according_to_months - $reductionTotalOnMonths) + $total_transport;
                                            $facture->somme = $prix_finale;


                                        } elseif ($enfant->transport == 0) {

                                            foreach ($enfant->levels as $level) {
                                                $getPriceOfLevel = PriceBill::where('niveau', $level->id)
                                                    ->where('user_id', $getChild->user_id)->first();
                                                $taman = $getPriceOfLevel->prix;
                                            }
                                            $reductionTotalOnMonths = ($getChild->reductionPrix * $getChild->nbrMois);
                                            $prix_according_to_months = $taman * $getChild->nbrMois;
                                            $prix_finale = ($prix_according_to_months - $reductionTotalOnMonths);
                                            $facture->somme = $prix_finale;

                                        }
                                    }
                                    $facture->child_id = $getChild->child_id;
                                    $facture->f_id = $getChild->f_id;
                                    $facture->save();
                                    break;
                                }
                            } elseif ($fromStartToNbrMois >= $sc->endch3) {
                                $last_bill = Bill::where('child_id', $getChild->child_id)
                                    ->where('reduction', 1)
                                    ->where('school_year_id', $sc->id)
                                    ->where('nbrMois', 1)
                                    ->orderBy('id', 'desc')
                                    ->first();
                                if (!$last_bill && Carbon::now() > $getChild->end) {
                                    $facture = new Bill();
                                    $facture->start = $getChild->end->toDateString();
                                    $facture->end = $getChild->end->addMonths(1)->toDateString();
                                    $facture->status = 0;
                                    $facture->user_id = $getChild->user_id;
                                    $facture->nbrMois = 1;
                                    $facture->reductionPrix = $getChild->reductionPrix;
                                    $facture->school_year_id = $getChild->school_year_id;
                                    $facture->reduction = 1;
                                    $enfant = Child::where('user_id', $getChild->user_id)->where('id', $getChild->child_id)->first();
                                    $taman = '';
                                    if ($getChild->reduction == 1) {
                                        if ($enfant->transport == 1) {
                                            foreach ($enfant->levels as $level) {
                                                $getPriceOfLevel = PriceBill::where('niveau', $level->id)
                                                    ->where('user_id', $getChild->user_id)->first();
                                                $taman = $getPriceOfLevel->prix;
                                            }
                                            $reductionTotalOnMonths = ($getChild->reductionPrix * 1);
                                            $total_transport = Transport::where('user_id', $getChild->user_id)->first()->somme * 1;
                                            $prix_according_to_months = $taman * 1;
                                            $prix_finale = ($prix_according_to_months - $reductionTotalOnMonths) + $total_transport;
                                            $facture->somme = $prix_finale;

                                        } elseif ($enfant->transport == 0) {

                                            foreach ($enfant->levels as $level) {
                                                $getPriceOfLevel = PriceBill::where('niveau', $level->id)
                                                    ->where('user_id', $getChild->user_id)->first();
                                                $taman = $getPriceOfLevel->prix;
                                            }
                                            $reductionTotalOnMonths = ($getChild->reductionPrix * 1);
                                            $prix_according_to_months = $taman * 1;
                                            $prix_finale = ($prix_according_to_months - $reductionTotalOnMonths);
                                            $facture->somme = $prix_finale;
                                        }
                                    }
                                    $facture->child_id = $getChild->child_id;
                                    $facture->f_id = $getChild->f_id;
                                    $facture->save();
                                    break;

                                }
                            }


                        }


                    }
                }
            }

        }














    }
}
