<?php

namespace App\Actions\ProcessProperty;

abstract class ProviderAction
{
    protected function processAmenityNames(): array
    {
        return [];
    }

    protected function processBroadbandSpeed(): ?string
    {
        return null;
    }

    protected function processDescription(): ?string
    {
        return null;
    }

    protected function processPrice(): ?int
    {
        return null;
    }

    protected function processTitle(): ?string
    {
        return null;
    }
}
