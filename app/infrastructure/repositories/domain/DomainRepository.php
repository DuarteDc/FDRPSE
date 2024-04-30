<?php

namespace App\infrastructure\repositories\domain;

use App\domain\domain\Domain;
use App\domain\domain\DomainRepository as ContractsRepository;
use App\infrastructure\repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

final class DomainRepository extends BaseRepository implements ContractsRepository
{
	public function __construct(private readonly Domain $domain)
	{
		parent::__construct($domain);
	}

	public function findOneWithQualification(string $id, string|null $qualificationId): Domain|null
	{
		return $qualificationId ? $this->domain::where('id', $id)
			->with('qualification', function ($query) use ($qualificationId) {
				$query->where('id', $qualificationId);
			})->first()
			: $this->domain::where('id', $id)
			->with('qualification')
			->first();
	}

	public function findByName(string $name): ?Domain
	{
		return $this->domain::where('name', $name)->first();
	}

	public function saveDomainAndSetQualification(object $body): Domain
	{
		$domain = new $this->domain(['name' => $body->name]);
		$domain->save();
		return $this->setDomainQualification($domain, $body);
	}

	public function setDomainQualification(Domain $domain, object $body): Domain
	{
		$domain->qualifications()->createManyQuietly($body->qualifications);
		return $domain;
	}

	public function findWithQualifications(): Collection
	{
		return $this->domain->with('qualification')->get();
	}

	public function findOneWithQualifications(string $domainId): ?Domain
	{
		return $this->domain::with('qualifications')->find($domainId);
	}

	public function addNewQualification(Domain $domain, mixed $qualification): Domain
	{
		$domain->qualification()->create($qualification);
		return $this->findOneWithQualifications($domain->id);
	}

	public function removeQualification(Domain $domain, string $qualificationId): void
	{
		$qualification = $domain->qualification()->where('id', $qualificationId)->first();
		$qualification->delete();
	}
}
