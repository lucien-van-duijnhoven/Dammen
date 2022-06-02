<?php

namespace Dammen;

use Dammen\AbstractRegel;

class IsGeldigeSpelerRegel extends AbstractRegel
{
    public function check(array $args)
    {
        if ($args['spelerAanDeBeurt'] === 0 || $args['spelerAanDeBeurt'] === 1) {
            return true;
        }
        return false;
    }
}
