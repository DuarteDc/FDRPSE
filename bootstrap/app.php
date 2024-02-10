<?php

/* -------- Run atoload from composer -------- */

require_once __DIR__ . '/../vendor/autoload.php';



/* -------- load environments -------- */

use Dotenv\Dotenv;

$dotenv = Dotenv::createUnsafeImmutable(__DIR__ . '/../');
$dotenv->safeLoad();



/* -------- Instance Database -------- */

use App\infrastructure\database\Database;
Database::getInstance()->connection();



/* -------- Timezone ------------*/

date_default_timezone_set(getenv('TIMEZONE'));

/* -------- Load Routes -------- */

require_once __DIR__ . '/../routes/api.php';





