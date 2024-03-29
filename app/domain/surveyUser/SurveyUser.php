<?php

namespace App\domain\surveyUser;

use Illuminate\Database\Eloquent\Model;
use App\domain\user\User;
use App\domain\survey\Survey;

class SurveyUser extends Model
{
    const INPROGRESS = false;
    const FINISHED   = true;

    protected $table = 'survey_users';
    protected $fillable = ['survey_id', 'user_id', 'answers', 'status', 'total'];
    protected $casts = ['answers' => 'json'];

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
