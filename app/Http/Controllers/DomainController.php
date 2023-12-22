<?php

namespace App\Http\Controllers;

use App\Models\Domain;

class DomainController extends Controller
{

    public function index()
    {
        $domains = Domain::all();
        $this->responseJson($domains, 200);
    }

}
