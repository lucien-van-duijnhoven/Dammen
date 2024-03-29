<?php

namespace Dammen;

use Dammen\AbstractRegel;

class IsGeldigeSpelerRegel implements AbstractRegel
{
    public function check(array $args): bool
    {
        if ($args['spelerAanDeBeurt'] === 0 || $args['spelerAanDeBeurt'] === 1) {
            return true;
        }
        return false;
    }
}
