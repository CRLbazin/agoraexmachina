# Proposition : Liste des améliorations pour une plateforme AgoraExMachina entièrement opérationnelle

Nous avons planifié un ensemble de développements à effectuer, visant à améliorer l'installation et le fonctionnement d'**AEM**. Prière d'ajouter devant les lignes concernées [SOUMIS]. Les référents passeront si tout va bien la ligne à [FAIT].

##V1.0
* Normalisation complète de l'installation permettant que cela puisse se faire dans les meilleures conditions possibles.
    * Rendre possible l'installation sans composer (certaines plateformes d'hébergement fonctionnant peu ou mal avec **SSH**)
    * permettre l'installation de la base de données en `utf8_unicode_ci` (des serveurs de base de données ne supportant pas `utf8mb4`. Rq : ceci peut également être réglé dans les prérequis en identifiant précisément les versions php et mySQL.
    * Rendre le premier compte adminstrateur effectif (avec `["ROLE_ADMIN"]`)
    * [SOUMIS] Faire en sorte que l'interface par défaut soit en français.
    * Corrections de petits bugs divers, dont :
      * Sur la page Users, l'administrateur ne peut en créer de nouveaux.
* Interface
    * [FAIT] rendre possible lors de l'installation la traduction en français de l'interface. En fait, intégration de "comment on fait" dans le fichier `INSTALL.md`.
    * [SOUMIS] Dans la page `workshop/index.html.twig`, l'image pour chacun des workshops est celle de l'atelier, de la catégorie qui lui correspond, et du logo AEM sinon.
* Langues
    * Effectuer la traduction complète du fichier *translations/messages.fr.xlf* en Allemand (optionnel) et en Anglais.

##V1.1
### Normalisation de l'installation

Mise en place d'une interface d'installation en GUI 

* Messages d’erreur explicites ("Votre adresse de base de données n'est pas bonne", "Connexion à votre base de données impossible", "Changer les droits d’accès aux répertoires xxx, yyy, zzz" ou au fichier gna.php, etc.)
* Choix d'installation (le répertoire dans lequel est installé AEM devrait être au choix de la personne qui installe ; l'adresse de base doit pouvoir être choisie (democratie.mondomaine.org).
* Saisie directe du profil du premier administrateur depuis l'interface. Éventuellement, proposer la première personne inscrite comme webmestre (ajout d'un statut)
* ajout de préfixe pour les tables.

### Multilinguisme

Permettre à un administrateur de choisir la langue principale du site directement depuis l'interface.

### Catégories supplémentaires

Pour l'instant, toute personne inscrite dans l'interface a accès à tous les votes. Il faut permettre aux administrateurs de définir des cohortes de votants qui ont accès 
*  Aux Catégories (ou Thèmes)
*  aux Workshops (ou Ateliers).

Il faut donc créer un système de catégorie supplémentaire, assigné à la fois aux Categories, aux Workshops et au Users, de sorte que tel User auquel on assigue telle ou telle de ces catégories ne puisse voter qu'aux Categories ou Workshops correspondantes. Bien sur, on peut assigner à un User plusieurs de ces catégories. À son inscription, il doit pouvoir bénéficier d'une catégorie "par défaut". Bien sur, le système de délégations doit en tenir compte (quelqu'un ne peut pas déléguer quelqu'un d'autre qui ne participe pas au vote ; un délégué ne peut pas voter en sus pour une personne non inscrite).
Par contre, on ne peut associer à un **Thème** ou un **Atelier** qu'une seule catégorie.

### Autre typologie pour le système de catégories

Comme le terme "Catégorie" désigne déjà un objet éditorial, nous proposons que le terme **Categorie** soit remplacé par le terme **Thème** et que l'ajout d'une nouvelle forme catégorielle soit désignée par le terme ** Catégorie**.

### Visibilité sur l'espace public

L'administrateur devrait pouvoir définir si le vote est confidentiel ou public. Dans le premier cas, seules les personnes pouvant se loguer sur la plateforme ET ayant les droits par le système de catégorisation précédent peuvent accéder aux informations relatives à une ou plusieurs votations. Dans le second, les personnes ont accès aux informations du vote dans l'espace public, même non loguées. Elles ne peuvent pas voter.

Dans tous les cas, il faut être inscrit pour se loguer, voter, et déléguer.

##V1.2

### Un objet thémable

L'aspect public d'**AEM** est construit avec le moteur de vues `twig`. Dans l'idée future qu'une même plateforme puisse héberger les votations de plusieurs structures - et qu'à une **Catégorie** particulière on puisse assigner un aspect défini, obéissant à la charte graphique de la **Catégorie** -, On doit alors considérer qu'une structure globale des moteurs de vues puisse être envisagé. C'est un travail au long cours qui impacte de nombreuses choses - par exemple, une structure peut demander à ce que le champ lexical de "son" interface soit différente de celle du voisin, ... - et qui nécessite donc d'évaluer et d'imaginer la structure. Au minimum doit-on pouvoir donner le moyen d'avoir les classes nécessaires au bon fonctionnement d'une attribution de templates différents.

###Granulosité des profils

C'est le moment de définir :

* Le profil **Webmestre** dont l'objet est la maintenance technique globale de la plateforme et donc accès aux informations de debug (différente du profil **Administrateur** qui n'a accès qu'aux infos de base relatives à la plateforme).
* Un profil **Administrateur restreint** est ajouté. Il est associé à une ou plusieurs catégories et peut ainsi n'administrer que la partie des votes le concernant. Par exemple, cohabitent au sein de la même plateforme une association et une mairie dont l'une demande régulièrement des subventions à l'autre. Il paraît logique que la ville n'ait jamais vent des votations effectuées par l'association, et inversement. Éventuellement, un **Administrateur restreint** peut être inscrit en tant que votant dans une ou plusieurs autres catégories. Il aura alors les informations relatives aux votes. Il peut bien sûr être désigné en délégation (voir plus haut).

##V1.3

### Accepter d'autres tables utilisateurs

L'idée est de permettre de connecter une autre table issue d'une autre application, et d'assigner une ou plusieurs catégories à ces `Users` issues d'ailleurs. OU par exemple, permettre :

* une authentification par OAuth
* une identification sur un LDAP
* une identification par un compte Google ou de réseau social.

### Permettre des actions par Batch

Permettre à l’Administrateur de déplacer les délégations / droits de vote de plusieurs personnes à une autre unique (mais d'autres batches peuvent être envisagés).

### Régler la profondeur par défaut des forums

Par défaut, la profondeur des threads de forms est de 1. Donner à l'**Administrateur** ou l'**Administrateur restreint** la possibilité de modifier cette profondeur (jusqu'à trois).

##Divers

###Documentation
Un ensemble de documentation doit pouvoir être apporté à l'administrateur non-technicien. Vu l'évolution prévue de la plateforme, il faut mettre en place, parallèlement à l'évolution de la plateforme un système de documentation permettant :

* une documentation point par point / item développé
* un système de traduction de ladite documentation, au moins en anglais et en allemand.

###Sécurité
Étant donné le principe collaboratif de développement de la plateforme **AEM**, organiser régulièrement lors de hackathons des concours de hacking pour vérifier la solidité sécuritaire de la plateforme.