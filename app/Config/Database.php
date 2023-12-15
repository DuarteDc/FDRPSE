<?php

namespace App\Config;

use Exception;
use Illuminate\Database\Capsule\Manager as Capsule; 

class Database
{

    private static Database  | null $instance = null;
    private Capsule $capsule;

    public function __construct()
    {
        $this->capsule = new Capsule;
    }

    public static function getInstance() {
        if(is_null(self::$instance)) {
            $instance = new Database;
            return $instance;
        }

        return self::$instance;
    }


    public function connection() {
        try {
            $this->capsule->addConnection([
                'driver'    => getenv('DBDRIVER'),
                'host'      => getenv('HOST'),
                'database'  => getenv('DATABASE'),
                'username'  => getenv('USERNAME'),
                'password'  => getenv('PASSWORD'),
                'charset'   => 'utf8',
                'collation' => '',
                'prefix'    => '',
                'schema'    => 'public',
                'sslmode'   => 'prefer',
            ]);
    
            $this->capsule->bootEloquent();
        }catch(Exception $e) {
            new Exception($e->getMessage());
        }
    }

}
