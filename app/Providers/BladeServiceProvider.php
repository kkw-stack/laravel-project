<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register() : void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot() : void
    {
        Blade::directive('antispambot', function ($email) {
            return '<?php echo antispambot(' . $email . '); ?>';
        });

        Blade::directive('replace_link', function (string $content) {
            return '<?php echo replace_link(' . $content . '); ?>';
        });

        Blade::directive('load_partials', function (string $expression) {
            $params = explode(',', $expression, 2);
            $view = trim($params[0]);
            $data = trim($params[1] ?? '');

            return "<?php echo view({$view}, {$data})->render(); ?>";
        });

        view()->composer('*', function ($view) {
            //
        });

        view()->composer('front.*', function ($view) {
            $view->with('locale', app()->getLocale());
        });
    }
}
