<?php

namespace App\application\question;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use App\domain\question\QuestionRepository;

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

        $question =  $this->questionRepository->create($body);

        return $question ? ['message'=> 'La pregunta se agrego correctamente'] : new Exception('Parece que hubo un error al crear la pregunta', 500);       
    }

    public function getOneQuestion(string $id) {
        $question = $this->questionRepository->getOneWithRelations($id);
        return $question ? ['question' => $question] : new Exception('La pregunta que intentas buscar no existe', 404);
    }

}
