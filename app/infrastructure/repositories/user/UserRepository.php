<?php

namespace App\infrastructure\repositories\user;

use App\domain\user\User;
use App\infrastructure\repositories\BaseRepository;
use App\domain\user\UserRepository as ContractsRepository;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends BaseRepository implements ContractsRepository
{

    public function __construct(private readonly User $user)
    {
        parent::__construct($user);
    }

    public function findByUsername(string $username): ?User
    {
        return $this->user::Where('userName', $username)->first();
    }

    public function countTotalAvailableUsers(): int
    {
        return $this->user->where('tipo', 1)->where('activo', true)->count();
    }

    public function getAvailableUsers(): Collection
    {
        return $this->user->where('tipo', 1)->where('activo', true)->get();
    }

}
