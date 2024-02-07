<?php

namespace App\domain\domain;

use App\domain\BaseRepository;
use App\domain\domain\Domain;

interface DomainRepository extends BaseRepository {
    
    public function findByName(string $name): Domain | null;

}