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
require_once __DIR__ . '/../routes/api.php';





