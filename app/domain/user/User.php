<?php

namespace App\domain\user;

use App\domain\surveyUser\SurveyUser;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $connection = 'second_db';

    public function surveyUser() {
        return $this->belongsTo(SurveyUser::class);
    }

}
