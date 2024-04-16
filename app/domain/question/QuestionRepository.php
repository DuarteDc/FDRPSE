<?php

namespace App\domain\question;

use App\domain\BaseRepository;
use App\domain\qualification\Qualification;
use Illuminate\Database\Eloquent\Collection;

interface QuestionRepository extends BaseRepository
{
	public function createQuestion(object $body): Question;
	public function findQuestionsByTypeAndSection(string $type, string $name): Collection;
	public function getQuestionBySection(): Collection;
	public function getQuestionDetail(string $questionId): Question|null;
	public function countQuestions(): int;
	public function getQualification(Question $question): ?Qualification;
	public function updateQuestion(Question $question, array $body): Question;
}
