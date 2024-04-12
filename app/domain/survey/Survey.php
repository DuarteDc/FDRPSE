<?php

namespace App\domain\survey;

use App\domain\guide\Guide;
use App\domain\guideSurvey\GuideSurvey;
use App\domain\guideUser\GuideUser;
use Illuminate\Database\Eloquent\Model;

use App\domain\qualifications\Qualifications;
use App\domain\user\User;

class Survey extends Model
{
    const PENDING = false;
    const FINISHED = true;

    protected $table = 'surveys';
    protected $fillable = ['start_date', 'end_date', 'status'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'survey_users', 'survey_id', 'user_id')
            ->using(GuideUser::class)
            ->withPivot('status');
    }

    public function qualification()
    {
        return $this->morphOne(Qualifications::class, 'qualificationable');
    }

    public function guides()
    {
        return $this->belongsToMany(Guide::class)
            ->using(GuideSurvey::class)
            ->orderByPivot('id', 'asc')
            ->withPivot('status', 'id');
    }

    public function guidesUser()
    {
        return $this->belongsToMany(GuideUser::class, 'guide_survey_user');
    }
}
