TddBundle (fr)
=========

Ce bundle permet de générer des classes de tests à partir de classe annotée (pour TDD).

L'idée de base est partie d'une constatation. Les développeurs "ne pensent pas" forcement 
à créer leur classes de tests pour entrer dans un mode de développement "TDD" (Développement piloté par les tests).

Le concept est simple, on initialiser une classe de test à partir d'une interface dans laquelle on code 
l'ensemble des tests qui nous permettrons de valider notre développement.

Ce bundle va donc permettre de générer les classes de tests à partir d'une interface (ou d'une classe) annotée. 
C'est simple et rapide.


1) Installation
----------------------------------
A l'ancienne, télécharger le contenu du Bundle dans : `src/Level42/TddBundle`

ou plus moderne, l'ajouter à votre fichier composer.json

    "require": {
        ...
        "Level42/tdd-generator-bundle": "0.1"
        ...
    },

Si vous n'avez pas encore composer, téléchargez le et suivez la procédure d'installation sur
[http://getcomposer.org/](http://getcomposer.org/ "http://getcomposer.org/").

2) Utilisation
-------------------------------
### 2.1) Ajouter les annotations ###

Dans les commentaires de la classe à tester, ajouter l'annotation :
`@TddClass()`

Pour chaque méthode publique que vous souhaitez tester ajouter les annotations suivantes dans le commentaire de la méthode :

    @TddTestCase({
        {"method"="testCase3Success", "description"="Cas de test nominal", "result"="Le résultat est un objet sauvegardé en base de données (avec un ID)"},
	    {"method"="testCase3Failed", "description"="Cas de test en échec", "result"="Le résultat est une erreur de validation des données de l'entity"},
	    {"method"="testCase3Exception", "description"="Cas de test en erreur", "result"="Le résultat est une exception"}
	})

- `method` : Nom de la méthode de test qui sera créée (préfixer par "test")
- `description` : Description de ce test
- `result` : Résultat attendu

### 2.2) Commande de génération ###

	php app/console tdd:generate src/MyCompanyg/MyBundle
    
par défaut, les classes existantes ne sont pas écrasées. Mais vous pouvez forcer la ré-écriture avec l'option --force.
Attention cela écrase toutes vos modifications

    php app/console tdd:generate src/MyCompanyg/MyBundle --force
       
### 2.3) Exemples
Voir https://github.com/Level42/TddBundle/tree/master/Tests/Resources

### 2.4) Roadmap
1. A terme l'idéal serait de combiner ce système aux annotations phpUnit afin que 
les tests de base soient renseignés automatiquement.
2. Ne pas écraser les méthodes existantes lors de la génération.
3. Améliorer mon anglais pour faire des README compréhensible dans cette langue :)

### 2.5) Changelog
#### Version 1.0
Date : 2013-02-16
Première version stable



TddBundle (en)
=========

A bundle to generate test class from annotated classes (for TDD).

1) Installing
----------------------------------
Download bundle in `src/Level42/TddBundle`

or add in your composer.json file

    "require": {
        ...
        "Level42/tdd-generator-bundle": "0.1"
        ...
    },

If you don't have Composer yet, download it following the instructions on
[http://getcomposer.org/](http://getcomposer.org/ "http://getcomposer.org/").

2) Using
-------------------------------
### 2.1) Add annotations ###

In the classes to test, add annotation on the class comment :
`@TddClass()`

For each methods to test in the class, add annotations :

    @TddTestCase({
	    {"method"="testCase3Success", "description"="Nominal test case", "result"="Waiting for an object saved in database (with ID)"},
	    {"method"="testCase3Failed", "description"="Failed test case", "result"="Waiting for an error when entity was validated"},
	    {"method"="testCase3Exception", "description"="Exception test case", "result"="Waiting for an Exception rised by database"}
	})

- `method` : Method name for test class
- `description` : Used to phpDoc of the test
- `result` : Used to phpDoc of the test, expected result of the test.

### 2.2) Launch command ###

	php app/console tdd:generate src/MyCompanyg/MyBundle
     
by default, existing classes are not overwrited. But you can force overwriting with --force option.
Be carefull all modifications will be erased.

    php app/console tdd:generate src/MyCompanyg/MyBundle --force
     
### 2.3) Examples
See https://github.com/Level42/TddBundle/tree/master/Tests/Resources for example

### 2.4) Roadmap
1. Use PhpUnit annotations to generate test methods content automatically.
2. Do not erase existing method when a new generation was lauched
3. Improve my English to make README understandable in this language :)

### 2.4) Changelog
#### Version 1.0
Date : 2013-02-16
First stable version