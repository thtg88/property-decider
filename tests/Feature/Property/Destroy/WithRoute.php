<?php

namespace Tests\Feature\Property\Destroy;

trait WithRoute
{
    /**
     * Return the route to use for these tests.
     *
     * @param array $parameters
     * @return string
     */
    public function getRoute(array $parameters = []): string
    {
        return route('properties.destroy', ['property' => $parameters[0]]);
    }
}
