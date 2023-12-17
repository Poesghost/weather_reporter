<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GetZones extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:zones';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        logger('We getting in here?');
        
        return 0;
    }
}
