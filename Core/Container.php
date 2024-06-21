<?php

namespace Core;

class Container
{

    protected $bindings = [];
    
    public function bind($key, $resolver)
    {

        $this->bindings[$key] = $resolver;
    }

    public function resolve($key)
    {

        if (!array_key_exists($key, $this->bindings)) {

            throw new \Exception("No matchings binding found  for {$key}");
        }


        $resolver = $this->bindings[$key];

        return call_user_func($resolver);
    }


    public static function handleErrors()
    {
        set_error_handler(function ($severity, $message, $file, $line) {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Internal Server Error', 'details' => $message]);
            exit;
        });

        set_exception_handler(function ($exception) {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Internal Server Error', 'details' => $exception->getMessage()]);
            exit;
        });
    }
}
