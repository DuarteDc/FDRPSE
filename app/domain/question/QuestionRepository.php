<?php

namespace App\domain\question;

use App\domain\BaseRepository;
use App\domain\qualification\Qualification;
use Illuminate\Database\Eloquent\Collection;

interface QuestionRepository extends BaseRepository
{
    public function getQuestionBySection(): Collection;
    public function getQuestionDetail(string $questionId) : Question | null;
    public function countQuestions(): int;
    public function getQualification(Question $question): Qualification;
}
