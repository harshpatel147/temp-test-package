<?php 

return [
    /*
    |--------------------------------------------------------------------------
    | Authentication Routes Middleware
    |--------------------------------------------------------------------------
    |
    | Here you may specify which middleware will assign to the routes
    | that it registers with the application. If necessary, you may change
    | these middleware but typically this provided default is preferred.
    |
    */
    'middleware' => ['web'],

    /*
    |--------------------------------------------------------------------------
    | Enable Package's Authentication 
    |--------------------------------------------------------------------------
    | If you wants to use this package's authentication routes then set 
    | this value to true, otherwise default value is false.
    |
    | Here you may specify this `false` if authentication routes should be 
    | disabled as you may not need them when building your own custom  
    | authentication logic. 
    |
    */
    'enable_default_authentication' => false,

    /* 
    |--------------------------------------------------------------------------
    | Authentication Routes Prefix / Subdomain
    |--------------------------------------------------------------------------
    |
    | Here you may specify which prefix will assign to all the routes of this
    | package that it registers with the applications. If necessary, you may 
    | change subdomain under which all of the routes of this package will be available.
    |
    */
    'prefix' => '',

    'domain' => null,

    /*
    |--------------------------------------------------------------------------
    | Username 
    |--------------------------------------------------------------------------
    |
    | This value defines which model attribute should be considered as your
    | application's "username" field. & this value is used for authentication 
    | (user login). Typically, this might be the email address of the users 
    | but you are free to change this value here.
    |
    */
    'username' => 'email',

    /*
    |--------------------------------------------------------------------------
    | Authentication Helper Class Namespace 
    |--------------------------------------------------------------------------
    |
    | This value is used for get authentication helper class namespace.
    |
    |******* CAUTION **********************************************************
    | 
    | If you need to change this value then do it with very carefully. 
    | This might will retuns Errors.
    | 
    */
    'auth_helper' => Smiley\AdminlteStarterPackage\SmileyAuth::class,
];