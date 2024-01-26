<?php

namespace App\infrastructure\repositories;

use App\domain\BaseRepository as DomainBaseRepository;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements DomainBaseRepository
{

    private readonly Model $model;

    private function __construct(Model $model)
    {
        $this->model = $model;
    }
    
    public function findAll(): array
    {
        return $this->model->find();
    }

    public function findOne(string $id): array
    {
        return $this->model->find($id);
    }

    public function create(mixed $body): array
    {
        $record = new $this->model($body);
        return $record->save();
    }

}
