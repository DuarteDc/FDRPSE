<?php

namespace App\domain\domain;

use App\domain\BaseRepository;
use App\domain\domain\Domain;
use Illuminate\Database\Eloquent\Collection;

interface DomainRepository extends BaseRepository {
    
    public function findByName(string $name): Domain | null;
    public function saveDomainAndSetQualification(object $body): Domain;
    public function setDomainQualification(Domain $domain, object $body): Domain;
    public function findWithQualifications(): Collection;
    public function findOneWithQualifications(string $domainId): ?Domain;
}