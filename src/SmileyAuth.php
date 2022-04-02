<?php 
namespace Smiley\AdminlteStarterPackage;

class SmileyAuth
{
    /**
     * Get the username used for authentication.
     *
     * @return string
     */
    public static function username()
    {
        return config('adminlte-starter-smiley.username', 'email');
    }

}