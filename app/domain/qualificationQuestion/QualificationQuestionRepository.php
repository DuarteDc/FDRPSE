<?php

namespace App\domain\qualificationQuestion;

use App\domain\BaseRepository;
use Illuminate\Support\Collection;

interface QualificationQuestionRepository extends BaseRepository {
    
    public function setQualification(array $body): QualificationQuestion;

}