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

    public function saveDomainAndSetQualification(object $body): Domain
    {
        $domain = new Domain(['name' => $body->name]);
        $domain->save();
        return $this->setDomainQualification($domain, $body);
    }

    public function setDomainQualification(Domain $domain, object $body): Domain
    {
        $domain->qualifications()->create([
            'despicable' => $body->despicable, 
            'low'        => $body->low,
            'middle'     => $body->middle,
            'high'       => $body->high,
            'very_hight' => $body->very_hight,
        ]);
        return $domain;
    }

}
 