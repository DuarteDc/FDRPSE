<?php

namespace App\domain\user;

use App\domain\BaseRepository;
use App\domain\user\User;

interface UserRepository extends BaseRepository
{
    public function findByUsername(string $username): User | null;
}
