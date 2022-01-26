<?php

namespace Dammen;

use Dammen\AbstractRegel;

class BevatSteenRegel extends AbstractRegel
{
    static function bevatSteen($positie, $bord)
    {
        if (($bord->vakjes[$positie->y][$positie->x]->steen instanceof Steen)) {
            return true;
        }
        return false;
    }
}