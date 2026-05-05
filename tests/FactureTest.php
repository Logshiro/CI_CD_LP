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

    // ------------------------------------------------------------------
    //  Séquence 3 — Étape 4 : tests ajoutés
    // ------------------------------------------------------------------

    public function testFactureAvecPlusieursLignes(): void
    {
        $facture = new Facture();
        $facture->ajouterLigne('Article A', 50.0, 2);   // 100
        $facture->ajouterLigne('Article B', 30.0, 4);   // 120
        $facture->ajouterLigne('Article C', 10.0, 1);   //  10

        $this->assertSame(230.0, $facture->totalHT());
        $this->assertSame(276.0, $facture->totalTTC()); // 230 * 1.20
    }

    public function testFactureAvecPlusieursLignesEtTauxPersonnalise(): void
    {
        $facture = new Facture(0.055); // taux réduit
        $facture->ajouterLigne('Livre', 20.0, 2);
        $facture->ajouterLigne('Livre', 15.0, 1);

        $this->assertSame(55.0, $facture->totalHT());
        $this->assertSame(58.03, $facture->totalTTC()); // 55 * 1.055 = 58.025 -> 58.03
    }

    public function testExceptionSiQuantiteNulle(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('La quantité doit être supérieure à zéro.');
        (new Facture())->ajouterLigne('Test', 10.0, 0);
    }

    public function testExceptionSiQuantiteNegative(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new Facture())->ajouterLigne('Test', 10.0, -3);
    }

    public function testNombreLignesRetourneLeBonCompte(): void
    {
        $facture = new Facture();
        $this->assertSame(0, $facture->nombreLignes());

        $facture->ajouterLigne('A', 1.0, 1);
        $this->assertSame(1, $facture->nombreLignes());

        $facture->ajouterLigne('B', 2.0, 1);
        $facture->ajouterLigne('C', 3.0, 1);
        $this->assertSame(3, $facture->nombreLignes());
    }

    public function testAjouterLigneRetourneSelfPourChainage(): void
    {
        $facture = new Facture();

        $resultat = $facture
            ->ajouterLigne('A', 10.0, 1)
            ->ajouterLigne('B', 20.0, 2)
            ->ajouterLigne('C', 30.0, 3);

        $this->assertInstanceOf(Facture::class, $resultat);
        $this->assertSame($facture, $resultat);
        $this->assertSame(3, $facture->nombreLignes());
    }

    public function testExceptionSiTauxNegatif(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Facture(-0.1);
    }
}