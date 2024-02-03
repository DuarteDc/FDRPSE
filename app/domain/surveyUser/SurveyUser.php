<?php

namespace App\domain\surveyUser;

use App\domain\survey\Survey;
use App\domain\user\User;
use Illuminate\Database\Eloquent\Model;

class SurveyUser extends Model
{
    protected $table = 'survey_users';
    protected $fillable = ['survey_id', 'user_id', 'answers', 'status'];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

}
