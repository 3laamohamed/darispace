<?php

namespace App\Providers;

use Botble\RealEstate\Models\Package;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // dd(Carbon::now()->firstOfMonth()->format('Y-m-d'),Carbon::now()->format('Y-m-d'));
        // $package = Package::where('price',0)->first();
        // dd($package);
        // foreach ($package->accounts as $key => $account) {
        //     # code...
        // }
        //
    }
}
