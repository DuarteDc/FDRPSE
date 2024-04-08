<?php

namespace App\infrastructure\repositories\qualificationQuestion;

use App\domain\category\Category;
use App\domain\domain\Domain;
use App\domain\qualificationQuestion\QualificationQuestion;
use App\domain\qualificationQuestion\QualificationQuestionRepository as ContractsRepository;
use App\infrastructure\repositories\BaseRepository;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

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

    public function findQualificationByQuestion(string $questionId, string $type): ?QualificationQuestion
    {
        return $this->qualificationQuestion::where('question_id', $questionId)
            ->whereHas('qualificationable', function ($query) use ($type) {
                $query->where('qualificationable_type', $type);
            })->with('qualificationable')
            ->first();
    }
}
