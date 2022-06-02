<?php

namespace Dammen;

use Dammen\AbstractRegel;
use Dammen\Zet;
use Dammen\Bord;

class BevatSteenRegel extends AbstractRegel
{
    public function check(array $args)
    {
        if (($args['bord']->vakjes[$args['zet']->vanPositie->y][$args['zet']->vanPositie->x]->steen instanceof Steen)) {
            return true;
        }
        return false;
    }
}