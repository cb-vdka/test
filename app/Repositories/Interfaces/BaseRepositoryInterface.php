<?php

namespace App\Repositories\Interfaces;

/**
 * Interface BaseRepositoryInterface
 * @package App\Reponsitories\Interfaces
 */
interface BaseRepositoryInterface
{
    public function getData();
    public function all();
    public function findById(int $modelId, array $column = ['*'], array $relation = []);
    public function create(array $payload = []);
    public function delete(int $id = 0);
    public function forceDelete(int $id = 0);
    public function update(array $payload = [], int $id = 0);
    public function updateByWhereIn(string $whereInField, array $whereIn = [], array $payload);
    public function createPivot($model, array $payload = [], string $relation = '');
}
