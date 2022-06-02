<?php

namespace Dammen;

use Dammen\AbstractSteen;

class Steen implements AbstractSteen
{
    public $isDam = false;

    public $kleur;

    public function __construct($kleur)
    {
        $this->kleur = $kleur;
    }
}