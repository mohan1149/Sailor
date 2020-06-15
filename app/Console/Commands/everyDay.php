<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class everyDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:checkUserSubcription';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks Daily For User Subcription';

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
        echo 'check';
    }
}
