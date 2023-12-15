<?php

use App\Models\Question;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model {
    
    CONST ALWAYS        = 0;
    CONST ALMOST_ALWAYS = 1;
    CONST SOMETIMES     = 2;
    CONST ALMOST_NEVER  = 3;
    CONST NEVER         = 4;
    
    protected $table = 'answers';
    
    protected $fillable = ['answers' , 'question_id', 'user_id'];


    public function question() {
        return $this->belongsTo(Question::class);
    }


}