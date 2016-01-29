<?php

namespace App\Console\Commands;

use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class checkOfficielAndEssai extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:OfficielEssai';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command checks the duration of an essai account';

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
       $users = User::all();
        foreach($users as $user)
        {
            $type = $user->type;
            $typeCompte = $user->typeCompte;
            if($type == 'ecole' &&  $typeCompte == 0)
            {
                $jour7 = $user->created_at->addDays(7)->toDateString();
                if(Carbon::now()->toDateString() == $jour7)
                {
                    $utili = User::findOrFail($user->id);
                    $utili->blocked = 1;
                    $utili->save();

                }
            }
        }


        // 0 ==  essai and 1  ==  offciel

    }
}
