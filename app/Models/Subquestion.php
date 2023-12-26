<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Question;

class Subquestion extends Model
{

    protected $table = 'subquestions ';
    protected $fillble = ['question_id', 'question'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
