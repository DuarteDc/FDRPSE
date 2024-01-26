<?php 

namespace App\domain;

interface BaseRepository {
    public function findAll(): array;
    public function findOne(string $id): array;
    public function create(mixed $body): array;
    // public function deleteOne(string $id): void;
}