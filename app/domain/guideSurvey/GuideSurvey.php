<?php

namespace App\domain\guideSurvey;

use App\domain\guide\Guide;
use App\domain\survey\Survey;
use Illuminate\Database\Eloquent\Relations\Pivot;

class GuideSurvey extends Pivot
{

    protected $table = 'guide_survey';
    protected $fillable = ['guide_id', 'survey_id', 'status'];

    public function guides()
    {
        return $this->hasMany(Guide::class);
    }

    public function surveys()
    {
        return $this->hasMany(Survey::class);
    }

}
