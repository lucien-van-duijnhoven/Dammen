<?php

namespace Dammen;

interface AbstractRegel
{
    public function check(array $args): bool;
}
