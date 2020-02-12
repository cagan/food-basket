<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    protected $table = 'orders';

    protected $guarded = [];

    public function pizzas()
    {
        return $this->belongsToMany(Pizza::class);
    }

}
