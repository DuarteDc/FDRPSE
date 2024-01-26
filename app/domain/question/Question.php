<?php

namespace App\domain\question;

use Illuminate\Database\Eloquent\Model;
class Question  extends Model
{

    protected $table = 'questions';
    protected $fillable = ['question', 'qualification_option_id', 'category_id', 'dimension_id', 'domain_id', 'question_id'];

    // public function qualificationQuestions()
    // {
    //     return $this->belongsTo(QualificationOption::class);
    // }

    // public function subquestions()
    // {
    //     return $this->hasMany(Subquestion::class, 'question_id');
    // }

    // public function question() {
    //     return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $this->question), '-'));
    // }


}
