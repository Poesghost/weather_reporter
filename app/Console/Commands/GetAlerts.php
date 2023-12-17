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
    protected $signature = 'get:alerts {--all}';

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
        $states = [
            'Alabama' => 'AL',
            'Alaska' => 'AK',
            'Arizona' => 'AZ',
            'Arkansas' => 'AR',
            'American Samoa' => 'AS',
            'California' => 'CA',
            'Colorado' => 'CO',
            'Connecticut' => 'CT',
            'Delaware' => 'DE',
            'District of Columbia' => 'DC',
            'Florida' => 'FL',
            'Georgia' => 'GA',
            'Guam' => 'GU',
            'Hawaii' => 'HI',
            'Idaho' => 'ID',
            'Illinois' => 'IL',
            'Indiana' => 'IN',
            'Iowa' => 'IA',
            'Kansas' => 'KS',
            'Kentucky' => 'KY',
            'Louisiana' => 'LA',
            'Maine' => 'ME',
            'Maryland' => 'MD',
            'Massachusetts' => 'MA',
            'Michigan' => 'MI',
            'Minnesota' => 'MN',
            'Mississippi' => 'MS',
            'Missouri' => 'MO',
            'Montana' => 'MT',
            'Nebraska' => 'NE',
            'Nevada' => 'NV',
            'New Hampshire' => 'NH',
            'New Jersey' => 'NJ',
            'New Mexico' => 'NM',
            'New York' => 'NY',
            'North Carolina' => 'NC',
            'North Dakota' => 'ND',
            'Northern Mariana Islands' => 'MP',
            'Ohio' => 'OH',
            'Oklahoma' => 'OK',
            'Oregon' => 'OR',
            'Pennsylvania' => 'PA',
            'Puerto Rico' => 'PR',
            'Rhode Island' => 'RI',
            'South Carolina' => 'SC',
            'South Dakota' => 'SD',
            'Tennessee' => 'TN',
            'Texas' => 'TX',
            'Trust Territories' => 'TT',
            'Utah' => 'UT',
            'Vermont' => 'VT',
            'Virginia' => 'VA',
            'Virgin Islands' => 'VI',
            'Washington' => 'WA',
            'West Virginia' => 'WV',
            'Wisconsin' => 'WI',
            'Wyoming' => 'WY',
        ];

        $all = $this->option('all');

        if ($all) {
            $zones = Zone::select('id', 'zone')->get()->toArray();
        } else {
            // TODO: some zones do not have a state value and are NULL. Figure out what those are and if 
            // we need alerts for those zones

            foreach ($states as $key => $value) {
                $locations[] = $key; 
            }

            $location = $this->choice(
                'Please select a zone.',
                $locations,
                0
            );

            // TODO: need to ensure I'm not creating multiples of the same alert
            $zones = Zone::select('id', 'zone')
                ->whereIn('state', [$states[$location]])
                ->get()
                ->toArray();
        }

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
