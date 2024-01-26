<?php

namespace App\Http\Controllers;

use App\Http\Requests\Question\CreateQuestionRequest;
use App\Models\CategoryDimensionDomainQuestion;
use App\Models\Question;

class QuestionController extends Controller
{

    public function index()
    {
        $questions = Question::all();
        $this->responseJson(['questions' => $questions], 200);
    }

    public function save()
    {
        
        $this->validate(CreateQuestionRequest::rules(), CreateQuestionRequest::messages());
        ['question' => $question] = $this->request();

        return $this->responseJson(['question' => $this->request()]);



        $questions = new Question([
            'question' => $this->post('question'),
            'qualification_option_id' => 2
        ]);

        // $questions->save();

        $this->responseJson(['questions' => $questions]);
    }

    public function show(string $id) {
        $question = Question::find($id);
        

    }
}
