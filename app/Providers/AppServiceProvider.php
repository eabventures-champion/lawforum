<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;


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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('APP_ENV') === 'production') {
            URL::forceSchema('https');
        }

        // Share active navigation menus and sidebar ads globally with all views
        view()->composer('*', function ($view) {
            try {
                $menus = \App\NavigationMenu::whereNull('parent_id')
                    ->where('is_active', true)
                    ->with(['children' => function ($query) {
                        $query->where('is_active', true)->orderBy('order');
                    }])
                    ->orderBy('order')
                    ->get();
                $view->with('headerMenus', $menus);
            } catch (\Exception $e) {
                $view->with('headerMenus', collect());
            }

            try {
                $ads = \App\SidebarAd::where('is_active', true)->get()->keyBy('slot_name');
                $view->with('sidebarAds', $ads);
            } catch (\Exception $e) {
                $view->with('sidebarAds', collect());
            }
        });
    }
}
