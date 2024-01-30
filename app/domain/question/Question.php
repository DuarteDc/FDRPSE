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

    public function dimesion() {
        return $this->belongsTo(Dimension::class);
    }

    public function domain() {
        return $this->belongsTo(Domain::class);
    }


    public function getOneWithRelations(string $id)
    {
        return $this->with('section', 'qualification')->where('id', $id)->first();
    }

    // public function qualificationQuestions()
    // {
    //     return $this->belongsTo(QualificationOption::class);
    // }

    // public function subquestions()
    // {
    //     return $this->hasMany(Subquestion::class, 'question_id');
    // }

    // public function question() {
    //     return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $this->question), '-'));
    // }


}
