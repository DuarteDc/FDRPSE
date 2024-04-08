<?php

namespace App\domain\qualificationQuestion;

use App\domain\BaseRepository;
use App\domain\category\Category;
use App\domain\domain\Domain;
use Illuminate\Database\Eloquent\Collection;

interface QualificationQuestionRepository extends BaseRepository
{

    public function setQualification(array $body): QualificationQuestion;
    public function findQualificationByQuestion(string $questionId, string $type): ?QualificationQuestion;
}
