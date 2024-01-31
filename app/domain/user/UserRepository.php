<?php

namespace App\domain\user;

use App\domain\BaseRepository;
use App\domain\user\User;

interface UserRepository extends BaseRepository
{
    public function findByEmail(string $email): User | null;
}
