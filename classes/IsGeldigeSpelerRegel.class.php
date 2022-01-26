<?php

namespace Dammen;

use Dammen\AbstractRegel;

class IsGeldigeSpelerRegel extends AbstractRegel
{
    Static function isGeldigeSpeler($speler)
    {
        if ($speler === 0 || $speler === 1) {
            return true;
        }
        return false;
    }
}
