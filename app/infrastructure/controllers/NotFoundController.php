<?php

namespace App\infrastructure\controllers;

use App\kernel\controllers\Controller;

class NotFoundController extends Controller {

    public function __invoke()
    {
        header('HTTP/1.1 404 Not Found');
        $this->view('not-found');
    }

}