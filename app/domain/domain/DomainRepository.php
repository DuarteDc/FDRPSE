<?php

declare(strict_types=1);

namespace App\domain\domain;

use App\domain\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

interface DomainRepository extends BaseRepository
{
	public function findOneWithQualification(string $id, string | null $qualificationId): Domain|null;
	public function findByName(string $name): Domain|null;
	public function saveDomainAndSetQualification(object $body): Domain;
	public function setDomainQualification(Domain $domain, object $body): Domain;
	public function findWithQualifications(): Collection;
	public function findOneWithQualifications(string $domainId): ?Domain;
	public function addNewQualification(Domain $domain, mixed $qualification): Domain;
}
