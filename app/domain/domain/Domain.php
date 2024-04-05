<?php

namespace App\domain\domain;

use App\domain\qualificationQuestion\QualificationQuestion;
use Illuminate\Database\Eloquent\Model;

use App\domain\question\Question;
use App\domain\qualifications\Qualifications;

class Domain extends Model
{

    protected $table = 'domains';
    protected $fillable = ['name'];
    protected $withCount = ['qualifications'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function qualifications()
    {
        return $this->morphMany(Qualifications::class, 'qualificationable');
    }

    public function qualification()
    {
        return $this->morphOne(Qualifications::class, 'qualificationable');
    }

    public function qualificationQuestion()
    {
        return $this->morphOne(QualificationQuestion::class, 'qualificationable');
    }


    public function qualificationsQuestion()
    {
        return $this->morphMany(QualificationQuestion::class, 'qualificationable');
    }
}
