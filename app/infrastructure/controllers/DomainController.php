<?php

namespace App\infrastructure\controllers;

use App\application\domain\DomainUseCase;
use App\infrastructure\requests\domain\CreateDomainRequest;
use App\kernel\controllers\Controller;

final class DomainController extends Controller
{
	public function __construct(private readonly DomainUseCase $domainUseCase) {}

	public function getAllDomains()
	{
		$this->response($this->domainUseCase->findAllDomains());
	}

	public function createDomain()
	{
		$this->validate(CreateDomainRequest::rules(), CreateDomainRequest::messages());
		$this->response($this->domainUseCase->createDomain($this->request()), 201);
	}

	public function getDomainsWithQualifications()
	{
		$this->response($this->domainUseCase->findDomaisWithQualifications());
	}

	public function getDomainWithQualifications(string $id)
	{
		$this->response($this->domainUseCase->findDomainWithQualifications($id));
	}

	public function addNewQualification(string $domainId)
	{
		$this->response($this->domainUseCase->addQualification($domainId, $this->request()->qualification));
	}

	public function deleteQualification(string $domainId, string $qualificationId) 
	{
		$this->response($this->domainUseCase->deleteQualificationFromDomain($domainId, $qualificationId));
	}
}
