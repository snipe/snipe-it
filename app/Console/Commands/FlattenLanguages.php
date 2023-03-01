<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FlattenLanguages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lang:flatten';

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
     * @return int
     */
    public function handle()
    {
        $lang = \Lang::all();
        print_r($lang);
        return 0;
    }
}
