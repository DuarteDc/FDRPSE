<?php

namespace App\Models;

use App\Models\Question;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{

    protected $table = 'domains';
    protected $fillable = ['name'];

    public function questions()
    {
        return $this->morphMany(Question::class, 'questionable');
    }
}
