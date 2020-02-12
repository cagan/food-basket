<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Passport\Client;
use Laravel\Passport\HasApiTokens;
use Laravel\Passport\Token;
use Storage;

/**
 * App\User.
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Collection|Client[] $clients
 * @property int|null $clients_count
 * @property DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property int|null $notifications_count
 * @property Collection|Token[] $tokens
 * @property int|null $tokens_count
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin Eloquent
 * @property string $avatar
 * @property int $active
 * @property string $activation_token
 * @property Carbon|null $deleted_at
 * @property mixed $avatar_url
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|User whereActivationToken($value)
 * @method static Builder|User whereActive($value)
 * @method static Builder|User whereAvatar($value)
 * @method static Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 * @property int $admin
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAdmin($value)
 */
class User extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;
    use SoftDeletes;

    protected $appends = ['avatar_url'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable
        = [
            'name',
            'email',
            'password',
            'active',
            'activation_token',
            'avatar',
        ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'activation_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts
        = [
            'email_verified_at' => 'datetime',
        ];

    public function getAvatarUrlAttribute()
    {
        return Storage::url('avatars/' . $this->id . '/' . $this->avatar);
    }

    public function setUserAsAdmin()
    {
        if (!$this->isAdmin()) {
            return false;
        }

        return $this->update(
            [
                'is_admin' => true,
            ]
        );
    }

    public function isAdmin()
    {
        return 1 === $this->admin;
    }
}
