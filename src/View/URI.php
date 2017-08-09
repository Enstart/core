<?php namespace Enstart\View;

use League\Plates\Extension\URI as LeagueURI;

/**
 * Extension that adds a number of URI checks.
 */
class URI extends LeagueURI
{
    /**
     * Update the URI.
     * @param string $uri
     */
    public function updateUri($uri)
    {
        $this->uri   = $uri;
        $this->parts = explode('/', $this->uri);
    }
}
