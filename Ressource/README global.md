composer # SYMFONY

## COMPOSER

- aller sur getcomposer.org, lien "download" sur la page d'accueil
- Windows : télécharger l'exécutable et le lancer
- Mac : ouvrir un terminal et suivre les instructions
- à ne pas réinstaller pour chaque nouveau projet Symfony
- téléchargez l'appli symfony pour acceder au serveur : https://symfony.com/download
- pour lancer le serveur : 
```
symfony serve
```

## NOUVEAU PROJET SYMFONY

- se rendre dans le dossier www via le terminal :

- créer le projet :
```
composer create-project symfony/website-skeleton nom_du_projet
```

## GIT

- créer un dépôt distant sur GitHub
- dans un nouveau terminal, aller dans le dossier Immobilier :
```
cd /Applications/MAMP/htdocs/immobilier
```
- initialiser Git :
```
git init
```
- relier le dépôt distant :
```
git remote add origin https://github.com/davidHurtrel/immobilier.git
```
- ajouter des fichiers :
```
git add *
```
```
git commit -m "..."
```
```
git push origin master (ou/main)
```

## APACHE-PACK

- barre de débug / routing :
```
composer require symfony/apache-pack
```

## CONTRÔLEUR

- créer un contrôleur (et la vue associée) :
```
php bin/console make:controller
```


## BASE DE DONNÉES

- ligne 32 dans .env (y modifier avec les informations de connexion phpMyAdmin) :
```
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7
```
- créer la base :
```
php bin/console doctrine:database:create
```
- créer une entité (table) :
```
php bin/console make:entity
```
- migration :
```
php bin/console make:migration
```
```
php bin/console doctrine:migrations:migrate
```

## CRUD

- créer un CRUD complet sur une entity :
```
php bin/console make:crud
```

## FIXTURES

- installer le bundle :
```
composer require --dev orm-fixtures
```
- remplir le fichier AppFixtures.php avec les données
- persist()
- flush()
- envoyer en bdd en écrasant :
```
php bin/console doctrine:fixtures:load
```
```
php bin/console doctrine:fixtures:load --append
```
- après avoir chargé les données, penser à renommer le fichier AppFixtures.php en ajoutant ~ ou _ devant

## LOGIN

- créer une entité "User" :
```
php bin/console make:user
```
- créer "l'authentification" :
```
php bin/console make:auth
```
- 1
- Authenticator
- SecurityController
- yes

- dans config/packages/security.yaml, décommenter :
```
- { path: ^/admin, roles: ROLE_ADMIN }
```

## REGISTER

- créer le formulaire d'inscription :
```
php bin/console make:registration-form
```
- rediriger vers admin quand connecté (ouvrir Authenticator.php vers ligne 100) :
```
return new RedirectResponse($this->urlGenerator->generate('admin')); ou toute autre Route
```
- installer

-Facultatif : installer RollerWorks :
- ou utiliser tout simplement bcrypt dans le security.yaml
```
composer require rollerworks/password-strength-bundle
```
- dans RegistrationFormType.php :
```
use Rollerworks\Component\PasswordStrength\Validator\Constraints\PasswordStrength;
```
- dans le builder de ce fichier, au niveau du mot de passe :
```
new PasswordStrength
```
- puis y ajouter les vérifications que l'on souhaite (minLength, minStrength, messages...) : voir documentation RollerWorks

## Upload 
- installer composer require vich/uploader-bundle


## FORMULAIRES

- mise en forme Bootstrap, dans config/packages/twig.yaml :
```
form_themes: ['bootstrap_4_layout.html.twig']
```
- créer un nouveau formulaire :
```
php bin/console make:form
```
- ajouter un bouton de validation du formulaire, dans le Form :
```
->add('save', SubmitType::class)
```

## ROUTER DEBUG

- voir toutes les routes :
```
php bin/console debug:router
```
- obtenir des infos sur une route (si existe) :
```
php bin/console router:match /le_nom_de_votre_route
```

## MAIL

- installer SwiftMailer :
```
composer require symfony/swiftmailer-bundle
```
- créer le formulaire de contact :
```
php bin/console make:form contact
```
- remplir le formulaire dans src/Form/ContactType.php
- créer le contrôleur :
```
php bin/console make:controller contact
```
- modifier la vue
- préparer le template de mail

## TRANSLATION

- config/services.yaml :
```
parameters:
    app.langues: 'fr, en'
```
- config/packages/twig.yaml :
```
globals:
    langues: [fr, en]
```
- config/packages/translation.yaml :
```
framework:
    default_locale: fr
    translator:
        default_path: '%kernel.project_dir%/translations'
        fallbacks:
            - fr
```
- terminal :
```
php bin/console translation:update --force en
```
- modifier les fichiers de tranduction
- refaire la commande pour mettre à jour
- cache:clear si nécessaire
- créer le contrôleur pour stocker la langue locale en session :
```
php bin/console make:controller Langue
```

## PAGE ERREUR

- installer Twig Pack :
```
composer require symfony/twig-pack
```
- créer l'arborescence : templates/bundles/TwigBundle/Exception
- y créer les fichiers d'erreur avec l'écriture : error404.html.twig