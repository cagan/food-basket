<?php

namespace App\Policies;

use App\Pizza;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

class PizzaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any pizzas.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
    }

    /**
     * Determine whether the user can view the pizza.
     *
     * @param User $user
     * @param Pizza $pizza
     * @return mixed
     */
    public function view(User $user, Pizza $pizza)
    {
        //
    }

    /**
     * Determine whether the user can create pizzas.
     *
     * @param  User  $user
     * @param  Pizza  $pizza
     * @return mixed
     */
    public function store(User $user, Pizza $pizza)
    {
        if (!$user->isAdmin()) {
            throw new BadRequestHttpException();
        }

        return true;
    }

    /**
     * Determine whether the user can update the pizza.
     *
     * @param User $user
     * @param Pizza $pizza
     * @return mixed
     */
    public function update(User $user, Pizza $pizza)
    {
        if (!$user->isAdmin()) {
            throw new BadRequestHttpException();
        }

        return true;
    }

    /**
     * Determine whether the user can delete the pizza.
     *
     * @param User $user
     * @param Pizza $pizza
     * @return mixed
     */
    public function delete(User $user, Pizza $pizza)
    {
        if (!$user->isAdmin()) {
            throw new BadRequestHttpException();
        }

        return true;
    }

    /**
     * Determine whether the user can restore the pizza.
     *
     * @param User $user
     * @param Pizza $pizza
     * @return mixed
     */
    public function restore(User $user, Pizza $pizza)
    {
        if (!$user->isAdmin()) {
            throw new BadRequestHttpException();
        }

        return true;
    }

    /**
     * Determine whether the user can permanently delete the pizza.
     *
     * @param User $user
     * @param Pizza $pizza
     * @return mixed
     */
    public function forceDelete(User $user, Pizza $pizza)
    {
        if (!$user->isAdmin()) {
            throw new BadRequestHttpException();
        }

        return true;
    }
}
