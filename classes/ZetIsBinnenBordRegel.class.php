<?php

namespace Dammen;

use Dammen\AbstractRegel;

class ZetIsBinnenBordRegel extends AbstractRegel
{
    static function zetIsBinnenBord($zet)
    {
        if (!self::positieIsBinnenBord($zet->vanPositie) || !self::positieIsBinnenBord($zet->naarPositie)) {
            return false;
        }
        return true;
    }
}
