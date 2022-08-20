<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Livewire\Component;
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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Component::macro('notify', function ($message) {
            $this->dispatchBrowserEvent('notify', $message);
        });

        Carbon::macro('toFormattedDate', function () {
            return $this->format('Y / m / d');
        });

        config(['app.locale' => 'id']);
        Carbon::setLocale('id');

        Blade::directive('currency', function ( $expression ) {
            return "Rp <?php echo number_format($expression,0,',','.'); ?>";
        });

        Blade::directive('number', function ( $expression ) {
            return "<?php echo number_format($expression,2,',','.'); ?>";
        });
    }
}
