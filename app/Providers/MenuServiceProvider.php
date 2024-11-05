<?php

namespace App\Providers;

use App\Models\Menu;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
{
        $sidebarAppMenu = Menu::where('place', 0)->get()->setHidden([])->toArray();
        $profileAppMenu = Menu::where('place', 1)->get()->setHidden([])->toArray();
        $sidebarAppMenu = buildTree($sidebarAppMenu);
        $profileAppMenu = buildTree($profileAppMenu);
        // $sidebarAppMenu = [];
        // $profileAppMenu = [];
        // $sidebarAppMenu = buildTree($sidebarAppMenu);
        // $profileAppMenu = buildTree($profileAppMenu);
        View::composer('*', function ($view) use ($sidebarAppMenu, $profileAppMenu) {
            $view->with([
                'sidebarAppMenu' => $sidebarAppMenu,
                'profileAppMenu' => $profileAppMenu,
            ]);
        });
    }
}
