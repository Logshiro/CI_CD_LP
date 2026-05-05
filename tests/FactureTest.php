<?php

declare(strict_types=1);

namespace Tests;

use App\Facture;
use PHPUnit\Framework\TestCase;

class FactureTest extends TestCase
{
    public function testFactureVideATotalNul(): void
    {
        $facture = new Facture();
        $this->assertSame(0.0, $facture->totalHT());
    }

    public function testTotalHTAvecUneLigne(): void
    {
        $facture = new Facture();
        $facture->ajouterLigne('Prestation', 100.0, 3);
        $this->assertSame(300.0, $facture->totalHT());
    }

    public function testTotalTTCAvecTVAParDefaut(): void
    {
        $facture = new Facture();
        $facture->ajouterLigne('Prestation', 100.0, 1);
        $this->assertSame(120.0, $facture->totalTTC());
    }

    public function testExceptionSiTauxInvalide(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Facture(1.5);
    }

    public function testExceptionSiPrixNegatif(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new Facture())->ajouterLigne('Test', -10.0, 1);
    }

    // TODO : Séquence 3 — Étape 4
    // Ajoutez ici les tests manquants :
    //   - facture avec plusieurs lignes (totalHT et totalTTC)
    //   - exception si quantité nulle ou négative
    //   - nombreLignes() retourne le bon compte
    //   - ajouterLigne() retourne bien self (chaînage)
}