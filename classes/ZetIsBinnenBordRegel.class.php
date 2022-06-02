<?php

namespace Dammen;

use Dammen\AbstractRegel;
use Dammen\RegelUtils;

class ZetIsBinnenBordRegel extends AbstractRegel
{
    public function check(array $args)
    {
        if (!RegelUtils::positieIsBinnenBord($args['zet']->vanPositie) || !RegelUtils::positieIsBinnenBord($args['zet']->naarPositie)) {
            return false;
        }
        return true;
    }
}
