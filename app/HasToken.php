<?php


namespace App;


use Auth;
use Composer\Util\StreamContextFactory;
use Illuminate\Support\Str;
use Log;

trait HasToken
{

    protected function bootHasToken()
    {
        static::created(function($model) {
            Log::info('Token for ' . class_basename($model) .  ' created by '  . Auth::user()->getKey());
        });
    }

    protected function initializeHasToken()
    {
        $this->token = Str::random(100);
    }
}
