<?php

namespace App\domain\qualificationQuestion;

use App\domain\qualifications\Qualifications;
use App\domain\question\Question;
use Illuminate\Database\Eloquent\Model;

class QualificationQuestion extends Model
{

    protected $table = 'qualifications_question';
    protected $fillable = ['question_id', 'qualificationable_id', 'qualificationable_type'];

    const CATEGORY = 'category';
    const DOMIAN = 'domain';

    public function qualificationable()
    {
        return $this->morphTo();
    }

    public function qualificationQuestions()
    {
        return $this->morphMany(QualificationQuestion::class, 'qualificationable');
    }
}
