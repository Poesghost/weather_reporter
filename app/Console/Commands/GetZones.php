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
    protected $description = 'Gets all the zones from the National Weather Service';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        return 0;
    }
}
