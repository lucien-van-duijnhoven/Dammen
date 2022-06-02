<?php

namespace Dammen;

use Dammen\AbstractRegel;
use Dammen\RegelUtils;

class ZetIsBinnenBordRegel implements AbstractRegel
{
    public function check(array $args): bool
    {
        if (!RegelUtils::positieIsBinnenBord($args['zet']->vanPositie) || !RegelUtils::positieIsBinnenBord($args['zet']->naarPositie)) {
            return false;
        }
        return true;
    }
}
