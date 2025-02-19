<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CustomerCSVImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:customer {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import customers from a CSV file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $file = $this->argument('file');

        $this->info('Importing customers from ' . basename($file));

        // read file handler
        $handle = fopen($file, "r");
        echo($handle);
        if ($handle) {

            // ignore first line as it's the header
            fgetcsv($handle);

            while (($row = fgetcsv($handle)) !== false) {
                // insert row into database
                $customer = new \App\Models\Customer();
                $customer->id = $row[0];
                $customer->first_name = $row[1];
                $customer->last_name = $row[2];
                $customer->email = $row[3];
                $customer->gender = $row[4];
                $customer->save();

                $ip = new \App\Models\CustomerIpAddress();
                $ip->customer_id = $customer->id;
                $ip->ip_address = $row[5];
                $ip->save();

                $company = new \App\Models\CustomerCompany();
                $company->customer_id = $customer->id;
                $company->company = $row[6];
                $company->city = $row[7];
                $company->title = $row[8];
                $company->website = $row[9];
                $company->save();
            }
        }

        $this->info('Done!');
    }
}
