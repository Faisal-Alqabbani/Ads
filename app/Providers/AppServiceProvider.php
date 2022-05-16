<?php

namespace App\Providers;

use App\Http\ViewComposer\CategoryComposer;
use App\Http\ViewComposer\CountryComposer;
use App\Http\ViewComposer\CurrencyComposer;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(CategoryComposer::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 
        view()->composer(
            ['partials.categoryNav', 'lists.categories', 'partials.searchfrm'], CategoryComposer::class
        ); 
        view()->composer(
            'lists.countries', CountryComposer::class
        );

        View()->composer(
            'lists.currencies', CurrencyComposer::class
        );
    }
}
