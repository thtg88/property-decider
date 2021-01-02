<?php

namespace App\Actions\ProcessProperty;

final class Utils
{
    public const PROVIDER_ACTIONS = [
        OnTheMarketAction::class,
        RightmoveAction::class,
        ZooplaAction::class,
    ];

    public static function getProviderNames(): array
    {
        return array_map(static function ($action_classname) {
            return $action_classname::PROVIDER_NAME;
        }, self::PROVIDER_ACTIONS);
    }
}
