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
echo ""