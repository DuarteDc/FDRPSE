<?php

namespace App\infrastructure\repositories\question;

use App\domain\question\Question;
use App\infrastructure\repositories\BaseRepository;
use App\domain\question\QuestionRepository as ConfigQuestionRepository;
use Illuminate\Database\Eloquent\Collection;

class QuestionRepository extends BaseRepository implements ConfigQuestionRepository
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
        return $this->question::with(['section', 'qualification', 'category', 'dimesion', 'domain'])->where('id', $questionId)->first();
    }
    
}
