<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class TruncateJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'truncate:jobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'truncate jobs table';

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
        DB::table('jobs')->truncate();
    }
}
