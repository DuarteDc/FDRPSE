<?php

namespace App\domain\survey;

use App\domain\surveyUser\SurveyUser;
use Illuminate\Database\Eloquent\Model;

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
}
