<?php

namespace Tests\Feature\PropertyPreference\Destroy;

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
        return route('property-preferences.destroy', [
            'property_preference' => $parameters[0],
        ]);
    }
}
