<?php

namespace App\Console\Commands;

use App\Family;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ManageYears extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Manage:years';

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
        $users =  User::where('type','ecole')->get();
        foreach($users as $user)
        {
            $sc = SchoolYear::where('user_id',$user->id)->where('current',1)->first();
            if($sc)
            {
                if($sc->type == 'Semis' && $sc->endch2 <  Carbon::now()->toDateString() ||
                    $sc->type == 'Trim' &&  $sc->endch3 <  Carbon::now()->toDateString()
                ){
                    foreach($user->families as $famille)
                    {
                        $f = Family::where('email_responsable',$famille->email_responsable)
                            ->where('school_year_id',$sc->id)
                            ->first();
                        if($f)
                        {
                            $f->email_responsable = $sc->ann_scol.$f->email_responsable;
                            $f->cin = $sc->cin.$f->cin;
                            $f->save();

                            $fu = User::where('type','famille')->where('email',substr($f->email_responsable,9))->first();
                            if($fu)
                            {
                                $fu->email = $sc->ann_scol.$fu->email;
                                $fu->save();
                            }
                        }
                    }
                    $sc->current = 0;
                    $sc->save();
                    $ynow = Carbon::now()->year;
                    $ynext = Carbon::now()->year + 1;
                    $yes = SchoolYear::where('user_id',$user->id)
                        ->where('ann_scol',$ynow.'-'.$ynext)->first();
                    if ($yes) {
                        $yes->current = 1;
                        $yes->save();
                    }
                }
            }

        }

    }
}
