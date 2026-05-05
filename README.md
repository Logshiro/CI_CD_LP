# Facturation PHP

Application de facturation PHP — projet support du **TP CI/CD avec GitHub Actions**.

## Installation

```bash
composer install
```

## Lancer les tests

```bash
php vendor/bin/phpunit --testdox
```
## mise à jour phpUnit

```bash
composer require --dev phpunit/phpunit
composer dump-autoload
./vendor/bin/phpunit --version
```

## Clef SSH

Création de la clef 

```bash
ssh-keygen -t ed25519 -C "mitouquentin@gmail.com"
ls -la ~/.ssh/
cat ~/.ssh/id_ed25519.pub | clip.exe
```

Changement en ssh url (si besion)

```bash
git remote set-url origin git@github.com:Logshiro/CI_CD_LP.git
```

Colage de la clef sur github et verif

```bash
ssh -T git@github.com
```
# Facturation PHP

![CI](https://github.com/VOTRE_PSEUDO/facturation-php/actions/workflows/ci.yml/badge.svg)
![Deploy](https://github.com/VOTRE_PSEUDO/facturation-php/actions/workflows/deploy.yml/badge.svg)

Application de facturation PHP — projet support du **TP CI/CD avec GitHub Actions**.

> ⚠️ Remplacez `VOTRE_PSEUDO` et `facturation-php` dans les badges ci-dessus par votre pseudo GitHub et le nom réel du dépôt.

## Pile technique

- PHP 8.1 / 8.2 / 8.3 (testé en matrix)
- PHPUnit 11 — tests unitaires
- PHP CS Fixer — style de code (PSR-12)
- PHPStan niveau 5 — analyse statique
- GitHub Actions — CI/CD

## Installation locale

```bash
composer install
```

## Commandes

| Commande | Description |
|---|---|
| `composer test` | Lancer les tests PHPUnit |
| `composer lint` | Vérifier le style de code |
| `composer lint:fix` | Corriger automatiquement le style |
| `composer stan` | Lancer PHPStan |
| `composer qa` | Tout faire (lint + stan + test) |

## Structure

```
facturation-php/
├── .github/workflows/   # Pipelines CI/CD
├── src/                 # Code source
├── tests/               # Tests unitaires
├── composer.json
├── phpunit.xml
├── phpstan.neon
└── .php-cs-fixer.php
```
echo ""