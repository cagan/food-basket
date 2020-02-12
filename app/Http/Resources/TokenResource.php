<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TokenResource extends JsonResource
{
    protected $tokenResult;
    protected $status;

    public function __construct($tokenResult, $status = 'success')
    {
        parent::__construct($tokenResult);

        $this->tokenResult = $tokenResult;
        $this->status = $status;
    }

    public function toArray($request)
    {
        return [
            'access_token' => $this->tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $this->tokenResult->token->expires_at
            )->toDateTimeString(),
        ];
    }

    public function with($request)
    {
        return [
            'status' => $this->status,
        ];
    }
}
