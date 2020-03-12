<?php

namespace App\Repositories;

use App\Http\Requests\RegisterRequest;
use App\User;
use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterface
{
    public function create(array $attributes): User;

    public function findBy($attribute, $value): Model;

    public function update(string $id, array $attributes): bool;
}
