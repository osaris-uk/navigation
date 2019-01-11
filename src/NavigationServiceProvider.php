<?php

namespace OsarisUk\Navigation;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use OsarisUk\Navigation\Models\Navigation;

class NavigationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/navigation.php' => config_path('navigation.php'),
        ], 'config');

        $this->loadMigrationsFrom(__DIR__.'/../migrations');

        try {
            foreach(config('navigation.navigations') as $key => $value) {
                view()->composer($key, function ($view) use ($value)
                {
                    $view->with('navItems', Navigation::tree()->whereIn('realm', $value));
                });
            }
        } catch (\Exception $e) {
            Log::error($e);
            return false;
        }
        
        Blade::directive('activeclass', function ($page) {
            return "{{ request()->is($page) ? 'active' : '' }}";
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/navigation.php', 'navigation'
        );
    }
}
