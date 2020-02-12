<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PizzaResource extends JsonResource
{
    protected $status;
    protected $message;

    public function __construct($resource, $status = 'success', $message = null)
    {
        parent::__construct($resource);

        $this->status = $status;
        $this->message = $message;
    }

    public function toArray($request)
    {
        return parent::toArray($request);
    }

    public function with($request)
    {
        $response = [];

        if ($this->message) {
            $response['message'] = $this->message;
        }

        return array_merge([
            'status' => $this->status,
        ], $response);
    }
}
