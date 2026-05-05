<?php

declare(strict_types=1);

namespace App;

class Facture
{
    private array $lignes = [];
    private float $tauxTVA;

    public function __construct(float $tauxTVA = 0.20)
    {
        if ($tauxTVA < 0 || $tauxTVA > 1) {
            throw new \InvalidArgumentException('Le taux de TVA doit être compris entre 0 et 1.');
        }
        $this->tauxTVA = $tauxTVA;
    }

    public function ajouterLigne(string $libelle, float $prixUnitaire, int $quantite): self
    {
        if ($prixUnitaire < 0) {
            throw new \InvalidArgumentException('Le prix unitaire ne peut pas être négatif.');
        }
        if ($quantite <= 0) {
            throw new \InvalidArgumentException('La quantité doit être supérieure à zéro.');
        }
        $this->lignes[] = [
            'libelle'      => $libelle,
            'prixUnitaire' => $prixUnitaire,
            'quantite'     => $quantite,
        ];
        return $this;
    }

    public function totalHT(): float
    {
        return array_sum(array_map(
            fn ($l) => $l['prixUnitaire'] * $l['quantite'],
            $this->lignes
        ));
    }

    public function totalTTC(): float
    {
        return round($this->totalHT() * (1 + $this->tauxTVA), 2);
    }

    public function nombreLignes(): int
    {
        return count($this->lignes);
    }
}