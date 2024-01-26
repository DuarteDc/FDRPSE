<?php

namespace App\infrastructure\repositories;

use App\domain\BaseRepository as DomainBaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements DomainBaseRepository
{
    private readonly Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function findAll(): Collection
    {
        return $this->model::all();
    }

    public function findOne(string $id): Model | null
    {
        return $this->model::find($id);
    }

    public function create(array $body): Model
    {
        $record = new $this->model((array) $body);
        $record->save();
        return $record;
    }
}
