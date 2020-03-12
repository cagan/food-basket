<?php


namespace App\Services\Avatar;

use App\User;
use Storage;
use Laravolt\Avatar\Avatar;

class AvatarService implements AvatarServiceInterface
{
    public function store(User $user): void
    {
        $avatar = (new Avatar())->create($user->name)->getImageObject()->encode('png');
        Storage::put('avatars/' . $user->id . '/avatar.png', (string)$avatar);
    }
}
