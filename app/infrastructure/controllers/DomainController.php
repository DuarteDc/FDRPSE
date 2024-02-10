<?php

namespace App\infrastructure\controllers;

use App\kernel\controllers\Controller;
use App\application\domain\DomainUseCase;
use App\infrastructure\requests\domain\CreateDomainRequest;

class DomainController extends Controller
{

    public function __construct(private readonly DomainUseCase $domainUseCase)
    {
    }

    public function getAllDomains()
    {
        $this->response($this->domainUseCase->findAllDomains());
    }

    public function createDomain()
    {
        $this->validate(CreateDomainRequest::rules(), CreateDomainRequest::messages());
        $this->response($this->domainUseCase->createDomain($this->request()), 201);
    }
}
