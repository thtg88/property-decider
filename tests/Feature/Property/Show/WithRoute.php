<?php

namespace Tests\Feature\Property\Show;

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
        return route('properties.show', ['property' => $parameters[0]]);
    }
}
