<?php

namespace App\Http\Resources;

use App\Order;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->transform(
            function (Order $order) {
                return (new OrderResource($order));
            }
        );

        return parent::toArray($request);
    }

    public function with($request)
    {
        return [
            'status' => 'success',
        ];
    }
}
