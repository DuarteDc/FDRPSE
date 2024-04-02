<?php

namespace App\domain\guide;

use App\domain\guideSurvey\GuideSurvey;
use App\domain\qualifications\Qualifications;
use App\domain\section\Section;
use App\domain\survey\Survey;
use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    protected $fillable = ['name'];
    protected $table = 'guides';

    const ACTIVE = 'active';
    const DISABLE = 'disable';

    public function surveys()
    {
        return $this->belongsToMany(Survey::class)->using(GuideSurvey::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function qualification()
    {
        return $this->morphOne(Qualifications::class,  'qualificationable');
    }
}
