<?php

namespace App\infrastructure\repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

use App\domain\BaseRepository as ContractsRepository;

abstract class BaseRepository implements ContractsRepository
{
    public function __construct(private readonly Model $model)
    {
    }

    public function findAll(): Collection
    {
        return $this->model::all();
    }

    public function findOne(string $id): Model | null
    {
        if(!is_numeric($id)) return null;
        return $this->model::find($id);
    }

    public function create(mixed $body): Model
    {
        $record = new $this->model((array) $body);
        $record->save();
        return $record;
    }

}
