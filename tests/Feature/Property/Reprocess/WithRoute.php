<?php

namespace Tests\Feature\Property\Reprocess;

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
        return route('properties.reprocess', ['property' => $parameters[0]]);
    }
}
