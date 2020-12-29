<?php

namespace App\Actions\ProcessProperty;

final class Utils
{
    const PROVIDER_ACTIONS = [
        ZooplaAction::class,
    ];

    public static function getProviderNames(): array
    {
        return array_map(static function ($action_classname) {
            return $action_classname::PROVIDER_NAME;
        }, self::PROVIDER_ACTIONS);
    }
}
