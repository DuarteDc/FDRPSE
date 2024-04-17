<?php

namespace App\infrastructure\controllers;

use App\application\question\QuestionUseCase;
use App\infrastructure\requests\question\CreateQuestionRequest;
use App\infrastructure\requests\question\UpdateQuestionRequest;
use App\kernel\controllers\Controller;

final class QuestionController extends Controller
{
	public function __construct(private readonly QuestionUseCase $questionUseCase) {}

	public function getAllQuestions()
	{
		$type      = (string) $this->get('type');
		$name      = (string) $this->get('name');
		$page      = (string) $this->get('page');
		$questions = $this->questionUseCase->searchSections($type, $name, $page);
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

	public function getQuestionsBySection(string $guideId)
	{
		$page = (string) $this->get('page');
		$this->response($this->questionUseCase->getQuestionsBySectionAndTotalSections($guideId, $page));
	}

	public function updateQuestion(string $questionId)
	{
		$this->validate(UpdateQuestionRequest::rules(), UpdateQuestionRequest::messages());
		$this->response($this->questionUseCase->updateQuestion($questionId, $this->request()));
	}
}
