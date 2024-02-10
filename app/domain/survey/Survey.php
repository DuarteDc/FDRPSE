<?php

namespace App\domain\survey;

use Illuminate\Database\Eloquent\Model;

use App\domain\surveyUser\SurveyUser;
use App\domain\qualifications\Qualifications;

class Survey extends Model
{
    const PENDING = false;
    const FINISHED = true;

    protected $table = 'surveys';
    protected $fillable = ['start_date', 'end_date', 'answers', 'status'];

    public function surveyUser()
    {
        return $this->belongsToMany(SurveyUser::class);
    }

    public function qualifications()
    {
        return $this->morphMany(Qualifications::class, 'qualificationable');
    }
}
