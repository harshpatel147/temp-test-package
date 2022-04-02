Run a command for install this package

    composer require smiley/laravel-adminlte-starter-package
    
<hr>

after the installation of this package, **Run Command** from below list of command as per your requirements

**1.** To Generate a full authentication UI,

    php artisan ui adminlte --auth
    
---------- OR ----------

**1.** To Install just AdminLTE Theme assets,

    php artisan ui adminlte
    

**2.** And then run,
    
    npm install && npm run dev
    
    //------------ OR ------------
    
    npm install
    npm run dev
    
    
**2.** Or for production,
    
    npm install && npm run prod
   
**Note :-** If you have generated a full authentication UI then you need to **set `enable_default_authentication` key** value as a **true in `adminlte-starter-smiley` config file** which is located at config directory. and then you need to Clear Config Cache using `php artisan config:cache` command, if you doesn't find config file then you need to <a href="#publish-config">publish vendor's config file</a>

<hr>

-: Other Commands :- 

<strong><div id="publish-config">1. Publish Config File :- </strong> run `php artisan vendor:publish --provider="Smiley\AdminlteStarterPackage\AdminlteStarterServiceProvider" --tag="config"` command using this command it will publish vendor's config file in application's global config directory. </div> for more details about publish command see <a href="https://laravel.com/docs/8.x/packages#configuration">laravel docs</a> 






    
