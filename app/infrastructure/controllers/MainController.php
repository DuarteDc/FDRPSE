<?php 

namespace App\infrastructure\controllers;

use App\kernel\controllers\Controller;
use App\kernel\views\Views;

class MainController extends Controller {

    use Views;

    public function __invoke()
    {
        $this->view('index');
    }

}