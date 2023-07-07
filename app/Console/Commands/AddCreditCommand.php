<?php

namespace App\Console\Commands;

use Botble\RealEstate\Models\Package;
use Illuminate\Console\Command;

class AddCreditCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:credit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Monthly Credit';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $package = Package::where('price',0)->first();
        foreach ($package->accounts as $key => $account) {
            if($account->credit != $package->number_of_listings){
                $account->credit = $package->number_of_listings;
                $account->save();
            }
        }
        return Command::SUCCESS;
    }
}
