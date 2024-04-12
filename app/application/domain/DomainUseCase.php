<?php

declare(strict_types=1);

namespace App\application\domain;

use App\domain\domain\DomainRepository;
use Exception;

final class DomainUseCase
{
    public function __construct(private readonly DomainRepository $domainRepository) {}

    public function findAllDomains(): mixed
    {
        $domains = $this->domainRepository->findAll();
        return ['domains' => $domains];
    }

    public function createDomain(mixed $body): array|Exception
    {
        $isValidName = $this->validateDomainName($body->name);
        if ($isValidName instanceof Exception) {
            return $isValidName;
        }

        $domain = $this->domainRepository->saveDomainAndSetQualification(
            (object) [...(array) $body, 'name' => $isValidName]
        );
        return ['message' => 'El dominio se creo correctamente', 'domain' => $domain];
    }

    public function findDomaisWithQualifications()
    {
        $domains = $this->domainRepository->findWithQualifications();
        return ['domains' => $domains];
    }

    public function findDomainWithQualifications(string $categoryId)
    {
        $category = $this->domainRepository->findOne($categoryId);
        if (!$category) {
            return new Exception('El dominio no existe o no es valida', 404);
        }
        $category = $this->domainRepository->findOneWithQualifications($categoryId);
        return ['domain' => $category];
    }


    public function addQualification(string $categoryId, mixed $body)
    {
        $domain = $this->domainRepository->findOne($categoryId);
        if (!$domain) {
            return new Exception('El dominio no existe o no es valido', 404);
        }
        $domain = $this->domainRepository->addNewQualification($domain, $body);
        return ['domain' => $domain, 'message' => 'La calificación se agrego correctamente'];
    }


    private function validateDomainName(string $name): Exception|string
    {
        $name = mb_strtoupper(trim($name));
        $domain = $this->domainRepository->findByName($name);
        return $domain ? new Exception('Ya existe un dominio con ese nombre', 400) : $name;
    }
}
