<?php

declare(strict_types=1);

namespace App\Commands;

use Illuminate\Support\Facades\Http;
use LaravelZero\Framework\Commands\Command;

class StarwarsCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'starwars';

    /**
     * The description of the command.
     */
    protected $description = 'May the Species be with you! Explore Star Wars species data.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info("Fetching Star Wars species data...");

        try {
            $response = Http::get("https://swapi.dev/api/species/");

            if ($response->failed()) {
                $this->error("API request failed with status code: " . $response->status());
                return Command::FAILURE;
            }

            $data = $response->json();

            if (!isset($data['results']) || empty($data['results'])) {
                $this->warn("No species found in the Star Wars universe!");
                return Command::FAILURE;
            }

            $results = $data['results'];
            $headers = ['name', 'classification', 'designation', 'average_height', 'language', 'average_lifespan'];

            // Extract data for table rows
            $rows = [];
            foreach ($results as $result) {
                $row = [];
                foreach ($headers as $key) {
                    $value = $result[$key] ?? 'N/A';
                    if (is_array($value)) {
                        $value = count($value) . ' items';
                    }
                    $row[] = $value;
                }
                $rows[] = $row;
            }

            $this->table($headers, $rows);
            $this->info("Showing " . count($results) . " of " . $data['count'] . " total species in the Star Wars universe.");

        } catch (\Exception $e) {
            $this->error("Error fetching data: " . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
