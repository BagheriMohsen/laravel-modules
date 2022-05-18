<?php

namespace Modules\Kyc\Repositories;

use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    public function create(array $data): Model|\Illuminate\Database\Eloquent\Builder;

    public function update(string $id, array $data);

    public function updateWithColumn(string $column, string $value, array $data): int;

    public function find(string $column, string $value): Model|null;

    public function firstOrFail(string $column, string $value): Model|\Illuminate\Database\Eloquent\Builder;

    public function delete(string $column, string $value);

    public function get($with=[]): \Illuminate\Database\Eloquent\Collection|array;

    public function getWithPaginate(null|array $queries=null, array $with=[], $sort="created_at",
                                               $direction="desc", $perPage=15): \Illuminate\Contracts\Pagination\LengthAwarePaginator;

    public function firstOrCreate($queries,$data): Model;

    public function search($value, $sort='created_at', $direction='desc', $perPage=15): \Illuminate\Contracts\Pagination\LengthAwarePaginator;
}
