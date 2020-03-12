<?php


namespace App\Repositories;


use App\User;
use Illuminate\Database\Eloquent\Model;

class UserRepository implements UserRepositoryInterface
{
    public function create(array $attributes): User
    {
        return User::create($attributes);
    }

    public function findBy($attribute, $value): Model
    {
        return User::where($attribute, $value)->first();
    }

    public function update(string $id, array $attributes): bool
    {
        return User::where('id', $id)->update($attributes);
    }
}
