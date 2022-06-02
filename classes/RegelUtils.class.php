<?php

namespace Dammen;

class RegelUtils {
    static function positieIsBinnenBord($positie)
    {
        if ($positie->x > 9 || $positie->x < 0) {
            return false;
        }
        if ($positie->y > 9 || $positie->y < 0) {
            return false;
        }
        return true;
    }
}