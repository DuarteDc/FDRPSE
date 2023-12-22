<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Question;
use App\Models\CategoryDimensionDomainQuestion;

class Dimension extends Model
{

    protected $table = 'dimensions';

    protected $fillable = ['name'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function categoryDimensionDomainQuestion()
    {
        return $this->belongsTo(CategoryDimensionDomainQuestion::class);
    }
}
