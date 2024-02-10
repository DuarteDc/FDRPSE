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
        $isValidName = $this->validateDomainName($body->name);
        if ($isValidName instanceof Exception) return $isValidName;

        $domain = $this->domainRepository->saveDomainAndSetQualification((object)[...(array)$body, 'name' => $isValidName]);
        return ['message' => 'El dominio se creo correctamente', 'domain' => $domain];
    }

    private function validateDomainName(string $name): Exception | string
    {
        $name = mb_strtoupper(trim($name));
        $domain = $this->domainRepository->findByName($name);
        return $domain ? new Exception('Ya existe un dominio con ese nombre', 400) : $name;
    }
}
