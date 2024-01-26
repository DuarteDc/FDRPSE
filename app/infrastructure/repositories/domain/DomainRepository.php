<?php

namespace App\infrastructure\repositories\domain;
use Illuminate\Database\Eloquent\Model;

use App\domain\domain\DomainRepository as ConfigDomainRepository;
use App\infrastructure\repositories\BaseRepository;

class DomainRepository extends BaseRepository implements ConfigDomainRepository
{

    public function __construct(private readonly Model $model)
    {
        parent::__construct($model);
    }

}
 