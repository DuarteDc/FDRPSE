<?php

namespace App\application\question;

use App\domain\question\Question;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use App\domain\question\QuestionRepository;
use App\domain\surveyUser\SurveyUserRepository;

class QuestionUseCase
{
    public function __construct(private readonly QuestionRepository $questionRepository, private readonly QuestionService $questionService, private readonly SurveyUserRepository $surveyUserRepository)
    {
    }

    public function searchSections(string $type, string $name): Collection
    {
        return $this->questionRepository->findQuestionsByTypeAndSection($type, trim($name));
    }

    public function createQuestion(mixed $body): Exception | array
    {
        if ($body->type === Question::GRADABLE) {
            $question =  $this->questionRepository->create($body);
            return $question ? ['message' => 'La pregunta se agrego correctamente'] : new Exception('Parece que hubo un error al crear la pregunta', 500);
        }

        $isValidBody = $this->questionService->prepareDataToInsert($body);
        if ($isValidBody instanceof Exception) return $isValidBody;

        $domain = "";
        $category = "";

        if (isset($body->domain_id) || isset($body->categoy_id)) {
            $domain = $this->questionService->domainIsValid($body->domain_id);
            $category = $this->questionService->categoryIsValid($body->category_id);
            if ($domain instanceof Exception) return $domain;
            if ($category instanceof Exception) return $category;
        }

        $question =  $this->questionRepository->create($body);

        return $question ? ['message' => 'La pregunta se agrego correctamente'] : new Exception('Parece que hubo un error al crear la pregunta', 500);
    }

    public function getOneQuestion(string $id): Exception | array
    {
        $question = $this->questionRepository->getQuestionDetail($id);
        return $question ? ['question' => $question] : new Exception('La pregunta que intentas buscar no existe', 404);
    }

    public function getQuestionsBySections(): mixed
    {
        $sections = $this->questionService->getQuestionsBySections();
        return ['sections' => $sections];
    }

    public function getQuestionsBySectionAndTotalSections(string $page, int $userId)
    {
        $surveyUser = $this->surveyUserRepository->getUserAnwserInCurrentSurvey($userId);

        if ($surveyUser && $surveyUser->answers) {
            $lastSection = $this->getLastSection($surveyUser->answers)['id'];
            if ($page > $lastSection) $page = $lastSection + 1;
        }

        $section = $this->questionService->getQuestionBySection($page);
        $totalSections = $this->questionService->getTotalSections();
        return $section ? [
            'current_page'  => $section->currentPage(),
            'section'       => $section[0] ?? [],
            'next_page'     => $section->nextPageUrl(),
            'previous_page' => $section->previousPageUrl(),
            'total_pages'   => $totalSections,
        ] : new Exception('La sección que intentas buscar no existe', 404);
    }

    private function getLastSection(array $anwers): mixed
    {
        return max(array_map(fn ($question): mixed => $question['section'],  $anwers));
    }
}
