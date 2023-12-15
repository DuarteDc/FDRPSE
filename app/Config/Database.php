<?php

namespace App\Config;

use Illuminate\Database\Capsule\Manager as Capsule; 

class Database
{

    private static Database $instance;
    private Capsule $capsule;

    public function __construct()
    {
        $this->capsule = new Capsule;
    }

    public static function getInstance() {
        if(empty(self::$instance)) 
            return new Database;

        return self::$instance;
    }


    public function connection() {
        $this->capsule->addConnection([
            'driver'    => getenv('DBDRIVER'),
            'host'      => getenv('HOST'),
            'database'  => getenv('DATABASE'),
            'username'  => getenv('USERNAME'),
            'password'  => getenv('PASSWORD'),
            'charset'   => getenv('UTF8'),
            'collation' => '',
            'prefix'    => '',
            'schema'    => 'public',
            'sslmode'   => 'prefer',
        ]);

        $this->capsule->bootEloquent();
    }

}
