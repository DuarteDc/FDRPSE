<?php

namespace App\infrastructure\repositories\section;

use Illuminate\Database\Eloquent\Model;
use App\domain\section\SectionRepository as ConfigSectionRepository;
use App\infrastructure\repositories\BaseRepository;


class SectionRepository extends BaseRepository implements ConfigSectionRepository
{

    public function __construct(private readonly Model $model) {
        parent::__construct($model);
    }
    
}
