<?php

namespace Dammen;

abstract class AbstractRegel
{
    abstract public function check(array $args);
}
