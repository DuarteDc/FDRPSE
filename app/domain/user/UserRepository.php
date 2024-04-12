<?php

declare(strict_types=1);

namespace App\domain\user;

use App\domain\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

interface UserRepository extends BaseRepository
{
    public function findByUsername(string $username): User|null;
    public function countTotalAvailableUsers(): int;
    public function getAvailableUsers(): Collection;
}
