<?php

namespace App\application\domain;

use Exception;
use App\domain\domain\DomainRepository;

class DomainUseCase
{
    public function __construct(private readonly DomainRepository $domainRepository)
    {
    }

    public function findAllDomains(): mixed
    {
        $domains = $this->domainRepository->findAll();
        return ['domains' => $domains];
    }

    public function createDomain(mixed $body): Exception | array
    {
        $name = mb_strtoupper(trim($body->name));
        $domain = $this->domainRepository->findByName($name);
        if ($domain) return new Exception('Ya existe un dominio con ese nombre', 400);
        $domain = $this->domainRepository->create(['name' => $name]);
        return ['message' => 'El dominio se creo correctamente', 'domain' => $domain];
    }
}
