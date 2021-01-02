<?php

namespace Tests\Feature\Property\Comments\Store;

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
        return route('properties.comments.store', [
            'property' => $parameters[0],
        ]);
    }
}
