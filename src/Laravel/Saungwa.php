<?php

namespace Kelaskakap\SaungwaPhp\Laravel;

use Illuminate\Support\Facades\Facade;
use Kelaskakap\SaungwaPhp\SaungwaClient;

class Saungwa extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return SaungwaClient::class;
    }
}
