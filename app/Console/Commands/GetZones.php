<?php

namespace App\Console\Commands;

use App\Models\Zone;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

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
        $weatherGovApiUrl = config('urls.api.weather_gov');

        $features = Http::get($weatherGovApiUrl . 'zones')['features'];

        $bar = $this->output->createProgressBar(count($features));
        $bar->start();

        if ($features) {
            foreach($features as $feature) {
                $zone = Zone::firstOrCreate([
                    'zone' => $feature['properties']['id'],
                    'county' => $feature['properties']['name'],
                    'state' => $feature['properties']['state'],
                    'created_by' => 1,
                    'updated_by' => 1,
                ]);

                $bar->advance();
            }
        }

        $bar->finish();
        $this->info("\nOperation completed successfully.");

        return 0;
    }
}
