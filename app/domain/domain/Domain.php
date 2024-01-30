<?php

namespace App\domain\domain;

use App\domain\question\Question;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{

    protected $table = 'domains';
    protected $fillable = ['name'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
