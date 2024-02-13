<?php

namespace App\domain\survey;

use Illuminate\Database\Eloquent\Model;

use App\domain\surveyUser\SurveyUser;
use App\domain\qualifications\Qualifications;
use App\domain\user\User;

class Survey extends Model
{
    const PENDING = false;
    const FINISHED = true;

    protected $table = 'surveys';
    protected $fillable = ['start_date', 'end_date', 'answers', 'status'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'survey_users', 'survey_id', 'user_id');
    }

    public function qualifications()
    {
        return $this->morphMany(Qualifications::class, 'qualificationable');
    }
}
