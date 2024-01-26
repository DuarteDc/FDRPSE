<?php

namespace App\infrastructure\controllers;

use App\application\question\QuestionUseCase;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    public function __construct(private readonly QuestionUseCase $questionUseCase)
    {
    }

    public function index()
    {
        $questions =  $this->questionUseCase->findAll();
        $this->response(['questions' => $questions]);
    }
}
