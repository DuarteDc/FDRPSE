<?php

namespace App\application\question;

use App\domain\question\QuestionRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class QuestionUseCase
{
    public function __construct(private readonly QuestionRepository $questionRepository, private readonly QuestionService $questionService)
    {
    }

    public function findAllQuestions(): Collection
    {
        return $this->questionRepository->findAll();
    }

    public function createQuestion(mixed $body): Exception | array
    {
        $isValidBody = $this->questionService->prepareDataToInsert($body);
        if ($isValidBody instanceof Exception) return $isValidBody;

        $domain = "";

        if (isset($body->domain_id)) {
            $domain = $this->questionService->domainIsValid($body->domain_id);
            if ($domain instanceof Exception) return $domain;
        }

        $question =  $this->questionRepository->create((array) $body);

        return $question ? ['message'=> 'La pregunta se agrego correctamente'] : new Exception('Parece que hubo un error al crear la pregunta', 500);       
    }
}
