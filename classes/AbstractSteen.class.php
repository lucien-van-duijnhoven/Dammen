<?php

namespace Dammen;

class AbstractSteen
{
    public $kleur;
    public $isDam = null;

    public function __construct($kleur)
    {
        $this->kleur = $kleur;
    }
}
