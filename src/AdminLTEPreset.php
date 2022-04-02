<?php 

namespace Smiley\AdminlteStarterPackage;

use Illuminate\Console\Command;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Laravel\Ui\Presets\Preset;
use Symfony\Component\Finder\SplFileInfo;

class AdminLTEPreset extends Preset
{
    /**
     * @var $command
     */
    protected $command;

    public function __construct(Command $command)
    {
        $this->command = $command;
    }

    /**
     * Update the given package array.
     *
     * @param array $packages
     *
     * @return array
     */
    protected static function updatePackageArray(array $packages)
    {
        return [
            'bootstrap'   => '^4.6.0',
            'jquery'      => '^3.6',
            'popper.js'   => '^1.16.1',
            'admin-lte'   => '3.1.0',
            'sass'        => '^1.15.2',
            'sass-loader' => '^8.0.0',
        ] + $packages;
    }

    /**
     * call this function when use hits `php artisan ui adminlte` command
     *
     * @return void
     */
    public function install()
    {
        static::updatePackages();
        static::updateWebpackConfiguration();
        static::updateSass();
        static::updateBootstrapping();
        static::removeNodeModules();
    }

    /**
     * Update the Webpack configuration.
     *
     * @return void
     */
    protected static function updateWebpackConfiguration()
    {
        copy(__DIR__.'/../adminlte-stubs/bootstrap/webpack.mix.js', base_path('webpack.mix.js'));
    }

    /**
     * Update the Sass files for the application.
     *
     * @return void
     */
    protected static function updateSass()
    {
        (new Filesystem())->ensureDirectoryExists(resource_path('sass'));

        copy(__DIR__.'/../adminlte-stubs/bootstrap/_variables.scss', resource_path('sass/_variables.scss'));
        copy(__DIR__.'/../adminlte-stubs/bootstrap/app.scss', resource_path('sass/app.scss'));
    }

    /**
     * Update the bootstrapping files.
     *
     * @return void
     */
    protected static function updateBootstrapping()
    {
        copy(__DIR__.'/../adminlte-stubs/bootstrap/bootstrap.js', resource_path('js/bootstrap.js'));
        copy(__DIR__.'/../adminlte-stubs/bootstrap/app.js', resource_path('js/app.js'));
    }

    /**
     * Get full view path relative to the application's configured view path.
     *
     * @param string $path
     *
     * @return string
     */
    public static function getViewPath($path = '')
    {
        return implode(DIRECTORY_SEPARATOR, [
            config('view.paths')[0] ?? resource_path('views'), $path,
        ]);
    }

    /**
     * call this function when use hits `php artisan ui adminlte --auth` command
     * 
     * it will install Authentication, Register, forgot password functionality
     *
     * @return void
     */
    public function installAuth()
    {
        $viewsPath = static::getViewPath();

        $this->ensureDirectoriesExist($viewsPath);

        $this->scaffoldAuth();

        $this->scaffoldThemeLayouts();

        // $this->scaffoldController();
    }

    /**
     * call this function when use hits `php artisan ui adminlte --layouts` command
     *
     * it will set comman header, footer, sidebar file
     * 
     * @return void
     */
    public function setThemeLayouts()
    {
        $viewsPath = static::getViewPath();
        $this->ensureDirectoriesExist($viewsPath);
        
        $this->scaffoldThemeLayouts();
    }

    protected function ensureDirectoriesExist($viewsPath)
    {
        if (!file_exists($viewsPath.'layouts')) {
            mkdir($viewsPath.'layouts', 0755, true);
        }

        if (!file_exists($viewsPath.'auth')) {
            mkdir($viewsPath.'auth', 0755, true);
        }

        if (!file_exists($viewsPath.'auth/passwords')) {
            mkdir($viewsPath.'auth/passwords', 0755, true);
        }
    }

    private function addAuthRoutes()
    {
        file_put_contents(
            base_path('routes/web.php'),
            "\nAuth::routes();\n",
            FILE_APPEND
        );
    }

    private function addHomeRoute()
    {
        file_put_contents(
            base_path('routes/web.php'),
            "\nRoute::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');\n",
            FILE_APPEND
        );
    }

    protected function scaffoldController()
    {
        if (!is_dir($directory = app_path('Http/Controllers/Auth'))) {
            mkdir($directory, 0755, true);
        }

        $filesystem = new Filesystem();

        collect($filesystem->allFiles(base_path('vendor/laravel/ui/stubs/Auth')))
            ->each(function (SplFileInfo $file) use ($filesystem) {
                $filesystem->copy(
                    $file->getPathname(),
                    app_path('Http/Controllers/Auth/'. Str::replaceLast('.stub', '.php', $file->getFilename()))
                );
            });
    }

    protected function scaffoldAuth()
    {
        // file_put_contents(app_path('Http/Controllers/HomeController.php'), $this->compileHomeControllerStub());

        // $this->addHomeRoute();

        // $this->addAuthRoutes();


        tap(new Filesystem(), function ($filesystem) {
            $filesystem->copyDirectory(__DIR__.'/../adminlte-stubs/auth', resource_path('views/auth'));
            
            /* collect($filesystem->allFiles(base_path('vendor/laravel/ui/stubs/migrations')))
                ->each(function (SplFileInfo $file) use ($filesystem) {
                    $filesystem->copy(
                        $file->getPathname(),
                        database_path('migrations/'.$file->getFilename())
                    );
                }); */
        });
    }

    protected function scaffoldThemeLayouts()
    {
        tap(new Filesystem(), function ($filesystem) {
            $filesystem->copyDirectory(__DIR__.'/../adminlte-stubs/layouts', resource_path('views/layouts'));
            $filesystem->copy(__DIR__.'/../adminlte-stubs/starter.blade.php', resource_path('views/starter.blade.php'));
            $filesystem->copy(__DIR__.'/../adminlte-stubs/home.blade.php', resource_path('views/home.blade.php'));
        });
    }

    protected function compileHomeControllerStub()
    {
        return str_replace(
            '{{namespace}}',
            Container::getInstance()->getNamespace(),
            file_get_contents(base_path('vendor/laravel/ui/src/Auth/stubs/controllers/HomeController.stub'))
        );
    }

}
