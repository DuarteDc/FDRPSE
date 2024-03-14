<?php

namespace App\infrastructure\repositories\question;

use App\domain\qualification\Qualification;
use App\domain\question\Question;
use App\infrastructure\repositories\BaseRepository;
use App\domain\question\QuestionRepository as ContractsRepository;
use Illuminate\Database\Eloquent\Collection;

class QuestionRepository extends BaseRepository implements ContractsRepository
{

    public function __construct(private readonly Question $question) {
        parent::__construct($question);
    }

    public function getQuestionBySection(): Collection
    {
        return $this->question::with('section')->get();
    }

    public function getQuestionDetail(string $questionId): Question | null
    {
        if(!is_numeric($questionId)) return null;
        return $this->question::with(['section', 'qualification', 'category', 'dimension', 'domain'])->where('id', $questionId)->first();
    }

    public function countQuestions(): int
    {
        return $this->question::count();
    }

    public function getQualification(Question $question): Qualification
    {
        return $question->qualification()->first(['always_op','almost_alwyas_op','sometimes_op','almost_never_op','never_op']);
    }

}
