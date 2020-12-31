<?php

namespace Tests\Feature\Property\Like;

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
        return route('properties.like', ['property' => $parameters[0]]);
    }
}
