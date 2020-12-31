<?php

namespace Tests\Feature\Property\Dislike;

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
        return route('properties.dislike', ['property' => $parameters[0]]);
    }
}
