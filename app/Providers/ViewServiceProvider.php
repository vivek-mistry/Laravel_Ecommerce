<?php

namespace App\Providers;

use App\View\Components\Backend\Common\Breadcrumb;
use App\View\Components\Backend\Common\Navigation;
use App\View\Components\Backend\Common\PageLoader;
use App\View\Components\Backend\Master\Footer;
use App\View\Components\Backend\Master\HeaderAndSidebar;
use App\View\Components\FrontEnd\Common\Breadcrumb as FrontEndBreadcrumb;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Backend Component
         */
        Blade::component('backend-header-and-sidebar', HeaderAndSidebar::class); // Header & SideBar
        Blade::component('backend-footer', Footer::class); // Footer
        Blade::component('backend-page-loader', PageLoader::class); // Page Loader
        Blade::component('backend-breadcrumb', Breadcrumb::class); // Breadcrumb
        Blade::component('backend-navigation', Navigation::class); // Backend-Navigation

        /**
         * Frontend component
         */
        Blade::component('frontend-breadcrumb', FrontEndBreadcrumb::class);
    }
}
