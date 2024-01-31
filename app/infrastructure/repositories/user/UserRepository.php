<?php

namespace App\infrastructure\repositories\user;

use App\domain\user\User;
use App\domain\user\UserRepository as ConfigUserRepository;
use App\infrastructure\repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository implements ConfigUserRepository
{

    public function __construct(private readonly Model $model)
    {
        parent::__construct($model);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->model::Where('email', $email)->first();
    }
}
