<?php

namespace Dammen;

class AbstractSteen
{
    public $kleur;

    public function __construct($kleur)
    {
        $this->kleur = $kleur;
    }
}
