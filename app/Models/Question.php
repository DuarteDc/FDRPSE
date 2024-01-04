<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\QualificationOption;

class Question  extends Model
{

    protected $table = 'questions';
    protected $fillable = ['name', 'qualification_option_id'];

    public function qualificationQuestions()
    {
        return $this->belongsTo(QualificationOption::class);
    }

    public function subquestions()
    {
        return $this->hasMany(Subquestion::class, 'question_id');
    }
}
