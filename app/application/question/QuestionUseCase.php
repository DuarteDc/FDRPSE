<?php

namespace App\application\question;

use App\domain\qualificationQuestion\QualificationQuestionRepository;
use App\domain\question\Question;
use App\domain\question\QuestionRepository;
use App\domain\section\Section;
use Exception;
use Illuminate\Database\Eloquent\Collection;

final class QuestionUseCase
{
	public function __construct(
		private readonly QuestionRepository $questionRepository,
		private readonly QuestionService $questionService,
		private readonly QualificationQuestionRepository $qualificationQuestionRepository,
	) {}

	public function searchSections(string $type, string $name): Collection
	{
		return $this->questionRepository->findQuestionsByTypeAndSection($type, trim($name));
	}

	public function createQuestion(mixed $body): array|Exception
	{
		if ($body->type === Question::NONGRADABLE) {
			$question = $this->questionRepository->create($body);
			return $question ? ['message' => 'La pregunta se agrego correctamente'] : new Exception(
				'Parece que hubo un error al crear la pregunta',
				500
			);
		}

		$isValidBody = $this->questionService->prepareDataToInsert($body);
		if ($isValidBody instanceof Exception) {
			return $isValidBody;
		}

		$domain   = '';
		$category = '';

		if (isset($body->domain) || isset($body->categoy)) {
			$domain = $this->questionService->domainIsValid(
				(string) $body->domain['id'],
				$body->domain['qualification_id'] ?? null
			);
			$category = $this->questionService->categoryIsValid(
				(string) $body->category['id'],
				$body->category['qualification_id'] ?? null
			);

			if ($domain instanceof Exception) {
				return $domain;
			}
			if ($category instanceof Exception) {
				return $category;
			}
		}

		$question = $this->questionRepository->createQuestion((object) [
			...(array) $body,
			'category_id' => $body->category['id'] ?? null,
			'domain_id'   => $body->domain['id'] ?? null,
		]);

		if ($category && $category->qualification->id) {
			$this->qualificationQuestionRepository->setQualification([
				'qualificationable_id'   => $category->qualification->id,
				'qualificationable_type' => get_class($category->qualification),
				'question_id'            => $question->id,
			]);
		}

		if ($domain && $domain->qualification->id) {
			$this->qualificationQuestionRepository->setQualification([
				'qualificationable_id'   => $domain->qualification->id,
				'qualificationable_type' => get_class($domain->qualification),
				'question_id'            => $question->id,
			]);
		}

		return $question ? ['message' => 'La pregunta se agrego correctamente'] : new Exception(
			'Parece que hubo un error al crear la pregunta',
			500
		);
	}

	public function getOneQuestion(string $id): array|Exception
	{
		$question = $this->questionRepository->getQuestionDetail($id);
		return $question ? ['question' => $question] : new Exception('La pregunta que intentas buscar no existe', 404);
	}

	public function getQuestionsBySections(): mixed
	{
		$sections = $this->questionService->getQuestionsBySections();
		return ['sections' => $sections];
	}

	public function getQuestionsBySectionAndTotalSections(string $guideId, string $page)
	{
		$section       = $this->questionService->getQuestionBySection($guideId, $page);
		$totalSections = $this->questionService->getTotalSections($guideId);
		return $section ? [
			'current_page'  => $section->currentPage(),
			'section'       => $section[0] ?? [],
			'next_page'     => $section->nextPageUrl(),
			'previous_page' => $section->previousPageUrl(),
			'total_pages'   => $totalSections,
		] : new Exception('La sección que intentas buscar no existe', 404);
	}

	public function updateQuestion(string $questionId, object $body)
	{
		$question = $this->questionRepository->findOne($questionId);
		if (!$question) {
			return new Exception('La pregunta que intentas actualizar no existe', 404);
		}

		$isValidSection = $this->questionService->sectionIsValid((string) $body->section_id);
		if ($isValidSection instanceof Exception) {
			return $isValidSection;
		}
		if ($isValidSection->type !== Section::NONGRADABLE) {
			return new Exception("La pregunta no puede ser asignada a la sección {$isValidSection->name}", 400);
		}

		if ($question->type === Question::NONGRADABLE) {
			return $this->questionRepository->updateQuestion($question, (array) $body);
		}
	}
}
