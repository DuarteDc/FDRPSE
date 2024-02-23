<?php

namespace App\domain\question;

use Illuminate\Database\Eloquent\Model;

use App\domain\category\Category;
use App\domain\dimension\Dimension;
use App\domain\domain\Domain;
use App\domain\qualification\Qualification;
use App\domain\section\Section;

class Question  extends Model
{

    protected $table = 'questions';
    protected $fillable = ['name', 'qualification_id', 'category_id', 'dimension_id', 'domain_id', 'section_id'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function qualification()
    {
        return $this->belongsTo(Qualification::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function dimension()
    {
        return $this->belongsTo(Dimension::class);
    }

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }

}
