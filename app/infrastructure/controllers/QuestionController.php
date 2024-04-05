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
        $type = (string) $this->get('type');
        $name = (string) $this->get('name');
        $questions = $this->questionUseCase->searchSections($type,$name);
        $this->response(['questions' => $questions]);
    }

    public function createQuestion()
    {
        $this->validate(CreateQuestionRequest::rules(), CreateQuestionRequest::messages());
        // $this->response($this->request());
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

    public function getQuestionsBySection(string $guideId) 
    {
        $page = (int) $this->get('page');
        $this->response($this->questionUseCase->getQuestionsBySectionAndTotalSections($guideId, $page));
    }

}
