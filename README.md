# SchoolManager — Plateforme SaaS de gestion scolaire

Plateforme tout-en-un pour les etablissements scolaires en Afrique francophone.  
Gestion des eleves, paiements, notes, bulletins, presences, emploi du temps, messagerie et portail parents.

## Prerequis

- **PHP 8.4+**
- **Composer**
- **Node.js 18+** et **npm**
- **SQLite** (par defaut, aucun serveur de base de donnees requis)

## Installation

```bash
# 1. Cloner le projet
git clone https://github.com/Fallbamba10/ecole.git
cd ecole

# 2. Installer les dependances PHP
composer install

# 3. Installer les dependances front-end
npm install

# 4. Copier le fichier d'environnement
cp .env.example .env

# 5. Generer la cle d'application
php artisan key:generate

# 6. Creer la base de donnees SQLite
touch database/database.sqlite

# 7. Lancer les migrations
php artisan migrate

# 8. Charger les donnees de demonstration
php artisan db:seed --class=DemoSeeder

# 9. Compiler les assets
npm run build

# 10. Demarrer le serveur
php artisan serve
```

L'application est accessible sur **http://localhost:8000**

## Comptes de demonstration

| Role | Email | Mot de passe |
|------|-------|--------------|
| Directeur (admin) | `directeur@institut-excellence.sn` | `password` |
| Secretaire | `secretaire@institut-excellence.sn` | `password` |
| Enseignant | `fall@institut-excellence.sn` | `password` |

> Les donnees de demo incluent : 1 ecole, 6 classes, ~60 eleves, des notes, paiements et presences sur 20 jours.

## Fonctionnalites

- **Gestion des eleves** — inscription, fiches, import CSV
- **Classes** — creation, affectation, capacite
- **Paiements** — suivi inscription + mensualites, relances automatiques
- **Notes & Bulletins** — saisie unitaire ou en masse, generation PDF
- **Presences** — appel numerique par classe, statistiques
- **Emploi du temps** — planning hebdomadaire, detection de conflits
- **Messagerie interne** — entre enseignants, admin et parents
- **Portail parents** — consultation notes, presences, paiements
- **SMS parents** — envoi groupe (interface prete, API a configurer)
- **Statistiques** — tableaux de bord avec graphiques
- **Multi-tenant** — chaque ecole ne voit que ses propres donnees
- **Roles** — admin_ecole, enseignant, secretaire, parent, super_admin
- **Abonnements** — plans Basic / Standard / Premium avec periode d'essai

## Stack technique

- Laravel 13 (PHP 8.4)
- Tailwind CSS + Alpine.js
- Spatie Laravel Permission (gestion des roles)
- SQLite (dev) / MySQL (production)
- Vite (build des assets)

## Commandes utiles

```bash
# Lancer en mode developpement (hot reload)
npm run dev
# (dans un autre terminal)
php artisan serve

# Vider le cache
php artisan cache:clear && php artisan view:clear

# Relancer les migrations (reset complet)
php artisan migrate:fresh --seed --seeder=DemoSeeder
```

## Structure des roles

| Role | Acces |
|------|-------|
| `admin_ecole` | Tout (parametres, enseignants, parents, stats, exports) |
| `enseignant` | Notes, presences, classes assignees, annonces |
| `secretaire` | Paiements, eleves (consultation), frais scolaires |
| `parent` | Portail parent uniquement (notes, presences, paiements de ses enfants) |
| `super_admin` | Administration SaaS globale (toutes les ecoles) |

## Licence

Projet prive — tous droits reserves.
