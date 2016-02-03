<?php

namespace App\Console\Commands;

use App\CategoryBill;
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
        if(Carbon::now()->toDateString() == Carbon::now()->endOfMonth()->toDateString())
        {
       $enfants =  Child::has('bills')->get();
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
        }
        }
       // Log::info('hello world je suis khalid bouslami');



    }
}
