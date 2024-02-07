<?php

namespace App\infrastructure\repositories\user;

use Illuminate\Database\Eloquent\Model;

use App\domain\user\User;
use App\infrastructure\repositories\BaseRepository;
use App\domain\user\UserRepository as ConfigUserRepository;

class UserRepository extends BaseRepository implements ConfigUserRepository
{

    public function __construct(private readonly Model $model)
    {
        parent::__construct($model);
    }

    public function findByUsername(string $username): ?User
    {
        return $this->model::Where('userName', $username)->first();
    }

}
