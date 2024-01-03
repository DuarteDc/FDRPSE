<?php

namespace App\Http\Controllers;

use App\Models\Question;

class QuestionController extends Controller
{

    public function index()
    {
        $questions = Question::all();
        $this->responseJson($questions, 200);
    }

    public function save()
    {              
        $questions = new Question([
            'name' => 'Mi trabajo  me exige hacer mucho esfuerzo físico',
            'qualification_option_id' => 2
        ]);

        $questions->save();

        $this->responseJson(['questions' => $questions]);
    }
}