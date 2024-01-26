<?php

namespace App\application\domain;

use App\domain\domain\DomainRepository;
use Illuminate\Database\Eloquent\Collection;

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

    public function createDomain(mixed $body)
    {
        $domain =  $this->domainRepository->create($body);
        return ['message' => 'El dominio se creo correctamente', 'domain' => $domain];
    }
}
