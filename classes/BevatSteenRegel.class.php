<?php

namespace Dammen;

use Dammen\AbstractRegel;
use Dammen\AbstractSteen;
use Dammen\Zet;
use Dammen\Bord;

class BevatSteenRegel implements AbstractRegel
{
    public function check(array $args): bool
    {
        if (($args['bord']->vakjes[$args['zet']->vanPositie->y][$args['zet']->vanPositie->x]->steen instanceof AbstractSteen)) {
            return true;
        }
        return false;
    }
}