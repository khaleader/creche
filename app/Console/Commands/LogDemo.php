<?php

namespace App\Console\Commands;

use App\CategoryBill;
use App\PriceBill;
use App\SchoolYear;
use Carbon\Carbon;
use DB;
use Illuminate\Console\Command;
use App\Child;
use Illuminate\Support\Facades\Auth;
use Log;
use App\Bill;
use App\User;

class LogDemo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:demo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monthly Bills.';

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
        if(Carbon::now()->toDateString() == Carbon::now()->startOfMonth()->toDateString())
        {

            $users = User::where('type','ecole')->get();
            foreach($users as $user)
            {
               $sc = SchoolYear::where('user_id',$user->id)->where('current',1)->first();
                if($sc->type == 'Semis' && Carbon::now()->between($sc->startch1,$sc->endch2))
                {
                    foreach($user->children as $child)
                    {
                        foreach($child->bills as $bill)
                        {
                            $getChild = Bill::where('child_id',$bill->child_id)
                                ->where('reduction',0)
                                ->where('school_year_id',$sc->id)
                                ->where('nbrMois',1)
                                ->orderBy('id','desc')
                                ->first();
                            if($getChild)
                            {
                                $facture = new Bill();
                                $facture->start = $getChild->end->toDateString();
                                $facture->end =$getChild->end->addMonth()->toDateString();
                                $facture->status = 0;
                                $facture->user_id = $getChild->user_id;

                                $enfant = Child::where('user_id',$getChild->user_id)->where('id',$getChild->child_id)->first();
                                $taman = '';
                                $transportStatus = $enfant->transport;
                                foreach($enfant->levels as $level)
                                {
                                    $getPriceOfLevel = PriceBill::where('niveau',$level->id)
                                        ->where('user_id',$getChild->user_id)->first();
                                    $taman = $getPriceOfLevel->prix;

                                }
                                $transportStatus == 0 ?
                                    $facture->somme =  $taman : $facture->somme = ($taman + Transport::where('user_id',$getChild->user_id)->first()->somme);


                                $facture->nbrMois = $getChild->nbrMois;
                                $facture->reductionPrix = null;
                                $facture->school_year_id = $getChild->school_year_id;
                                $facture->reduction = 0;
                                $facture->child_id =$getChild->child_id;
                                $facture->f_id = $getChild->f_id;
                                $facture->save();
                                break;
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
                                ->where('reduction',0)
                                ->where('school_year_id',$sc->id)
                                ->where('nbrMois',1)
                                ->orderBy('id','desc')
                                ->first();
                            if($getChild)
                            {
                                $facture = new Bill();
                                $facture->start = $getChild->end->toDateString();
                                $facture->end =$getChild->end->addMonth()->toDateString();
                                $facture->status = 0;
                                $facture->user_id = $getChild->user_id;

                                $enfant = Child::where('user_id',$getChild->user_id)->where('id',$getChild->child_id)->first();
                                $taman = '';
                                $transportStatus = $enfant->transport;
                                foreach($enfant->levels as $level)
                                {
                                    $getPriceOfLevel = PriceBill::where('niveau',$level->id)
                                        ->where('user_id',$getChild->user_id)->first();
                                    $taman = $getPriceOfLevel->prix;

                                }
                                $transportStatus == 0 ?
                                    $facture->somme =  $taman : $facture->somme = ($taman + Transport::where('user_id',$getChild->user_id)->first()->somme);


                                $facture->nbrMois = $getChild->nbrMois;
                                $facture->reductionPrix = null;
                                $facture->school_year_id = $getChild->school_year_id;
                                $facture->reduction = 0;
                                $facture->child_id =$getChild->child_id;
                                $facture->f_id = $getChild->f_id;
                                $facture->save();
                                break;
                            }

                        }
                    }
                }

            }



     /*  $enfants =  Child::has('bills')->get();
        foreach($enfants as $e)
        {
            foreach($e->bills as $b)
            {
               $d = Bill::where('child_id',$b->child_id)->orderBy('id','desc')->first();
               $bill = new Bill();
                $bill->start =$d->end->toDateString();
                $nextMonth7 =$d->end->addMonth()->toDateString();
                if(Carbon::parse($nextMonth7)->month == 7)
                {
                    $bill->end = Carbon::parse($nextMonth7)->addMonths(2)->toDateString();
                }else{
                    $bill->end = $nextMonth7;
                }
                $bill->status = 0;
                $bill->user_id = $d->user_id;
                $bill->somme =  $d->somme;
                $bill->child_id =$d->child_id;
                $bill->f_id = $d->f_id;
                $bill->save();
                break;


            }
        }*/
        }




    }
}
