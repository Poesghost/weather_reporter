<?php

namespace App\Console\Commands;

use App\Models\Zone;
use App\Models\Alert;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:alerts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets alerts from the weather.gov API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $zones = Zone::select('id', 'zone')->get()->toArray();

        $bar = $this->output->createProgressBar(count($zones));
        $bar->start();

        foreach($zones as $zone) {
            $weatherGovApiUrl = config('urls.api.weather_gov');
            
            $features = Http::get($weatherGovApiUrl . 'alerts/active/zone/' . $zone['zone'])['features'];
            
            if ($features) {
                foreach($features as $feature) {
                    $zone = Alert::firstOrCreate([
                        'zone_id' => $zone['id'],
                        'area_description' => $feature['properties']['areaDesc'],
                        'sent' => $feature['properties']['sent'],
                        'effective' => $feature['properties']['effective'],
                        'onset' => $feature['properties']['onset'],
                        'expires' => $feature['properties']['expires'],
                        'ends' => $feature['properties']['ends'],
                        'status' => $feature['properties']['status'],
                        'severity' => $feature['properties']['severity'],
                        'certainty' => $feature['properties']['certainty'],
                        'urgency' => $feature['properties']['urgency'],
                        'event' => $feature['properties']['event'],
                        'sender' => $feature['properties']['sender'],
                        'headline' => $feature['properties']['headline'],
                        'description' => $feature['properties']['description'],
                        'instruction' => $feature['properties']['instruction'],
                        'created_by' => 1,
                        'updated_by' => 1,
                    ]);
                }
            }

            $bar->advance();
        }

        $bar->finish();
        $this->info("\nOperation completed successfully.");

        return 0;
    }
}
