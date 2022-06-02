<?php

namespace Dammen;

use Dammen\IsGeldigeSpelerRegel;
use Dammen\BevatSteenRegel;
use Dammen\ZetIsBinnenBordRegel;

class RegelControleur
{
    private array $rules;

    public function __construct()
    {
        $this->rules[] = new isGeldigeSpelerRegel();
        $this->rules[] = new bevatSteenRegel();
        $this->rules[] = new zetIsBinnenBordRegel();
    }

    public function isGeldigeZet($zet, $bord, $spelerAanDeBeurt)
    {
        foreach ($this->rules as $rule) {
            if (!$rule->check(['zet' => $zet, 'bord' => $bord, 'spelerAanDeBeurt' => $spelerAanDeBeurt])) {
                return false;
            }
        }
        $positiesBeschikbareStenen = $this->vakkenVanBeschikbareStenen($bord, $spelerAanDeBeurt);
        $mogelijkeSlagen = $this->mogelijkeSlagen($positiesBeschikbareStenen, $bord, $spelerAanDeBeurt, $zet);
        if (count($mogelijkeSlagen) > 0) {
            if (in_array($zet, $mogelijkeSlagen)) {
                return true;
            } else {
                return false;
            }
        } else {
            $mogelijkeZetten = $this->mogelijkeZetten($positiesBeschikbareStenen, $bord, $spelerAanDeBeurt, $zet);
            if (in_array($zet, $mogelijkeZetten)) {
                return true;
            } else {
                return false;
            }
        }
    }

    private function positieIsBinnenBord($positie)
    {
        if ($positie->x > 9 || $positie->x < 0) {
            return false;
        }
        if ($positie->y > 9 || $positie->y < 0) {
            return false;
        }
        return true;
    }

    private function bevatSteen($positie, $bord)
    {
        if (($bord->vakjes[$positie->y][$positie->x]->steen instanceof Steen)) {
            return true;
        }
        return false;
    }

    private function bevatSteenVanTegenstander($positie, $bord, $spelerAanDeBeurt)
    {
        if ($this->bevatSteen($positie, $bord)) {
            if ($bord->vakjes[$positie->y][$positie->x]->steen->kleur === $this->kleurVanSpeler(1 - $spelerAanDeBeurt)) {
                return true;
            }
        }
        return false;
    }

    private function kleurVanSpeler($speler)
    {
        if ($speler === 0) {
            return "wit";
        }
        return "zwart";
    }

    private function vakkenVanBeschikbareStenen($bord, $spelerAanDeBeurt)
    {
        $spelerKleur = $this->kleurVanSpeler($spelerAanDeBeurt);
        $beschikbareVakken = [];
        foreach ($bord->vakjes as $rijNummer => $rij) {
            foreach ($rij as $kolomNummer => $vak) {
                if (isset($vak->steen)) {
                    if ($vak->steen->kleur === $spelerKleur) {
                        $beschikbareVakken[] = new Positie($kolomNummer, $rijNummer);
                    }
                }
            }
        }
        return $beschikbareVakken;
    }

    
    private function mogelijkeZetten($beschikbareVakken, $bord, $speler, $zet)
    {
        $mogelijkeZetten = [];
        if ($speler === 0) {
            $beweegRichting = -1;
        } else {
            $beweegRichting = 1;
        }
        if ($bord->vakjes[$zet->vanPositie->y][$zet->vanPositie->x]->steen->isDam === true) {
            foreach ($beschikbareVakken as $steenPositie) {
                $naar = new Positie(($steenPositie->x + 1), ($steenPositie->y + $beweegRichting));
                if ($this->positieIsBinnenBord($naar) && !$this->bevatSteen($naar, $bord)) {
                    $mogelijkeZetten[] = new Zet($steenPositie, $naar);
                }
                $naar = new Positie(($steenPositie->x - 1), ($steenPositie->y + $beweegRichting));
                if ($this->positieIsBinnenBord($naar) && !$this->bevatSteen($naar, $bord)) {
                    $mogelijkeZetten[] = new Zet($steenPositie, $naar);
                }
                $naar = new Positie(($steenPositie->x + 1), ($steenPositie->y - $beweegRichting));
                if ($this->positieIsBinnenBord($naar) && !$this->bevatSteen($naar, $bord)) {
                    $mogelijkeZetten[] = new Zet($steenPositie, $naar);
                }
                $naar = new Positie(($steenPositie->x - 1), ($steenPositie->y - $beweegRichting));
                if ($this->positieIsBinnenBord($naar) && !$this->bevatSteen($naar, $bord)) {
                    $mogelijkeZetten[] = new Zet($steenPositie, $naar);
                }
            }
        } else {
            foreach ($beschikbareVakken as $steenPositie) {
                $naar = new Positie(($steenPositie->x + 1), ($steenPositie->y + $beweegRichting));
                if ($this->positieIsBinnenBord($naar) && !$this->bevatSteen($naar, $bord)) {
                    $mogelijkeZetten[] = new Zet($steenPositie, $naar);
                }
                $naar = new Positie(($steenPositie->x - 1), ($steenPositie->y + $beweegRichting));
                if ($this->positieIsBinnenBord($naar) && !$this->bevatSteen($naar, $bord)) {
                    $mogelijkeZetten[] = new Zet($steenPositie, $naar);
                }
            }
        }
        return $mogelijkeZetten;
    }

    private function mogelijkeSlagen($beschikbareVakken, $bord, $speler, $zet)
    {
        $mogelijkeSlagen = [];
        if ($speler === 0) {
            $beweegRichting = -1;
        } else {
            $beweegRichting = 1;
        }
        if ($bord->vakjes[$zet->vanPositie->y][$zet->vanPositie->x]->steen->isDam === true) {
            foreach ($beschikbareVakken as $steenPositie) {
                $naar = new Positie(($steenPositie->x + 2), ($steenPositie->y + ($beweegRichting * 2)));
                $over = new Positie(($steenPositie->x + 1), ($steenPositie->y + $beweegRichting));
                if (
                    $this->positieIsBinnenBord($naar) 
                    && !$this->bevatSteen($naar, $bord)
                    && $this->bevatSteenVanTegenstander($over, $bord, $speler)
                ) {
                    $mogelijkeSlagen[] = new Zet($steenPositie, $naar);
                }
                $naar = new Positie(($steenPositie->x - 2), ($steenPositie->y + ($beweegRichting * 2)));
                $over = new Positie(($steenPositie->x - 1), ($steenPositie->y + $beweegRichting));
                if (
                    $this->positieIsBinnenBord($naar)
                    && !$this->bevatSteen($naar, $bord)
                    && $this->bevatSteenVanTegenstander($over, $bord, $speler)    
                ) {
                    $mogelijkeSlagen[] = new Zet($steenPositie, $naar);
                }
                $naar = new Positie(($steenPositie->x + 2), ($steenPositie->y - ($beweegRichting * 2)));
                $over = new Positie(($steenPositie->x + 1), ($steenPositie->y - $beweegRichting));
                if (
                    $this->positieIsBinnenBord($naar) 
                    && !$this->bevatSteen($naar, $bord)
                    && $this->bevatSteenVanTegenstander($over, $bord, $speler)
                ) {
                    $mogelijkeSlagen[] = new Zet($steenPositie, $naar);
                }
                $naar = new Positie(($steenPositie->x - 2), ($steenPositie->y - ($beweegRichting * 2)));
                $over = new Positie(($steenPositie->x - 1), ($steenPositie->y - $beweegRichting));
                if (
                    $this->positieIsBinnenBord($naar)
                    && !$this->bevatSteen($naar, $bord)
                    && $this->bevatSteenVanTegenstander($over, $bord, $speler)    
                ) {
                    $mogelijkeSlagen[] = new Zet($steenPositie, $naar);
                }
            }
        } else {
            foreach ($beschikbareVakken as $steenPositie) {
                $naar = new Positie(($steenPositie->x + 2), ($steenPositie->y + ($beweegRichting * 2)));
                $over = new Positie(($steenPositie->x + 1), ($steenPositie->y + $beweegRichting));
                if (
                    $this->positieIsBinnenBord($naar) 
                    && !$this->bevatSteen($naar, $bord)
                    && $this->bevatSteenVanTegenstander($over, $bord, $speler)
                ) {
                    $mogelijkeSlagen[] = new Zet($steenPositie, $naar);
                }
                $naar = new Positie(($steenPositie->x - 2), ($steenPositie->y + ($beweegRichting * 2)));
                $over = new Positie(($steenPositie->x - 1), ($steenPositie->y + $beweegRichting));
                if (
                    $this->positieIsBinnenBord($naar)
                    && !$this->bevatSteen($naar, $bord)
                    && $this->bevatSteenVanTegenstander($over, $bord, $speler)    
                ) {
                    $mogelijkeSlagen[] = new Zet($steenPositie, $naar);
                }
            }
        }
        return $mogelijkeSlagen;
    }
}