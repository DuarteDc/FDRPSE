<?php

declare(strict_types=1);

namespace App\domain\qualificationQuestion;

use App\domain\BaseRepository;

interface QualificationQuestionRepository extends BaseRepository
{
    public function setQualification(array $body): QualificationQuestion;
    public function findQualificationByQuestion(string $questionId, string $type): ?QualificationQuestion;
}
