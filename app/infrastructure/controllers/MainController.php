<?php

namespace App\infrastructure\controllers;

use App\kernel\controllers\Controller;
use App\kernel\views\Views;

final class MainController extends Controller
{
	use Views;

	public function __invoke()
	{
		return $this->view('index');
	}
}
