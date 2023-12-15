<?php

/* -------- Run atoload from composer -------- */

require_once __DIR__ . '/../vendor/autoload.php';





/* -------- load environments -------- */

use App\Config\Database;
use Dotenv\Dotenv;

$dotenv = Dotenv::createUnsafeImmutable(__DIR__ . '/../');
$dotenv->safeLoad();



/* -------- Instance Database -------- */
Database::getInstance()->connection();





/* -------- Load Routes -------- */

use  Pecee\SimpleRouter\SimpleRouter as Router;

Router::setDefaultNamespace('\App\Http\Controllers');

require_once __DIR__ . '/../routes/api.php';

Router::start();





