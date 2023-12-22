<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Survey;

class SurveyController extends Controller
{

    public function index()
    {
        $survey = Survey::all();
        $this->responseJson(['surveys']);
    }

    public function save() {
    }

}
