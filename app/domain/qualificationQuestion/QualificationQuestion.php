<?php

namespace App\domain\qualificationQuestion;

use Illuminate\Database\Eloquent\Model;

class QualificationQuestion extends Model
{

    protected $table = 'qualifications_question';
    protected $fillable = ['question_id', 'qualificationable_id', 'qualificationable_type'];

    public function qualificationable()
    {
        return $this->morphTo();
    }

}
