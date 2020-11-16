# Propositions / Améliorations

* Mise en place d'une page dédié au statistique
* View "plus de détails" pour afficher plus de détail lier à un matériel



# Tâches à faire

* Réussir à fusionner l'envoie de mail et la conversion en fichier PDF des informations de l'utilisateur
* Message/fenêtre de confirmation lors de la suppression 
* Mettre en place un margin botton et top aux boutons ajouter et supprimer de chaque élément des listes comme avec les spécificités (voir view /admin/specificite/list)
* Rajouter favicon
* S'occuper du réglage fuseau horraire des champs date
* Fonctionnalité de mot clé
* ❌ Les 2 premiers utilisateurs (ADMIN et PUBLIC) ne peuvent pas changer leur roles


# Questions

* Suppréssion d'un matériel => 
* Modification d'un matériel => 
* Champ "nom" de la table Materiel incompris => Dernier user manip
* Fonctionnalité de mot clé => champs mot clé avec recherche LIKE % % 
* Onglet Archive => Onglet "archive" <=> "gestion
* Est-ce nécessaire d'envoyer un PDF lorsqu'on modifie les informations d'un compte ? 
    * Juste lorsqu'un admin fait un changement de mot de passe


# Remarques après lecture du code et échange avec Lucas

* ✔️ Champs "present" dans la table User. Pourquoi ?
* Pour les interventions, plusieurs cas possible:

    * Départ en intervention avec du matériel (intervention classique)
    * Départ en intervention sans du matériel
    * Retour d'intervention avec le matériel prit lors du départ
    * Retour d'intervention sans le matériel prit lors du départ
    * Retour d'intervention avec matériel inconnu lors du départ

* Le rôle PUBLIC peut créer des interventions mais pas à son nom (Un user avec ROLE_PUBLIC ne pars pas en intervention)
* Pour la route AdminUser.edit la condition avec l'idUser c'est pour que les 2er user ne changent pas leur role


# Avancement projet #

## Jeudi 8 Octobre 2020

* ✔️ Factorisation du UserController.php


## Vendredi 9 Octobre 2020

* ✔️ Suppresion d'un User ne marche pas, revoir la fonction delete du UserController.php
* ✔️ Problème avec le menu déroulant de la navBar
* ✔️ NavBar pas centraliser, maintenabilité de celle-ci difficile car répétition de balise nav dans         différents fichier
* ❌ Dans le UserController -> fonction edit: variable check déclarer vide mais pas utiliser
* ✔️ Dans User.php, @UniqueConstraint devient @UniqueEntity

* L'mport de user ne marche pas 
* Fonction goBack ne marche pas
* Factorisier le ParamatreController de façon à avoir un Controller par Entité
* Disparition du générateur de code barre lors de la création d'un compte utilisateur

## Lundi 12 Octobre 2020

* ✔️ Création des FormType
* ✔️ Création des Repository
* ✔️ Factorisation du UserController.php
* ✔️ Création des services: 
    * CsvService.php
    * GeneratePdfService
    * MailerService.php


## Mardi 13 Octobre 2020

* ✔️ Centralisation de la NavBar de l'application
* ✔️ Séparation de la gestion des entité => Chaque entité aura sa propre page avec un système de       pagination
* ✔️ Administration des utilisateurs
* ✔️ Controller AdminUserController.php créé
* ✔️ Mise en place administration des lieu
* ✔️ Ajout/edition/suppression d'une marque


## Mercredi 14 Octobre 2020

* ✔️ Ajout/edition/suppression d'un lieu
* ✔️ AdminLieuController
* ✔️ Ajout/edition/suppression d'un lieu
* ✔️ AdminStatutController
* ✔️ Mise en place du model ApplicationType
* ✔️ Sécurisation des routes commençant par '/admin'
* ✔️ Ajout/edition/suppression d'un specificité
* ✔️ Ajout/edition/suppression d'un type


## Jeudi 15 Octobre 2020

* ✔️ Doublon de Statut/Lieu/Marque/Spécificité/Type possible pour le moment 
* ✔️ Mise en place du system de pagination et du PaginationService.php 
* ✔️ Mise en place des messages pour les Exceptions du PaginationService.php  
* ✔️ Factoriser le code twig pour la pagination
* ✔️ Type du champ date de la table Materiel changé en datetime


## Vendredi 16 Octobre 2020

* ✔️ Création et mise en place du CRUD de l'entité Materiel
    * ✔️ Ajout d'un matériel
    * ✔️ Suppréssion d'un matériel
    * ✔️ Mise à jour d'un matériel

* ✔️ Champ "supprimer" => présence du matériel


## Lundi 19 Octobre 2020

* ✔️ Création d'une view pour les archives
* ✔️ Ajout/edition/suppression d'un materiel
* ✔️ Filter les user pour avoir que les user présent
* ✔️ Archivation des utilisateurs
* ✔️ Désactivation des comptes


## Mardi 20 Octobre 2020

* ✔️ Archivation compte
* ✔️ Réel suppression de compte
* ✔️ Rendre dynamique les messages de confirmation de suppression
* ✔️ Activation des comptes
* ✔️ Redirection après connexion en fonction du role
* ✔️ Header dynamique en fonction du role de l'utilisateur connecté
* ❌Navbar
    * Onglet "intervention":
        * Faire disparaitre pour l'admin ou renvoyer vers la liste des interventions
        * Pour le user renvoyer vers le départ/retour d'intervention
    
    * Onglet "historique":
        * Pour l'admin renvoyer vers la liste de tout les interventions
        * Pour le user renvoyer vers SES interventions

* ❌ Infos utilisateurs détaillés 
* ❌ Infos matériels détaillés 
* ✔️ Mise à jour du mot de passe


## Mercredi 21 Octobre 2020

* ✔️ Autorisation et sécurisation des route
* ❌ Mise à jour des données de l'utilisateur (Erreur de validation du mot de passe lors de l'envoie du formulaire)


## Crédits

Première version de l'application développé par Laine Lucas.
Projet reprit par ILMI AMIR Igal

# Tâches à faire

	* Redirection après connexion en fonction du rôle de l'utilisateur)
	* Faire deux requêttes DQL:
		- Les comptes utilisateur activé
		- Les comptes utilisateur désactivé
	* Requêtte DQL pour la recherche des utilisateurs
	* Les pages d'erreurs (404, accès refusé, 500...)
