<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class DeleteJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:jobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'delete all the jobs that stayed in the table';

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
       DB::table('jobs')->delete();
    }
}
