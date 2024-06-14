<?php
namespace Core\Middleware;

use Core\Middleware\Admin;

class Middleware{

   public const MAP = [
        'guest' => Guest::class,
        'admin' => Admin::class,
        'instructor' => Instructor::class,
        'student' => Student::class,
    ];


    public static function resolve($key){
        if(!$key){
            return;
        }

        $middleware = static::MAP[$key] ?? false;

        if(! $middleware){
            throw new \Exception("No matching Middleware found for key '{$key}'.");
        }

        (new $middleware)->handle();
    }

}