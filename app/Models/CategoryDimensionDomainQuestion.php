<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Category;
use App\Models\Dimension;
use App\Models\Domain;
use App\Models\Question;

class CategoryDimensionDomainQuestion extends Model
{

    protected $table = 'category_dimension_domain_question';
    protected $fillable = ['category_id', 'dimension_id', 'domain_id', 'question_id'];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function dimensions()
    {
        return $this->hasMany(Dimension::class);
    }

    public function domains()
    {
        return $this->hasMany(Domain::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
