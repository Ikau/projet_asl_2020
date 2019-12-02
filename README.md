# **projet_asl_2020**

Bienvenue sur le dépôt GitHub du projet de l'**INSA Centre-Val de Loire** "**Notation des stages**" utilisant le framework `Laravel 6.x` !

Vous pourrez trouver ici de nombreuse informations liées à l'installation, la configuration et la maintenance du projet.

Des informations peuvent ne pas être présentes sur ce `README` : il faudra dans ce cas se référer dans le document technique.

Bien que le contenu de ce `README` essaiera d'être le plus complet possible, il faut garder en tête que la [documentation Laravel](https://laravel.com/docs/6.x) reste la source la plus complète et à jour.
# **Installation**
Afin d'utiliser le projet, il faudra d'abord installer plusieurs choses :
* Laravel
* PHP
* MySQL

# **Configs**

Le projet possède de nombreuses configurations utilisées pour la phase de production ou pour la phase de développement.

Cette partie va essayer de faire une liste exhaustive de tous les changements effectués au cours du développement.

### **Fichiers de configuration et environnement local** [[doc]](https://laravel.com/docs/6.x/configuration)
---

#### Configuration de l'environnement local
Laravel met à disposition un fichier de configuration [DotEnv](https://github.com/vlucas/phpdotenv) est localisé à la racine du projet :

    /.env

Ce fichier **n'est pas push** vers le dossier distant. Il faut donc créer et configurer votre propre fichier. Heureusement, un fichier d'exemple existe pour faciliter la création :

    /.env.example

Il faut donc copier le fichier et l'éditer pour y inscrire les différentes valeurs liées à votre environnement :

    cp .env.example .env
    nano .env

Vous pouvez aussi configurer un second fichier d'environnement spécialement affecté à votre environnement de test (ex : PHPUnit) :

    cp .env.example .env.testing
    nano .env

##### **Fichiers de configuration Laravel**
Laravel met à disposition de nombreux fichiers de configuration pour faciliter le paramétrage du serveur.\
Tous les fichiers se trouve dans le dossier `config` et portent le nom de la configuration associée :

    /config/*.php

Ce fichier sert à initialiser dynamiquement vos variables d'environnement. **N'inscrivez donc rien en dur dans ce fichier !**\
Toutes les valeurs sont récupérées selon la notation :

    env('NOM_VARIABLE_ENV', 'VALEUR_PAR_DEFAUT')

La variable `NOM_VARIABLE_ENV` doit être définie dans votre fichier `.env`.


### **Base de données**
---

#### Utilisateur et bases de données
Avant toute chose, il faut savoir que le projet actuel possède un environnement de développement spécifique pour la base de données :\
* `mysql version 8+` 
* `aslprojet` : Une base de données de **production** 
* `asltest`: Une base de données de **test** 
* `asladmin` : Un utilisateur ayant tous les droits sur _aslprojet_ et _asltest_
* `doctrine/dbal` : Une dépendance composer pour la modification des tables après une migration


**Pour des configurations définitives, un fichier de configuration existe**. Les valeurs du fichier de configuration écraseront celles du fichier précédent. Le fichier PHP concerné est le suivant :

    /config/database.php

#### Bug de connexion protocole 'cache_sha2' non supporté

Si vous rencontrez ce bug, sachez que c'est parce que Laravel ne prend pas en compte le nouvel algorithme de hachage de MySQL 8+\
Pour pallier ce problème, il faut forcer MySQL à utiliser l'ancien protocole **sur l'utilisateur souhaité**.

Pour cela, se connecter en root (ou compte avec les droits compétents) pour éditer le mot de passe de l'utilisateur :

```sql
ALTER USER 'user'@'hostname' IDENTIFIED WITH mysql_native_password BY 'password';
```

