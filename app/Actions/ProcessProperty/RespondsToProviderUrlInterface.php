<?php

namespace App\Actions\ProcessProperty;

interface RespondsToProviderUrlInterface
{
    public static function respondsTo(string $url): bool;
}
