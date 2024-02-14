<?php

namespace App\domain\user;

use App\domain\area\Area;
use App\domain\survey\Survey;
use App\domain\surveyUser\SurveyUser;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    protected $table = 'usuarios';
    protected $connection = 'user_db';

    public function area() 
    {
        return $this->belongsTo(Area::class, 'id_area');
    }

    public function surveys()
    {
        return $this->belongsToMany(Survey::class, 'survey_users', 'user_id', 'survey_id')->using(SurveyUser::class);
    }
}
