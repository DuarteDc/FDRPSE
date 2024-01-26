<?php

namespace App\domain;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseRepository
{
    public function findAll(): Collection;
    public function findOne(string $id): Model | null;
    public function create(array $body): Model;
    // public function deleteOne(string $id): void;
}
