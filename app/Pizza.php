<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Pizza
 *
 * @property int $id
 * @property string $name
 * @property float $price
 * @property string $materials
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Order[] $orders
 * @property-read int|null $orders_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pizza newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pizza newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pizza query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pizza whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pizza whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pizza whereMaterials($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pizza whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pizza wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pizza whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Pizza extends Model
{
    protected $guarded = [];

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}
