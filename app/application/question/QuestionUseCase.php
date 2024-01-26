<?php


namespace App\application\question;

use App\domain\question\QuestionRepository;

class QuestionUseCase
{
    public function __construct(private readonly QuestionRepository $questionRepository)
    {
    }

    public function findAll(): array
    {
        return $this->questionRepository->findAll();
    }
}
