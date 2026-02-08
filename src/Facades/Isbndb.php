<?php

declare(strict_types=1);

namespace Verbanent\Isbndb\Laravel\Facades;

use Illuminate\Support\Facades\Facade;
use Verbanent\Isbndb\IsbndbClient;

final class Isbndb extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return IsbndbClient::class;
    }
}
