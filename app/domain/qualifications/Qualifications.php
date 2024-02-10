<?php

namespace App\domain\qualifications;

use Illuminate\Database\Eloquent\Model;

class Qualifications extends Model
{

    protected $table = 'qualifications';
    protected $fillable = ['despicable', 'low', 'middle', 'high', 'very_hight', 'qualificationable_id', 'qualificationable_type'];

    public function qualificationable() 
    {
        return $this->morphTo();
    }

}
