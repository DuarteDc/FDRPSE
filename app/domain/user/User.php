<?php

namespace App\domain\user;

use App\domain\surveyUser\SurveyUser;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    protected $table = 'usuarios';
    protected $connection = 'user_db';

    public function surveyUser() {
        return $this->belongsTo(SurveyUser::class);
    }

}
