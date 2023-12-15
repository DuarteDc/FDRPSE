<?php

use Illuminate\Database\Eloquent\Model;

class AnswerQuestionUser extends Model{

    protected $table = 'answer_question_users';

    protected  $fillable = ['answer_id', 'user_id'];



    public function answer(){
        
    }
        

}