# Bilan — TP CI/CD avec GitHub Actions

## 1. Qu'avez-vous automatisé ?

À chaque `push` ou Pull Request, le pipeline CI exécute automatiquement :

- L'installation des dépendances Composer (avec mise en cache)
- La vérification du style de code via **PHP CS Fixer** (PSR-12 + règles maison)
- L'**analyse statique** avec PHPStan niveau 5
- Les **tests unitaires** PHPUnit sur **PHP 8.1, 8.2 et 8.3** en parallèle
- La génération d'un **rapport de couverture HTML** (uniquement sur PHP 8.3) publié comme artefact

Côté CD, à chaque push sur `main` validé par la CI :

- Déploiement automatique sur l'environnement **staging**
- Déploiement sur **production** après validation manuelle par un reviewer

La branche `main` est protégée : aucun merge possible si la CI est rouge.

## 2. Qu'est-ce qui a échoué ?

> *À compléter en cours de TP : décrivez au moins UN incident concret.*
>
> Exemples possibles à transformer en récit personnel :
> - PHPStan a remonté une erreur sur `array_map` à cause du type de retour `array`
> - PHP CS Fixer a échoué à cause d'un `use` inutilisé / d'une indentation incorrecte
> - Le job sur PHP 8.1 est tombé alors que 8.3 passait (différence de syntaxe)
> - La protection de branche a bien bloqué un merge prématuré
> - Le cache Composer renvoyait des dépendances obsolètes après mise à jour de `composer.lock`

## 3. Gain de temps perçu

Vérifications manuelles équivalentes à chaque PR (estimation) :

| Étape | Temps manuel |
|---|---|
| Pull, install, switch branche | ~3 min |
| Lancer linter + corriger | ~5 min |
| Lancer PHPStan + lire les erreurs | ~3 min |
| Lancer les tests sur 3 versions PHP | ~10-15 min |
| Vérifier la couverture | ~2 min |
| Déployer en staging | ~5-10 min |
| **Total** | **≈ 30 minutes par PR** |

Avec la CI, le développeur paie ~0 minute : tout tourne en parallèle pendant qu'il continue à coder. Sur 5 PR/semaine et 4 développeurs, c'est plusieurs heures économisées chaque semaine — sans compter la baisse du stress et des erreurs humaines.

## 4. Limites observées

Notre pipeline ne détecte **pas encore** :

- **Les régressions de performance** — un test peut passer en étant 10× plus lent qu'avant
- **Les vulnérabilités des dépendances** — il faudrait ajouter `composer audit` ou Dependabot
- **Les tests d'intégration / end-to-end** — on ne teste que des unités isolées
- **La cohérence visuelle / accessibilité** — pas de tests UI
- **La sécurité du code** (injections, secrets en dur...) — il faudrait un outil comme `psalm-security` ou `gitleaks`
- **Le déploiement réel** — on simule, donc on ne détecte pas les problèmes de configuration serveur

### Améliorations envisagées

1. Ajouter `composer audit` dans la CI pour bloquer les dépendances vulnérables
2. Activer **Dependabot** pour les mises à jour automatiques
3. Mettre en place un environnement de **review apps** par PR
4. Ajouter un job de **build Docker** et publication d'image
5. Notifier Slack / Discord en cas d'échec ou de déploiement
6. Épingler les actions à un SHA précis (pratique de sécurité recommandée)