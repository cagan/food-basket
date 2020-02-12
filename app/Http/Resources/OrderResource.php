<?php

namespace App\Http\Resources;

use App\Pizza;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'total_amount' => $this->total_amount,
            'billing_type' => $this->billing_type,
            'is_received' => $this->is_received,
            'order_code' => $this->order_code,
            'pizzas' => PizzaResource::collection($this->pizzas),
        ];
    }
}
