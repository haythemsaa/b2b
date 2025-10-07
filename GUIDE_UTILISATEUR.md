# 📘 GUIDE UTILISATEUR COMPLET - B2B Platform

## 🌐 **URL D'ACCÈS**
**http://127.0.0.1:8001**

---

## 👑 **SUPER ADMIN**

### 🔐 **Identifiants**
- **Email:** admin@b2bplatform.com
- **Mot de passe:** superadmin123

### 🎯 **Fonctionnalités Disponibles**

#### 📊 Dashboard & Analytics
- **Dashboard Principal** → `/superadmin`
  - Vue d'ensemble de la plateforme
  - Métriques en temps réel
  - Statistiques globales

- **Analytics Avancées** → `/superadmin/analytics`
  - Rapports détaillés
  - Graphiques de performance
  - Tendances utilisateurs

#### 🏢 Gestion des Tenants
- **Liste des Tenants** → `/superadmin/tenants`
  - Voir tous les tenants
  - Créer nouveau tenant
  - Modifier tenants existants

- **Créer Tenant** → `/superadmin/tenants/create`
  - Formulaire création tenant
  - Configuration initiale

- **Modifier Tenant** → `/superadmin/tenants/{id}/edit`
  - Édition des paramètres
  - Gestion quotas

- **Actions Spéciales**
  - Suspendre tenant → `PATCH /superadmin/tenants/{tenant}/suspend`
  - Activer tenant → `PATCH /superadmin/tenants/{tenant}/activate`
  - Restaurer tenant → `PATCH /superadmin/tenants/{id}/restore`

#### 📈 Exports de Données
- **Export Tenants** → `/superadmin/export/tenants`
  - CSV de tous les tenants

- **Export Détails Tenant** → `/superadmin/export/tenants/{tenant}`
  - Données spécifiques tenant

- **Export Analytics** → `/superadmin/export/analytics`
  - Rapports analytics CSV

- **Rapport Financier** → `/superadmin/export/financial`
  - Données financières globales

---

## 🏢 **ADMIN / GROSSISTE**

### 🔐 **Identifiants**
**Compte 1:**
- **Email:** grossiste@b2b.com
- **Mot de passe:** password

**Compte 2:**
- **Email:** admin@b2b.test
- **Mot de passe:** password

### 🎯 **Fonctionnalités Disponibles**

#### 📊 Dashboard Admin
- **Dashboard** → `/admin/dashboard`
  - KPIs principaux
  - Statistiques de ventes
  - Activité récente

#### 👥 Gestion des Utilisateurs
- **Liste Utilisateurs** → `/admin/users`
  - Tous les vendeurs
  - Filtres et recherche

- **Créer Utilisateur** → `/admin/users/create`
  - Nouveau vendeur
  - Attribution groupes

- **Modifier Utilisateur** → `/admin/users/{user}/edit`
  - Édition profil vendeur

- **Actions:**
  - Activer/Désactiver → `POST /admin/users/{user}/toggle-status`
  - Supprimer → `DELETE /admin/users/{user}`

#### 👨‍👩‍👧‍👦 Gestion des Groupes Clients
- **Liste Groupes** → `/admin/groups`
  - Tous les groupes clients

- **Créer Groupe** → `/admin/groups/create`
  - Nouveau groupe
  - Définir remises

- **Voir Groupe** → `/admin/groups/{group}`
  - Détails et membres

- **Modifier Groupe** → `/admin/groups/{group}/edit`
  - Édition configuration

- **Actions:**
  - Activer/Désactiver → `POST /admin/groups/{group}/toggle-status`
  - Supprimer → `DELETE /admin/groups/{group}`

#### 📦 Gestion des Produits
- **Liste Produits** → `/admin/products`
  - Catalogue complet
  - Recherche et filtres

- **Créer Produit** → `/admin/products/create`
  - Nouveau produit
  - Upload images (jusqu'à 5)
  - Spécifications complètes

- **Modifier Produit** → `/admin/products/{product}/edit`
  - Édition détails
  - Gestion images
  - Stock et prix

- **Actions:**
  - Activer/Désactiver → `POST /admin/products/{product}/toggle-status`
  - Mettre à jour stock → `POST /admin/products/{product}/update-stock`
  - Supprimer image → `DELETE /admin/products/{product}/images/{image}`
  - Définir image couverture → `POST /admin/products/{product}/images/{image}/set-cover`
  - Supprimer → `DELETE /admin/products/{product}`

#### 🏷️ Gestion des Catégories
- **CRUD Catégories** → `/admin/categories`
  - Créer, lire, modifier, supprimer
  - Catégories hiérarchiques

#### 🎨 Gestion des Attributs
- **CRUD Attributs** → `/admin/attributes`
  - Créer attributs produits
  - Valeurs d'attributs

- **Actions:**
  - Ajouter valeur → `POST /admin/attributes/{attribute}/values`
  - Supprimer valeur → `DELETE /admin/attributes/{attribute}/values/{value}`

#### 💰 Prix Personnalisés
- **Liste Prix** → `/admin/custom-prices`
  - Tous les prix personnalisés

- **Créer Prix** → `/admin/custom-prices/create`
  - Nouveau tarif spécial
  - Par client ou groupe

- **Voir Prix** → `/admin/custom-prices/{customPrice}`
  - Détails tarification

- **Modifier Prix** → `/admin/custom-prices/{customPrice}/edit`
  - Édition prix

- **Actions:**
  - Activer/Désactiver → `POST /admin/custom-prices/{customPrice}/toggle-status`
  - Supprimer → `DELETE /admin/custom-prices/{customPrice}`

#### 📋 Gestion des Commandes
- **Liste Commandes** → `/admin/orders`
  - Toutes les commandes
  - Filtres par statut

- **Voir Commande** → `/admin/orders/{order}`
  - Détails complets
  - Timeline

- **Actions:**
  - Changer statut → `POST /admin/orders/{order}/update-status`
  - Ajouter notes → `POST /admin/orders/{order}/add-notes`

#### 🔄 Gestion des Retours (RMA)
- **Liste Retours** → `/admin/returns`
  - Toutes les demandes de retour

- **Voir Retour** → `/admin/returns/{return}`
  - Détails demande

- **Actions:**
  - Approuver → `POST /admin/returns/{return}/approve`
  - Refuser → `POST /admin/returns/{return}/reject`
  - Changer statut → `POST /admin/returns/{return}/update-status`
  - Action groupée → `POST /admin/returns/bulk-action`
  - Export → `GET /admin/returns/export`
  - Supprimer → `DELETE /admin/returns/{return}`

#### 💬 Messagerie
- **Liste Messages** → `/admin/messages`
  - Tous les messages vendeurs

- **Conversation** → `/admin/messages/conversation/{user}`
  - Discussion avec vendeur

- **Envoyer Message** → `POST /admin/messages/send`

#### 📑 RAPPORTS (NOUVEAU!)
- **Dashboard Rapports** → `/admin/reports`
  - Vue d'ensemble des rapports

- **Rapport Ventes** → `/admin/reports/sales`
  - Ventes quotidiennes par période
  - Top 10 vendeurs par CA
  - Top 10 produits par revenu
  - Statistiques globales (CA, commandes, panier moyen)
  - Graphiques temporels
  - Filtres par date

- **Rapport Stock** → `/admin/reports/inventory`
  - Produits stock faible
  - Produits en rupture
  - Valeur totale stock
  - Répartition par catégorie
  - Statistiques produits actifs/inactifs

- **Rapport Clients** → `/admin/reports/customers`
  - Top 20 clients par CA
  - Clients par groupe
  - Nouveaux clients (30j)
  - Taux d'activité
  - Historique dernière commande

- **Exports CSV** → `/admin/reports/export/{type}`
  - Export ventes → `/admin/reports/export/sales`
  - Export produits → `/admin/reports/export/products`
  - Export clients → `/admin/reports/export/customers`

---

## 🛒 **VENDEUR**

### 🔐 **Identifiants**

**Vendeur 1:**
- **Email:** ahmed@vendeur1.com
- **Mot de passe:** password

**Vendeur 2:**
- **Email:** fatma@vendeur2.com
- **Mot de passe:** password

**Vendeur 3:**
- **Email:** ali@vendeur3.com
- **Mot de passe:** password

**Vendeur 4:**
- **Email:** salma@vendeur4.com
- **Mot de passe:** password

### 🎯 **Fonctionnalités Disponibles**

#### 📊 Dashboard Vendeur (AMÉLIORÉ!)
- **Dashboard Principal** → `/dashboard`
  - KPIs personnels
  - **Graphique commandes mensuelles** (12 derniers mois)
  - **Top 5 produits commandés**
  - **Statistiques par statut** (graphique donut)
  - **Total dépenses 30 jours**
  - **Panier moyen**
  - Commandes récentes
  - Produits recommandés
  - Actions rapides

#### 👤 Profil
- **Mon Profil** → `/profile`
  - Informations personnelles
  - Modifier profil

#### 📦 Catalogue Produits
- **Parcourir Produits** → `/products`
  - Catalogue complet
  - **Filtres avancés:**
    - Recherche par nom/description
    - Tri (nom, prix, nouveau)
    - Plage de prix
    - Disponibilité stock
    - Par catégorie
  - **2 modes d'affichage:** Grille / Liste
  - Affichage prix personnalisés

- **Recherche** → `/products/search`
  - Recherche avancée

- **Par Catégorie** → `/products/category/{category}`
  - Filtrer par catégorie

- **Détails Produit** → `/products/{product}`
  - Fiche produit complète
  - Images multiples
  - Spécifications
  - Stock disponible
  - Prix personnalisé

#### 🛒 PANIER (NOUVEAU!)
- **Voir Panier** → `/cart`
  - Articles dans le panier
  - Totaux (HT, TVA, TTC)
  - Codes promo

- **Actions:**
  - Ajouter au panier → `POST /cart/add`
  - Modifier quantité → `PUT /cart/update/{itemId}`
  - Retirer article → `DELETE /cart/remove/{itemId}`
  - Vider panier → `POST /cart/clear`
  - Obtenir compteur → `GET /cart/count`
  - Appliquer code promo → `POST /cart/apply-discount`
    - Codes disponibles: WELCOME10, SAVE20, BULK30
  - Retirer code promo → `POST /cart/remove-discount`

#### 🎁 WISHLIST (NOUVEAU!)
- **Ma Liste de Souhaits** → `/wishlist`
  - Produits favoris
  - Notes personnelles
  - Priorités

- **Actions:**
  - Ajouter à wishlist → `POST /wishlist/add`
  - Retirer de wishlist → `DELETE /wishlist/remove/{itemId}`
  - Déplacer vers panier → `POST /wishlist/move-to-cart/{itemId}`
  - Vider wishlist → `POST /wishlist/clear`
  - Obtenir compteur → `GET /wishlist/count`

#### 📋 Commandes
- **Mes Commandes** → `/orders`
  - Historique complet
  - Filtres par statut

- **Passer Commande** → `POST /orders/checkout`
  - Validation panier
  - Création commande

- **Voir Commande** → `/orders/{order}`
  - Détails commande
  - Suivi livraison
  - Timeline statuts

#### 🔄 Retours Produits
- **Mes Retours** → `/returns`
  - Liste demandes retour

- **Créer Retour** → `/returns/create`
  - Formulaire demande RMA
  - Sélection produits

- **Voir Retour** → `/returns/{return}`
  - Détails demande
  - Statut traitement

- **Actions:**
  - Supprimer demande → `DELETE /returns/{return}`
  - Obtenir articles commande → `GET /returns/order/{order}/items`

#### 💬 Messagerie
- **Mes Messages** → `/messages`
  - Conversations avec grossiste
  - Messages non lus

- **Actions:**
  - Envoyer message → `POST /messages/send`
  - Marquer lu → `POST /messages/mark-read/{message}`
  - Compteur non lus → `GET /messages/unread-count`

#### 🔔 Notifications
- **Mes Notifications** → `/notifications`
  - Toutes les notifications

- **API Notifications:**
  - Marquer lue → `POST /notifications/{id}/mark-read`
  - Marquer toutes lues → `POST /notifications/mark-all-read`
  - Compteur non lues → `GET /notifications/api/unread-count`
  - Récentes → `GET /notifications/api/recent`
  - Supprimer → `DELETE /notifications/{id}`
  - Supprimer lues → `DELETE /notifications/read/all`

#### 📍 Adresses de Livraison
- **Mes Adresses** → `/addresses`
  - Liste adresses

- **Créer Adresse** → `/addresses/create`
  - Nouvelle adresse

- **Modifier Adresse** → `/addresses/{address}/edit`
  - Édition adresse

- **Actions:**
  - Mettre par défaut → `POST /addresses/{address}/set-default`
  - Supprimer → `DELETE /addresses/{address}`

---

## 🎨 **FONCTIONNALITÉS COMMUNES**

### 🔐 Authentification
- **Connexion** → `/login`
- **Déconnexion** → `POST /logout`
- **Mot de passe oublié** → `/forgot-password`
- **Email reset** → `POST /forgot-password`
- **Changer mot de passe** → `POST /change-password`
- **Mettre à jour profil** → `POST /update-profile`

### 🌍 Internationalisation
- **Changer langue** → `/set-locale/{locale}`
  - Langues disponibles: FR, AR

---

## 📊 **DONNÉES DE TEST**

### 📦 Produits
- **13 produits** en catalogue
- **16 catégories** disponibles
- **Stock total:** 1,395 unités
- **Valeur stock:** 18,360.50 DT

### 👥 Utilisateurs
- **1 SuperAdmin**
- **2 Grossistes**
- **4 Vendeurs**
- **Total:** 7 utilisateurs actifs

### 🏷️ Tarification
- **6 prix personnalisés** configurés
- **4 groupes clients** définis
- **Codes promo disponibles:**
  - `WELCOME10` → 10% de réduction
  - `SAVE20` → 20% de réduction
  - `BULK30` → 30% de réduction

---

## 🚀 **WORKFLOW COMPLET VENDEUR**

### 1️⃣ Connexion
1. Aller sur http://127.0.0.1:8001/login
2. Se connecter avec identifiants vendeur
3. Redirection vers `/dashboard`

### 2️⃣ Parcourir Produits
1. Cliquer sur "Parcourir les produits"
2. Utiliser filtres de recherche
3. Voir détails produit

### 3️⃣ Ajouter au Panier
1. Sur fiche produit, cliquer "Ajouter au panier"
2. OU ajouter à la wishlist
3. Voir panier en temps réel (compteur)

### 4️⃣ Passer Commande
1. Aller sur `/cart`
2. Vérifier articles
3. Appliquer code promo (optionnel)
4. Cliquer "Commander"
5. Confirmation commande

### 5️⃣ Suivre Commande
1. Aller sur `/orders`
2. Cliquer sur commande
3. Voir détails et statut
4. Timeline de livraison

### 6️⃣ Demander Retour (si besoin)
1. Aller sur `/returns/create`
2. Sélectionner commande
3. Choisir produits à retourner
4. Motif de retour
5. Soumettre demande

---

## 🔧 **COMMANDES UTILES**

### Démarrer le serveur
```bash
"C:\wamp64\bin\php\php8.1.0\php.exe" artisan serve --host=127.0.0.1 --port=8001
```

### Migrations
```bash
"C:\wamp64\bin\php\php8.1.0\php.exe" artisan migrate
"C:\wamp64\bin\php\php8.1.0\php.exe" artisan migrate:status
```

### Cache
```bash
"C:\wamp64\bin\php\php8.1.0\php.exe" artisan cache:clear
"C:\wamp64\bin\php\php8.1.0\php.exe" artisan config:clear
"C:\wamp64\bin\php\php8.1.0\php.exe" artisan route:clear
```

---

## 📞 **SUPPORT**

Pour toute question ou problème:
1. Vérifier ce guide
2. Consulter CLAUDE.md
3. Consulter ETAT_FINAL_CAHIER_CHARGES.md

---

**✨ GUIDE COMPLET - APPLICATION B2B MULTI-TENANT**
**Version: 1.1 - Mise à jour: 06 Octobre 2025**
