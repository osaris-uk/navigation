<?php

namespace OsarisUk\Navigation;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Blade;
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
        
        Blade::directive('activeclass', function ($route) {
            return "{{ stripos(request()->route()->getName(), $route) === 0 ? 'active' : '' }}";
        });

        Blade::directive('openclass', function ($children) {
            return "<?php foreach($children as \$child) {if(stripos(request()->route()->getName(), \$child->route) === 0) {echo 'open';}} ?>";
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
