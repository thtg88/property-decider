<?php

namespace App\Helpers;

class PropertyHelper
{
    /**
     * Return the given URL without the query string.
     *
     * @param string $url
     * @return string
     */
    public function stripQuery(string $url): string
    {
        return strtok($url, '?');
    }
}
