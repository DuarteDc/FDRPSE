<?php

namespace App\infrastructure\repositories\qualificationQuestion;

use App\domain\qualificationQuestion\QualificationQuestion;
use App\domain\qualificationQuestion\QualificationQuestionRepository as ContractsRepository;
use App\infrastructure\repositories\BaseRepository;

class QualificationQuestionRepository extends BaseRepository implements ContractsRepository
{
    public function __construct(private readonly QualificationQuestion $qualificationQuestion)
    {
        parent::__construct($qualificationQuestion);
    }

    public function setQualification(array $body): QualificationQuestion
    {
        $qualificationQuestion = new $this->qualificationQuestion($body);
        $qualificationQuestion->save();
        return $qualificationQuestion;
    }
}
