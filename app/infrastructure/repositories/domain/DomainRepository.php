<?php

namespace App\infrastructure\repositories\domain;

use App\domain\domain\Domain;
use App\domain\domain\DomainRepository as ConfigDomainRepository;
use App\infrastructure\repositories\BaseRepository;

class DomainRepository extends BaseRepository implements ConfigDomainRepository
{

    public function __construct(private readonly Domain $domain)
    {
        parent::__construct($domain);
    }

    public function findByName(string $name): ?Domain
    {
        return $this->domain::where('name', $name)->first();
    }

}
 