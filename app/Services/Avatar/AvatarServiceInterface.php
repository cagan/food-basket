<?php


namespace App\Services\Avatar;

use App\User;

interface AvatarServiceInterface
{
    public function store(User $user): void;
}
