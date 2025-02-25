# Projet de gestion des tâches des utilisateurs

Ce projet consiste en la création d'une **API REST** pour la gestion des tâches des utilisateurs. Développée avec **Laravel**, cette API permet aux utilisateurs authentifiés de gérer leurs tâches dans une base de données **MySQL**.

L'application permet de créer, lire, mettre à jour et supprimer des tâches. Elle inclut un système d'authentification des utilisateurs pour garantir que seuls les utilisateurs authentifiés puissent accéder à leurs données.

## Fonctionnalités

- Authentification des utilisateurs (inscription et connexion).
- Gestion des tâches des utilisateurs authentifiés (CRUD).
- API RESTful construite avec Laravel.
- Base de données MySQL pour stocker les données des utilisateurs et des tâches.

## Prérequis

Avant de commencer l'installation, assurez-vous d'avoir installé les éléments suivants :

- **PHP** 8.x ou supérieur
- **Composer**
- **Laravel 9.x** ou supérieur
- **MySQL** pour la gestion de la base de données
- Un outil comme **Postman** ou **Insomnia** pour tester les requêtes API

## Installation

### 1. Cloner le dépôt

Clonez le dépôt Git sur votre machine locale en utilisant la commande suivante :

```bash
git clone https://github.com/ton-utilisateur/ton-projet.git
cd ton-projet
