<?php

namespace App\domain\domain;

use Illuminate\Database\Eloquent\Model;

use App\domain\question\Question;
use App\domain\qualifications\Qualifications;

class Domain extends Model
{

    protected $table = 'domains';
    protected $fillable = ['name'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function qualifications()
    {
        return $this->morphMany(Qualifications::class, 'qualificationable');
    }
}
