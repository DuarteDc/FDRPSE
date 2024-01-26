<?php

namespace App\infrastructure\controllers;

use App\application\question\QuestionUseCase;
use App\Http\Controllers\Controller;
use App\Http\Requests\Question\CreateQuestionRequest;

class QuestionController extends Controller
{
    public function __construct(private readonly QuestionUseCase $questionUseCase)
    {
    }

    public function index()
    {
        $questions = $this->questionUseCase->findAllQuestions();
        $this->response(['questions' => $questions]);
    }

    public function createQuestion()
    {
        $this->validate(CreateQuestionRequest::rules(), CreateQuestionRequest::messages());
        $questions = $this->questionUseCase->createQuestion($this->request());
        $this->response($questions);
    }
}
