<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * App\Order
 *
 * @property int $id
 * @property int $user_id
 * @property float $total_amount
 * @property string $billing_type
 * @property int $is_received
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $order_code
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Pizza[] $pizzas
 * @property-read int|null $pizzas_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereBillingType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereIsReceived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereOrderCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUserId($value)
 * @mixin \Eloquent
 */
class Order extends Model
{
    protected $table = 'orders';

    protected $guarded = [];

    public function pizzas()
    {
        return $this->belongsToMany(Pizza::class);
    }

}
