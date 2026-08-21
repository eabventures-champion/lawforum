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
            URL::forceScheme('https');
        }

        // Share active navigation menus and sidebar ads globally with all views
        view()->composer('*', function ($view) {
            try {
                $menus = \App\NavigationMenu::whereNull('parent_id')
                    ->where('is_active', true)
                    ->with(['children' => function ($query) {
                        $query->where('is_active', true)->orderBy('order')
                            ->with(['children' => function ($q) {
                                $q->where('is_active', true)->orderBy('order');
                            }]);
                    }])
                    ->orderBy('order')
                    ->get();
                $view->with('headerMenus', $menus);
            } catch (\Exception $e) {
                $view->with('headerMenus', collect());
            }

            try {
                $ads = \App\SidebarAd::get()->keyBy('slot_name');
                $view->with('sidebarAds', $ads);
            } catch (\Exception $e) {
                $view->with('sidebarAds', collect());
            }
        });

        // Automatically refresh search suggestions & autocomplete vocabulary whenever documents are created, updated, or deleted
        $documentModels = [
            \App\Post1992Act::class,
            \App\Pre1992LegislationAct::class,
            \App\GhanaAct::class,
            \App\ConstitutionalAct::class,
            \App\ExecutiveAct::class,
            \App\AmendRegulationAct::class,
            \App\GhAmendedAct::class,
            \App\GhLawJudgment::class,
            \App\ForeignLawJudgment::class,
            \App\AllConstitution::class,
        ];

        foreach ($documentModels as $modelClass) {
            try {
                if (class_exists($modelClass)) {
                    $modelClass::saved(function () {
                        \App\Services\SearchSuggestionService::clearCache();
                    });
                    $modelClass::deleted(function () {
                        \App\Services\SearchSuggestionService::clearCache();
                    });
                }
            } catch (\Exception $e) {}
        }
    }
}
