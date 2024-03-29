<?php

namespace App\infrastructure\controllers;

use App\kernel\controllers\Controller;
use App\application\question\QuestionUseCase;
use App\infrastructure\requests\question\CreateQuestionRequest;

class QuestionController extends Controller
{
    public function __construct(private readonly QuestionUseCase $questionUseCase)
    {
    }

    public function getAllQuestions()
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

    public function getQuestion(string $id)
    {
        $response = $this->questionUseCase->getOneQuestion($id);
        $this->response($response);
    }

    public function getQuestionBySections() 
    {
        $this->response($this->questionUseCase->getQuestionsBySections());
    }

    public function getQuestionsBySection() 
    {
        $page = (int) $this->get('page');
        $userId = $this->auth()->id;
        $this->response($this->questionUseCase->getQuestionsBySectionAndTotalSections($page, $userId));
    }

}
