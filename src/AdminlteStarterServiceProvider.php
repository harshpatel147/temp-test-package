<?php

namespace Smiley\AdminlteStarterPackage;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Ui\UiCommand;

class AdminlteStarterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // merge the given Config with existing config
        $this->mergeConfigFrom(__DIR__.'/../config/adminlte-starter-smiley.php', 'adminlte-starter-smiley'); 
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureUiCommands();         
        
        $this->configureRoutes();
        $this->configurePublishing();
        // -----------------------------------------------------------------------------------
        
    }

    /**
     * Configure the template installation commands offered by the package.
     *
     * @return void
     */
    public function configureUiCommands()
    {
        UiCommand::macro('adminlte', function (UiCommand $command) {
            $adminLTEPreset = new AdminLTEPreset($command);
            $adminLTEPreset->install();
            $adminLTEPreset->setThemeLayouts();
            $command->info('AdminLTE scaffolding installed successfully.');

            if ($command->option('auth')) {
                $adminLTEPreset->installAuth();
                $command->info('AdminLTE Auth scaffolding installed successfully.');
            }

            $command->comment('Please run "npm install && npm run dev" to compile your fresh scaffolding template.');
        });
    }

    /**
     * Configure the publishable resources offered by the package.
     *
     * @return void
     */
    public function configurePublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/adminlte-starter-smiley.php' => config_path('adminlte-starter-smiley.php'),
            ], 'config');
        }
    }

    /**
     * Configure the routes offered by the application.
     *
     * @return void
     */
    protected function configureRoutes()
    {
        Route::group([
            'namespace' => 'Smiley\AdminlteStarterPackage\Http\Controllers\Auth',
            'domain' => config('adminlte-starter-smiley.domain', null),
            'prefix' => config('adminlte-starter-smiley.prefix'),
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }
}
