<?php

namespace App\domain\user;

use App\domain\BaseRepository;
use App\domain\user\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepository extends BaseRepository
{
    public function findByUsername(string $username): User | null;
    public function countTotalAvailableUsers(): int;
}
