<?php

namespace App\Models;

class JwtSession 
{
    static $user = [];
    static function init($val)
    {
        $roles      = $val->roles;
        $domain     = env('APP_DOMAIN_NAME','');
        $key        = array_search($domain, array_column($roles, 'domain'));
        $role       = $roles[$key];
        $role_name  = config('reference.role');
        $role->name = $role_name[$role->role_id];
        
        self::$user = $val;
        self::$user->role = $role;
    }

    static function user()
    {
        return self::$user;
    }
}
