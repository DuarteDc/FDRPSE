<?php

namespace App\domain\user;

use App\domain\area\Area;
use App\domain\guide\Guide;
use App\domain\guideUser\GuideUser;
use App\domain\survey\Survey;
use App\domain\surveyUser\SurveyUser;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    const ADMIN = 5;
    const USER  = 1;

    protected $table = 'usuarios';
    protected $connection = 'user_db';

    public function area()
    {
        return $this->belongsTo(Area::class, 'id_area');
    }

    public function surveys()
    {
        return $this->belongsToMany(Survey::class, 'survey_users', 'user_id', 'survey_id');
    }

    public function guides()
    {
        return $this->belongsToMany(User::class, 'guide_user', 'guide_id', 'user_id')
            ->using(GuideUser::class);
    }
}
