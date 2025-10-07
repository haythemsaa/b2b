# 📚 Tutoriel Complet - Plateforme B2B Multi-Tenant

## 🌐 Accès à l'Application

**URL de l'application :** http://127.0.0.1:8001

### 👥 Comptes de Test Disponibles

| Rôle | Email | Mot de passe | Accès |
|------|-------|--------------|-------|
| SuperAdmin | admin@b2bplatform.com | superadmin123 | Gestion complète plateforme |
| Grossiste | grossiste@b2b.com | password | Administration tenant |
| Vendeur | ahmed@vendeur1.com | password | Catalogue et commandes |

---

## 🎯 Table des Matières

1. [SuperAdmin - Gestion Plateforme](#superadmin)
2. [Grossiste/Admin - Gestion Entreprise](#grossiste)
3. [Vendeur - Utilisation Quotidienne](#vendeur)
4. [Fonctionnalités Avancées](#avancees)

---

## 🔴 1. SUPERADMIN - Gestion Plateforme {#superadmin}

### 1.1. Connexion SuperAdmin

1. Accédez à http://127.0.0.1:8001/login
2. Email : `admin@b2bplatform.com`
3. Mot de passe : `superadmin123`
4. Cliquez sur **Se connecter**

### 1.2. Dashboard SuperAdmin

**URL :** `/superadmin/dashboard`

**Fonctionnalités :**
- Vue d'ensemble de tous les tenants
- Statistiques globales de la plateforme
- Métriques de performance
- Activité récente

**Actions disponibles :**
```
📊 Voir les statistiques globales
👥 Nombre total de tenants
💰 Revenus totaux de la plateforme
📈 Graphiques d'évolution
```

### 1.3. Gestion des Tenants

**URL :** `/superadmin/tenants`

#### Créer un nouveau tenant

1. Cliquez sur **+ Nouveau Tenant**
2. Remplissez le formulaire :
   - **Nom de l'entreprise** : Nom du client
   - **Sous-domaine** : URL unique (ex: `entreprise1`)
   - **Email contact** : email@entreprise.com
   - **Plan** : Sélectionnez le plan (Basic, Pro, Enterprise)
   - **Limite utilisateurs** : Nombre max d'utilisateurs
   - **Limite produits** : Nombre max de produits
   - **Stockage** : Espace de stockage en GB
3. Cliquez sur **Créer le tenant**

#### Gérer un tenant existant

**Actions disponibles :**
- ✏️ **Modifier** : Changer le plan, les limites
- 🔄 **Activer/Désactiver** : Suspendre l'accès temporairement
- 📊 **Voir détails** : Statistiques d'utilisation
- 🗑️ **Supprimer** : Suppression définitive (attention !)

#### Vérifier l'utilisation des quotas

```
Utilisateurs : 5/10 (50%)
Produits : 150/500 (30%)
Stockage : 2.5GB/10GB (25%)
```

### 1.4. Analytics Globales

**URL :** `/superadmin/analytics`

**Métriques disponibles :**
- Croissance des tenants
- Revenus par tenant
- Utilisation des ressources
- Performance de la plateforme

### 1.5. Exports de Données

**Options d'export :**

1. **Export Tenants** : `/superadmin/export/tenants?format=csv`
   - Liste complète des tenants
   - Informations de facturation
   - Statuts d'activité

2. **Export Analytics** : `/superadmin/export/analytics?format=csv`
   - Métriques de performance
   - Données d'utilisation

3. **Export Financier** : `/superadmin/export/financial?format=csv`
   - Revenus par tenant
   - Historique de facturation

---

## 🟢 2. GROSSISTE/ADMIN - Gestion Entreprise {#grossiste}

### 2.1. Connexion Grossiste

1. Accédez à http://127.0.0.1:8001/login
2. Email : `grossiste@b2b.com`
3. Mot de passe : `password`
4. Cliquez sur **Se connecter**

### 2.2. Dashboard Admin

**URL :** `/admin/dashboard`

**Vue d'ensemble :**
- 📊 Statistiques clés (CA, commandes, vendeurs)
- 📈 Graphiques de ventes (12 derniers mois)
- 🏆 Top 5 produits les plus vendus
- 📦 Commandes récentes
- ⚠️ Alertes stock faible

### 2.3. Gestion des Vendeurs

**URL :** `/admin/users`

#### Créer un nouveau vendeur

1. Cliquez sur **+ Nouveau Vendeur**
2. Remplissez le formulaire :
   ```
   Nom : Ahmed Ben Ali
   Email : ahmed@votreentreprise.com
   Mot de passe : ********
   Téléphone : +216 XX XXX XXX
   Groupe client : Détaillant Standard
   Statut : Actif
   ```
3. Cliquez sur **Créer**

#### Gérer les vendeurs existants

**Actions :**
- ✏️ **Modifier** : Changer informations, groupe
- 🔄 **Activer/Désactiver** : Suspendre accès
- 🗑️ **Supprimer** : Retirer définitivement

### 2.4. Gestion des Groupes Clients

**URL :** `/admin/groups`

#### Créer un groupe client

1. Cliquez sur **+ Nouveau Groupe**
2. Configuration :
   ```
   Nom : VIP Gold
   Description : Clients premium avec avantages
   Remise par défaut : 15%
   Conditions de paiement : 60 jours
   Statut : Actif
   ```
3. **Sauvegarder**

**Utilité :**
- Tarification différenciée
- Conditions de paiement spécifiques
- Gestion par segment de clientèle

### 2.5. Gestion du Catalogue Produits

**URL :** `/admin/products`

#### Ajouter un produit

1. Cliquez sur **+ Nouveau Produit**
2. **Onglet Informations Générales** :
   ```
   Nom : Smartphone XYZ Pro
   Référence : SP-XYZ-001
   Code-barres : 1234567890123
   Catégorie : Électronique > Téléphones
   Marque : TechBrand
   Description : Smartphone haute performance...
   ```

3. **Onglet Tarification** :
   ```
   Prix de base : 899.000 TND
   Prix d'achat : 650.000 TND
   TVA : 19%
   Unité : Pièce
   ```

4. **Onglet Stock** :
   ```
   Stock initial : 100
   Stock minimum : 10
   Stock maximum : 500
   Emplacement : Entrepôt A - Rayon 3
   ```

5. **Onglet Images** :
   - Glissez-déposez jusqu'à 5 images
   - Première image = image principale
   - Formats acceptés : JPG, PNG (max 2MB)

6. **Onglet Attributs** (optionnel) :
   ```
   Couleur : Noir, Blanc, Bleu
   Mémoire : 64GB, 128GB, 256GB
   Garantie : 2 ans
   ```

7. Cliquez sur **Créer le produit**

#### Gérer les images produits

1. Accédez à un produit existant
2. Section **Gestion des images** :
   - **Ajouter** : Upload nouvelle image
   - **Définir principale** : Choisir image de couverture
   - **Supprimer** : Retirer une image (avec confirmation)

#### Mettre à jour le stock

**Méthode rapide :**
1. Liste des produits → icône stock
2. Entrez la nouvelle quantité
3. **Valider**

**Méthode détaillée :**
1. Éditer le produit
2. Onglet **Stock**
3. Modifier les valeurs
4. **Sauvegarder**

### 2.6. Prix Personnalisés

**URL :** `/admin/custom-prices`

#### Créer un prix personnalisé

1. Cliquez sur **+ Nouveau Prix**
2. Configuration :
   ```
   Produit : Smartphone XYZ Pro
   Groupe client : VIP Gold
   Prix personnalisé : 799.000 TND (au lieu de 899)
   Remise : 11.14%
   Date début : 01/10/2025
   Date fin : 31/12/2025
   Statut : Actif
   ```
3. **Créer**

**Utilité :**
- Prix spéciaux par groupe
- Promotions ciblées
- Contrats négociés

### 2.7. Gestion des Commandes

**URL :** `/admin/orders`

#### Consulter les commandes

**Filtres disponibles :**
- Par statut (pending, processing, completed, cancelled)
- Par vendeur
- Par période
- Par montant

#### Traiter une commande

1. Cliquez sur une commande
2. **Informations visibles :**
   ```
   N° Commande : ORD-202510-0042
   Vendeur : Ahmed Ben Ali
   Date : 07/10/2025 14:30
   Statut : En traitement
   Total : 2,450.000 TND
   ```

3. **Actions disponibles :**
   - 📝 **Ajouter une note** : Communication interne
   - 🔄 **Changer le statut** :
     - ⏳ Pending → En attente de validation
     - 🔄 Processing → En cours de préparation
     - ✅ Completed → Terminée et livrée
     - ❌ Cancelled → Annulée
   - 🧾 **Générer facture** : Créer la facture automatiquement
   - 📄 **Voir détails** : Articles, quantités, prix

#### Timeline d'une commande

```
📅 07/10/2025 14:30 - Commande créée
📝 07/10/2025 15:00 - Note ajoutée : "Vérifier stock"
🔄 07/10/2025 16:00 - Statut changé : Processing
🧾 07/10/2025 16:30 - Facture générée
✅ 08/10/2025 10:00 - Statut changé : Completed
```

### 2.8. Gestion des Factures

**URL :** `/admin/invoices`

#### Générer une facture depuis une commande

1. Accédez à la commande
2. Cliquez sur **Générer Facture**
3. Vérifiez les informations :
   ```
   N° Facture : INV-202510-0023 (auto-généré)
   Date émission : 07/10/2025
   Date échéance : 06/11/2025 (30 jours)
   Sous-total HT : 2,058.823 TND
   TVA 19% : 391.177 TND
   Total TTC : 2,450.000 TND
   ```
4. **Confirmer**

#### Actions sur une facture

- 👁️ **Voir** : Détails complets
- 📄 **PDF** : Ouvrir dans le navigateur
- 💾 **Télécharger** : Sauvegarder le PDF
- ✉️ **Marquer envoyée** : Notifier envoi client
- ✅ **Marquer payée** : Confirmer le paiement
- 🔄 **Changer statut** : pending/paid/overdue/cancelled

#### Export factures CSV

1. Cliquez sur **Export CSV**
2. Sélectionnez la période (optionnel)
3. Le fichier `invoices_2025-10-07.csv` est téléchargé

**Colonnes du CSV :**
```
N° Facture, N° Commande, Client, Date, Échéance,
Sous-total, TVA, Total, Statut, Date Paiement
```

### 2.9. Gestion des Devis

**URL :** `/admin/quotes`

#### Consulter les devis

**Statuts possibles :**
- 📝 **Draft** : Brouillon
- 📧 **Sent** : Envoyé au client
- 👁️ **Viewed** : Consulté par le client
- ✅ **Accepted** : Accepté
- ❌ **Rejected** : Refusé
- ⏳ **Expired** : Expiré
- 🛒 **Converted** : Converti en commande

#### Approuver un devis

1. Vendeur crée le devis
2. Admin reçoit notification
3. Cliquez sur **Approuver**
4. Le devis passe de "Draft" à "Sent"
5. Client peut maintenant le consulter

#### Convertir un devis en commande

1. Devis avec statut "Accepted"
2. Cliquez sur **Convertir en Commande**
3. Une commande est automatiquement créée
4. Stock est réservé
5. Facture peut être générée

### 2.10. Retours RMA (SAV)

**URL :** `/admin/returns`

#### Traiter une demande de retour

1. Vendeur crée la demande
2. Admin consulte les détails :
   ```
   N° RMA : RMA-202510-0005
   Commande : ORD-202510-0042
   Produit : Smartphone XYZ Pro
   Quantité : 1
   Raison : Défaut de fabrication
   État produit : Défectueux
   Photos : [3 images]
   ```

3. **Actions possibles :**
   - ✅ **Approuver** : Autoriser le retour
     - Choisir : Remboursement ou Échange
     - Générer bon de retour
   - ❌ **Rejeter** : Refuser la demande
     - Justifier la décision
   - 💬 **Ajouter note** : Communication avec vendeur

#### Workflow RMA complet

```
1. Pending → En attente validation admin
2. Approved → Retour autorisé, attente envoi
3. Received → Produit reçu au SAV
4. Refunded/Replaced → Remboursé ou échangé
5. Completed → Dossier clôturé
```

### 2.11. Rapports & Analytics

**URL :** `/admin/reports`

#### Rapport des Ventes

**URL :** `/admin/reports/sales`

**Informations disponibles :**
- 📊 **Graphique d'évolution** (Chart.js)
  - Ventes quotidiennes par période
  - Lignes de tendance
- 🏆 **Top 10 Vendeurs** par chiffre d'affaires
- 📦 **Top 10 Produits** les plus vendus
- 📈 **Statistiques globales** :
  ```
  CA Total : 145,250.000 TND
  Nombre commandes : 387
  Panier moyen : 375.323 TND
  ```

**Filtres :**
- Date début / Date fin
- Par vendeur
- Par catégorie produit

**Export :** CSV avec toutes les données

#### Rapport des Stocks

**URL :** `/admin/reports/inventory`

**Sections :**
1. **Vue d'ensemble** :
   ```
   Total produits : 245
   Produits actifs : 228
   Stock total : 12,450 unités
   Valeur stock : 1,250,000 TND
   ```

2. **Alertes Stock Faible** (< seuil minimum)
   - Liste des produits en alerte
   - Quantité actuelle vs minimum
   - Actions recommandées

3. **Produits en Rupture** (stock = 0)
   - Liste complète
   - Dernière vente
   - Commandes en attente

4. **Répartition par Catégorie**
   - Nombre de produits
   - Valeur totale
   - % du stock total
   - Barres de progression visuelles

#### Rapport des Clients

**URL :** `/admin/reports/customers`

**Analyses :**
1. **Top 20 Clients** par CA
   - 🏆 Médailles pour le top 3
   - Nombre de commandes
   - Panier moyen
   - Dernière commande

2. **Clients par Groupe**
   ```
   VIP Gold : 15 clients (CA : 250,000 TND)
   Détaillant Standard : 42 clients (CA : 180,000 TND)
   Nouveau : 8 clients (CA : 15,000 TND)
   ```

3. **Statistiques globales** :
   ```
   Total clients : 65
   Clients actifs (30j) : 48 (73.8%)
   Nouveaux clients (30j) : 8
   ```

**Export CSV :** Données complètes pour analyse externe

### 2.12. Devises & Taux de Change

**URL :** `/admin/currencies`

#### Gérer les devises

**Devises pré-configurées :**
- 🇹🇳 TND - Dinar Tunisien (par défaut)
- 🇪🇺 EUR - Euro
- 🇺🇸 USD - Dollar Américain
- 🇬🇧 GBP - Livre Sterling
- 🇨🇭 CHF - Franc Suisse
- 🇲🇦 MAD - Dirham Marocain
- 🇩🇿 DZD - Dinar Algérien

#### Ajouter une devise

1. Cliquez sur **+ Nouvelle Devise**
2. Configuration :
   ```
   Code : EUR
   Nom : Euro
   Symbole : €
   Taux de change : 3.250 (1 EUR = 3.250 TND)
   Décimales : 2
   Position symbole : Avant
   Statut : Actif
   ```

#### Gestion des Taux de Change

**URL :** `/admin/exchange-rates`

**Fonctionnalités :**
- 📊 **Historique des taux** avec graphiques
- 🔄 **Mise à jour manuelle** des taux
- 🌐 **Récupération API** automatique (exchangerate-api.com)
- 💱 **Convertisseur en temps réel** :
  ```
  100 EUR × 3.250 = 325.000 TND
  ```

### 2.13. Intégrations ERP

**URL :** `/admin/integrations`

#### Systèmes ERP Supportés

- SAP Business One
- Microsoft Dynamics 365
- Sage 100/300
- QuickBooks
- Odoo
- Xero
- NetSuite
- Custom API

#### Configurer une intégration

1. Cliquez sur **+ Nouvelle Intégration**
2. Sélectionnez le système ERP
3. Configuration :
   ```
   Nom : Intégration SAP Production
   Type ERP : SAP Business One
   URL API : https://api.sap.com/v1
   Identifiant : user_sap_123
   Mot de passe : ******** (chiffré)
   Token API : ********** (chiffré)
   ```

4. **Paramètres de synchronisation** :
   ```
   Direction : Bidirectionnelle
   Entités : Produits, Commandes, Clients, Factures
   Fréquence : Horaire
   Actif : Oui
   ```

#### Tester la connexion

1. Cliquez sur **Test Connexion**
2. Vérification :
   ```
   ✅ Connexion établie
   ✅ Authentification réussie
   ✅ API accessible
   📊 12 produits disponibles
   ```

#### Synchronisation manuelle

1. Bouton **Synchroniser Maintenant**
2. Sélectionnez les entités
3. Lancez la sync
4. Consultez le log en temps réel

#### Logs d'intégration

**URL :** `/admin/integrations/{id}/logs`

**Informations enregistrées :**
```
Date/Heure : 07/10/2025 15:30:22
Type : Synchronisation Produits
Statut : Succès
Durée : 2.5s
Éléments traités : 150 produits
Requête : POST /api/v1/products/sync
Réponse : 200 OK
```

**Filtres disponibles :**
- Par statut (succès/erreur)
- Par type de sync
- Par période

### 2.14. Messagerie Interne

**URL :** `/admin/messages`

#### Envoyer un message

1. Cliquez sur **Nouveau Message**
2. Destinataire : Sélectionnez vendeur(s)
3. Sujet : Objet du message
4. Message : Corps du texte
5. **Envoyer**

#### Recevoir et répondre

- 🔔 Notification en temps réel
- Badge compteur sur icône messages
- Marquer comme lu
- Répondre directement

---

## 🔵 3. VENDEUR - Utilisation Quotidienne {#vendeur}

### 3.1. Connexion Vendeur

1. Accédez à http://127.0.0.1:8001/login
2. Email : `ahmed@vendeur1.com`
3. Mot de passe : `password`
4. Cliquez sur **Se connecter**

### 3.2. Dashboard Vendeur

**URL :** `/dashboard`

**Widgets disponibles :**
- 💰 **Total achats** (30 derniers jours)
- 📦 **Mes commandes** (nombre)
- 💵 **Panier moyen**
- 📊 **Graphique commandes** (12 mois)
- 🏆 **Mes 5 produits favoris**

### 3.3. Parcourir le Catalogue

**URL :** `/products`

#### Recherche et filtres

**Barre de recherche :**
- Nom du produit
- Référence
- Code-barres

**Filtres latéraux :**
- 📁 **Catégories** (arbre hiérarchique)
- 💰 **Prix** :
  ```
  Prix min : 0 TND
  Prix max : 1000 TND
  ```
- ⭐ **Disponibilité** :
  - ✅ En stock uniquement
  - 📦 Stock faible
  - ❌ Inclure rupture
- 🏷️ **Marques**
- 🎨 **Attributs** (couleur, taille, etc.)

**Tri :**
- Nouveautés
- Prix croissant / décroissant
- Nom A-Z / Z-A
- Les plus vendus

#### Vue Grille vs Liste

**Bouton toggle** pour changer l'affichage :
- 🔲 **Grille** : Cards avec images
- 📋 **Liste** : Tableau détaillé

### 3.4. Fiche Produit

**URL :** `/products/{id}`

#### Informations affichées

**Section principale :**
- 🖼️ **Galerie d'images** (carousel)
- 📝 **Nom et référence**
- 💰 **Prix** (avec badge si remise)
- 📊 **Stock disponible** :
  ```
  ✅ En stock (45 disponibles)
  ⚠️ Stock faible (3 restants)
  ❌ Rupture de stock
  ```

**Onglets :**
1. **Description** : Détails du produit
2. **Spécifications** : Caractéristiques techniques
3. **Attributs** : Variantes disponibles

#### Ajouter au panier

1. Sélectionnez la **quantité** (spinner)
2. Choisissez les **variantes** si disponibles :
   ```
   Couleur : [Noir] [Blanc] [Bleu]
   Mémoire : [64GB] [128GB] [256GB]
   ```
3. Cliquez sur **Ajouter au Panier** 🛒
4. Notification de confirmation
5. Compteur panier mis à jour

#### Ajouter à la wishlist ❤️

- Cliquez sur l'icône cœur
- Produit sauvegardé pour plus tard
- Accessible depuis `/wishlist`

### 3.5. Panier d'Achat

**URL :** `/cart`

#### Gérer le panier

**Articles listés :**
```
┌──────────────────────────────────────────────────┐
│ Produit A          │ 899.000 TND │ Qté: [2] │ 🗑️ │
│ Produit B          │ 450.000 TND │ Qté: [1] │ 🗑️ │
│ Produit C          │ 250.000 TND │ Qté: [3] │ 🗑️ │
└──────────────────────────────────────────────────┘
```

**Actions possibles :**
- ➕➖ **Modifier quantité** : Spinner interactif
- 🗑️ **Retirer article** : Confirmation requise
- 🧹 **Vider panier** : Tout supprimer

#### Résumé financier (sidebar)

```
┌─────────────────────────────────┐
│ Sous-total HT : 3,048.000 TND  │
│ TVA (19%) :       579.120 TND  │
│ ═══════════════════════════════ │
│ Total TTC :     3,627.120 TND  │
└─────────────────────────────────┘
```

#### Appliquer un code promo

1. Champ **Code Promo**
2. Entrez le code (ex: `PROMO10`)
3. Cliquez sur **Appliquer**
4. La remise s'applique automatiquement

#### Finaliser la commande

1. Vérifiez les articles et quantités
2. Cliquez sur **Valider la Commande** 🛒
3. Confirmation :
   ```
   ✅ Commande créée avec succès !
   N° ORD-202510-0085

   Total : 3,627.120 TND
   Livraison estimée : 3-5 jours
   ```
4. Redirection vers `/orders/{order}`

### 3.6. Mes Commandes

**URL :** `/orders`

#### Consulter l'historique

**Filtres :**
- Par statut
- Par période
- Par montant

**Liste des commandes :**
```
┌───────────────┬──────────┬────────────┬─────────────┬──────────┐
│ N° Commande   │ Date     │ Articles   │ Total       │ Statut   │
├───────────────┼──────────┼────────────┼─────────────┼──────────┤
│ ORD-202510-85 │ 07/10/25 │ 3 articles │ 3,627.12 TD │ 🔄 Trait.│
│ ORD-202510-72 │ 05/10/25 │ 2 articles │ 1,850.00 TD │ ✅ Livrée│
│ ORD-202509-58 │ 28/09/25 │ 5 articles │ 4,200.50 TD │ ✅ Livrée│
└───────────────┴──────────┴────────────┴─────────────┴──────────┘
```

#### Détails d'une commande

**URL :** `/orders/{order_number}`

**Informations affichées :**
- 📝 Numéro et date de commande
- 👤 Informations client
- 📦 Liste des articles avec photos
- 💰 Résumé financier détaillé
- 📍 Adresse de livraison
- 🚚 Statut de livraison

**Timeline de la commande :**
```
✅ 07/10/2025 14:30 - Commande créée
✅ 07/10/2025 16:00 - Commande validée
🔄 07/10/2025 17:00 - En cours de préparation
⏳ 08/10/2025 09:00 - Expédiée
⏳ 10/10/2025 -- Livraison prévue
```

**Actions disponibles :**
- 📄 **Voir facture** (si générée)
- 🔙 **Demander retour** (si éligible)
- 💬 **Contacter support**
- 📥 **Télécharger bon de commande**

### 3.7. Créer un Devis

**URL :** `/quotes/create`

#### Formulaire de devis

**Section Client :**
```
Vendeur : Ahmed Ben Ali (rempli automatiquement)
Client : Société XYZABC
Email : contact@xyzabc.com
Téléphone : +216 XX XXX XXX
Validité : 30 jours (date d'expiration)
```

**Section Articles :**
1. Cliquez sur **+ Ajouter un article**
2. Pour chaque ligne :
   ```
   Produit : [Sélectionnez depuis liste]
   Description : [Rempli automatiquement]
   Quantité : [1]
   Prix unitaire : [899.000 TND]
   Remise : [10%]
   Total ligne : [809.100 TND] (calculé auto)
   ```
3. Bouton **+ Ajouter ligne** pour plus d'articles

**JavaScript automatique :**
- Calcul en temps réel des totaux
- Remise par ligne
- TVA 19%
- Total général actualisé

**Sidebar récapitulatif :**
```
┌──────────────────────────────────┐
│ Sous-total HT :    2,500.000 TND │
│ Remise totale :     -250.000 TND │
│ Sous-total remisé: 2,250.000 TND │
│ TVA (19%) :          427.500 TND │
│ ══════════════════════════════   │
│ TOTAL TTC :        2,677.500 TND │
└──────────────────────────────────┘
```

**Sections optionnelles :**
- **Notes internes** : Commentaires pour l'admin
- **Conditions générales** : Termes du devis

**Actions :**
- 📝 **Sauvegarder brouillon** : Pour compléter plus tard
- 📧 **Créer et envoyer** : Soumettre pour validation admin

#### Workflow du devis

```
1. Draft → Vendeur crée le devis
2. Sent → Admin approuve et envoie
3. Viewed → Client consulte
4. Accepted → Client accepte
5. Converted → Transformation en commande
```

### 3.8. Mes Devis

**URL :** `/quotes`

#### Consulter les devis

**Filtres :**
- Par statut (draft, sent, accepted, rejected)
- Par période
- Par client

**Liste :**
```
┌──────────────┬──────────┬─────────────────┬─────────────┬──────────┐
│ N° Devis     │ Date     │ Client          │ Total       │ Statut   │
├──────────────┼──────────┼─────────────────┼─────────────┼──────────┤
│ QT-202510-12 │ 07/10/25 │ Société ABC     │ 2,677.50 TD │ 📧 Envoyé│
│ QT-202510-08 │ 05/10/25 │ Entreprise XYZ  │ 5,200.00 TD │ ✅ Accepté│
│ QT-202509-22 │ 28/09/25 │ Client Test     │ 1,450.00 TD │ ❌ Refusé│
└──────────────┴──────────┴─────────────────┴─────────────┴──────────┘
```

#### Actions sur un devis

- 👁️ **Voir détails**
- ✏️ **Modifier** (si draft)
- 📄 **Télécharger PDF**
- 📧 **Renvoyer** (si expiré)
- ✅ **Accepter** (action client simulée)
- ❌ **Rejeter**
- 🛒 **Convertir en commande** (si accepté)

### 3.9. Mes Factures

**URL :** `/invoices`

#### Vue d'ensemble

**Statistiques rapides :**
```
┌───────────────┬──────────────┬────────────┬──────────┐
│ ⏳ En attente │ ✅ Payées    │ ⚠️ Retard  │ 📄 Total │
│      8        │     42       │     2      │    52    │
└───────────────┴──────────────┴────────────┴──────────┘
```

**Filtres :**
- Recherche par N° facture ou commande
- Par statut (pending, paid, overdue, cancelled)
- Date début / Date fin

**Liste des factures :**
```
┌──────────────┬──────────────┬──────────┬──────────┬─────────────┬──────────┐
│ N° Facture   │ N° Commande  │ Date     │ Échéance │ Total TTC   │ Statut   │
├──────────────┼──────────────┼──────────┼──────────┼─────────────┼──────────┤
│ INV-202510-23│ ORD-202510-85│ 07/10/25 │ 06/11/25 │ 3,627.12 TD │ ⏳ Attente│
│ INV-202510-20│ ORD-202510-72│ 05/10/25 │ 04/11/25 │ 1,850.00 TD │ ✅ Payée │
│ INV-202509-15│ ORD-202509-58│ 28/09/25 │ 28/10/25 │ 4,200.50 TD │ ⚠️ Retard│
└──────────────┴──────────────┴──────────┴──────────┴─────────────┴──────────┘
```

#### Détails d'une facture

**URL :** `/invoices/{id}`

**Sections :**
1. **En-tête** :
   - N° facture
   - Statut avec badge coloré
   - Date d'émission

2. **Commande associée** :
   - N° commande (lien cliquable)
   - Date de commande
   - Statut commande
   - Nombre d'articles

3. **Articles facturés** :
   ```
   ┌──────────────────────────────────────────────────────┐
   │ [img] Produit A     │ Qté: 2 │ 899.00 │ 1,798.00 TD │
   │ [img] Produit B     │ Qté: 1 │ 450.00 │   450.00 TD │
   │ [img] Produit C     │ Qté: 3 │ 250.00 │   750.00 TD │
   └──────────────────────────────────────────────────────┘
   ```

4. **Résumé financier** (sidebar) :
   ```
   Sous-total HT :    2,520.168 TND
   TVA (19%) :          478.832 TND
   ═══════════════════════════════
   TOTAL TTC :        2,999.000 TND
   ```

5. **Dates importantes** :
   ```
   📅 Émission : 07/10/2025
   ⏰ Échéance : 06/11/2025
   ✉️ Envoyée : 07/10/2025 16:30
   ✅ Payée : -- (si applicable)
   ```

6. **Alertes** :
   - ⏳ **Paiement en attente** : Veuillez régler avant échéance
   - ✅ **Facture payée** : Merci pour votre paiement
   - ⚠️ **En retard** : Veuillez régulariser

**Actions :**
- 📄 **Voir PDF** : Ouvrir dans navigateur
- 💾 **Télécharger PDF** : Sauvegarder localement
- 🖨️ **Imprimer** : Impression directe
- 📧 **Demander renvoi** : Contact admin

#### Export CSV

1. Bouton **Export CSV**
2. Fichier `invoices_2025-10-07.csv` téléchargé
3. Données complètes pour comptabilité

### 3.10. Wishlist (Liste de Souhaits)

**URL :** `/wishlist`

#### Gérer la wishlist

**Fonctionnalités :**
- ❤️ **Produits sauvegardés** pour achat ultérieur
- 📝 **Notes personnelles** par produit
- 🎯 **Priorités** (haute, moyenne, basse)
- 🛒 **Déplacer vers panier** en 1 clic

**Actions groupées :**
- Sélectionner plusieurs produits
- Ajouter tous au panier
- Supprimer la sélection

### 3.11. Retours & SAV

**URL :** `/returns`

#### Demander un retour

1. Cliquez sur **+ Nouvelle Demande**
2. Sélectionnez la **commande concernée**
3. Choisissez le(s) **produit(s)** à retourner
4. Formulaire :
   ```
   Raison du retour :
   ○ Produit défectueux
   ○ Produit endommagé
   ○ Erreur de commande
   ○ Produit non conforme
   ○ Autre (précisez)

   Description détaillée :
   [Décrivez le problème...]

   État du produit :
   ○ Neuf / Non ouvert
   ○ Ouvert / Utilisé
   ○ Défectueux
   ○ Endommagé

   Photos : [Upload jusqu'à 5 photos]
   ```

5. **Soumettre la demande**
6. N° RMA généré : `RMA-202510-0008`

#### Suivre une demande

**Statuts possibles :**
```
⏳ Pending → En attente validation admin
✅ Approved → Retour autorisé, envoyez le produit
📦 Received → Produit reçu au SAV, en cours d'analyse
💰 Refunded → Remboursement effectué
🔄 Replaced → Produit de remplacement envoyé
✅ Completed → Dossier clôturé
❌ Rejected → Demande refusée (avec justification)
```

**Informations affichées :**
- N° RMA
- Produit concerné
- Date de demande
- Statut actuel
- Historique des actions
- Instructions de retour

### 3.12. Messagerie

**URL :** `/messages`

#### Interface de messagerie

**Conversations :**
- Liste des discussions avec admin
- Badge compteur de non-lus
- Dernier message prévisualisé

**Envoyer un message :**
1. Cliquez sur **Nouveau Message**
2. Objet
3. Message
4. **Envoyer**

**Recevoir :**
- 🔔 Notification temps réel
- Son de notification (optionnel)
- Badge sur l'icône

### 3.13. Mon Profil

**URL :** `/profile` (à implémenter)

**Informations modifiables :**
- Nom et prénom
- Email
- Téléphone
- Photo de profil
- Mot de passe
- Préférences de notification

### 3.14. Adresses de Livraison

**URL :** `/addresses`

#### Gérer les adresses

**Ajouter une adresse :**
```
Type : Entreprise / Domicile
Nom complet : Ahmed Ben Ali
Société : Société ABC
Adresse : 15 Avenue Habib Bourguiba
Complément : Appartement 5, 2ème étage
Code postal : 1000
Ville : Tunis
Pays : Tunisie
Téléphone : +216 XX XXX XXX
```

**Actions :**
- ✏️ Modifier
- 🗑️ Supprimer
- ⭐ Définir par défaut

---

## 🎨 4. Fonctionnalités Avancées {#avancees}

### 4.1. Mode Sombre / Clair

**Activation :**
1. Icône lune/soleil en haut à droite
2. Toggle pour changer de thème
3. Préférence sauvegardée en localStorage

### 4.2. Multi-Langues

**Langues disponibles :**
- 🇫🇷 Français (par défaut)
- 🇬🇧 English
- 🇸🇦 العربية (RTL supporté)

**Changer de langue :**
1. Sélecteur dans la sidebar
2. Choix de la langue
3. Rechargement automatique

### 4.3. Notifications

**Types de notifications :**
- 🔔 **Système** : Mises à jour, maintenance
- 📦 **Commandes** : Changement de statut
- 💬 **Messages** : Nouveau message reçu
- 🧾 **Factures** : Facture générée, échéance proche
- ✅ **Devis** : Accepté, refusé, expiré

**Préférences :**
- Email : Oui/Non
- Push navigateur : Oui/Non
- SMS : Oui/Non (si configuré)

### 4.4. Recherche Globale

**Raccourci clavier :** `Ctrl + K` ou `Cmd + K`

**Recherche rapide :**
- 📦 Produits (nom, référence)
- 🛒 Commandes (numéro)
- 🧾 Factures (numéro)
- 📝 Devis (numéro)
- 👤 Clients (nom, email)

### 4.5. Export & Import

**Formats supportés :**
- **CSV** : Excel compatible
- **JSON** : Pour intégrations
- **PDF** : Documents imprimables
- **XML** : Pour ERP

**Données exportables :**
- Produits (catalogue complet)
- Commandes (avec détails)
- Factures (comptabilité)
- Clients (CRM)
- Stocks (inventaire)

### 4.6. API REST

**Base URL :** `http://127.0.0.1:8001/api`

**Documentation complète :** Voir `API_DOCUMENTATION.md`

**Endpoints principaux :**
```
POST   /api/auth/login
POST   /api/auth/register
GET    /api/products
POST   /api/cart/add
POST   /api/orders
GET    /api/invoices
```

**Authentification :** Laravel Sanctum (Bearer Token)

### 4.7. Raccourcis Clavier

**Navigation :**
- `Ctrl + K` : Recherche globale
- `Ctrl + P` : Aller au panier
- `Ctrl + O` : Mes commandes
- `Ctrl + D` : Dashboard

**Actions :**
- `Alt + N` : Nouveau (produit, commande, etc.)
- `Alt + E` : Éditer
- `Alt + S` : Sauvegarder
- `Esc` : Annuler / Fermer modal

### 4.8. Quick Order (Commande Rapide)

**URL :** `/quick-order` (à implémenter)

**Fonctionnalité :**
1. Saisie rapide de références
2. Format : `REF001:10, REF002:5, REF003:20`
3. Validation automatique du stock
4. Ajout direct au panier
5. Commande en 1 clic

### 4.9. Statistiques Personnelles (Vendeur)

**Métriques disponibles :**
- 📊 CA par mois (12 derniers mois)
- 🏆 Top 5 produits achetés
- 💰 Économies réalisées (remises)
- 📦 Moyenne de commande
- ⭐ Produits favoris

### 4.10. Rapports Personnalisés

**Créer un rapport custom :**
1. Sélectionner les données
2. Choisir les colonnes
3. Appliquer des filtres
4. Générer le rapport
5. Planifier l'envoi automatique (email)

---

## 🔧 Astuces & Bonnes Pratiques

### Pour les SuperAdmins

✅ **À faire :**
- Surveiller l'utilisation des quotas régulièrement
- Activer les alertes pour dépassements
- Faire des backups quotidiens
- Monitorer les performances

❌ **À éviter :**
- Supprimer un tenant sans backup
- Modifier manuellement la base de données
- Ignorer les alertes de sécurité

### Pour les Grossistes

✅ **À faire :**
- Mettre à jour les prix régulièrement
- Vérifier le stock hebdomadairement
- Traiter les commandes rapidement
- Répondre aux messages vendeurs

❌ **À éviter :**
- Laisser des commandes en pending trop longtemps
- Ignorer les alertes de stock
- Ne pas générer les factures

### Pour les Vendeurs

✅ **À faire :**
- Vérifier la disponibilité avant de commander
- Utiliser la wishlist pour pré-sélection
- Créer des devis pour gros montants
- Suivre l'état de vos commandes

❌ **À éviter :**
- Commander sans vérifier le stock
- Ignorer les factures impayées
- Ne pas mettre à jour les adresses

---

## 📞 Support & Assistance

### Contact

**Email :** support@b2bplatform.com
**Téléphone :** +216 XX XXX XXX
**Horaires :** Lun-Ven 9h-18h

### Ressources

- 📖 **Documentation** : `/docs`
- ❓ **FAQ** : `/faq`
- 🎥 **Tutoriels vidéo** : `/tutorials`
- 💬 **Chat en direct** : Icône en bas à droite

### Signaler un Bug

1. Menu utilisateur → **Signaler un problème**
2. Décrivez le bug
3. Joignez une capture d'écran
4. **Envoyer**

Équipe de support notifiée immédiatement.

---

## 🎓 Formation & Ressources

### Vidéos Tutorielles

1. **Introduction à la plateforme** (10 min)
2. **Passer votre première commande** (5 min)
3. **Gérer le catalogue produits** (15 min)
4. **Créer et suivre un devis** (8 min)
5. **Utiliser les rapports** (12 min)

### Guides PDF

- Guide Vendeur (20 pages)
- Guide Grossiste (35 pages)
- Guide SuperAdmin (45 pages)
- API Developer Guide (60 pages)

### Webinaires

**Tous les mardis à 14h :**
- Nouveautés de la plateforme
- Trucs et astuces
- Q&A en direct

---

## 🔐 Sécurité & Confidentialité

### Bonnes Pratiques

✅ Utilisez un mot de passe fort (min 8 caractères)
✅ Activez l'authentification à deux facteurs
✅ Ne partagez jamais vos identifiants
✅ Déconnectez-vous sur les postes partagés
✅ Vérifiez l'URL avant de vous connecter

### Politique de Confidentialité

- Vos données sont chiffrées (SSL/TLS)
- Isolation parfaite entre tenants
- Conformité RGPD
- Backups quotidiens automatiques
- Logs d'audit complets

---

## 📈 Mises à Jour & Nouveautés

### Dernières Mises à Jour

**Version 2.5.0 - Octobre 2025**
- ✨ Système de factures PDF
- ✨ Rapports analytics avancés
- ✨ Multi-devises (7 devises)
- ✨ Multi-langues (FR/EN/AR)
- ✨ Intégrations ERP
- 🐛 Corrections de bugs
- ⚡ Optimisations performances

**À venir :**
- 📱 Application mobile (iOS/Android)
- 🤖 Recommandations IA
- 🔄 Commandes récurrentes
- 🎨 Variantes produits avancées
- 📊 BI (Business Intelligence) intégré

---

## ✅ Checklist de Démarrage Rapide

### SuperAdmin

- [ ] Se connecter avec les identifiants fournis
- [ ] Créer le premier tenant
- [ ] Configurer les plans tarifaires
- [ ] Définir les quotas
- [ ] Activer les exports

### Grossiste

- [ ] Se connecter et explorer le dashboard
- [ ] Créer 5 vendeurs minimum
- [ ] Créer 2-3 groupes clients
- [ ] Importer le catalogue produits
- [ ] Définir les prix personnalisés
- [ ] Configurer les devises
- [ ] Tester une commande complète

### Vendeur

- [ ] Se connecter et visiter le dashboard
- [ ] Parcourir le catalogue
- [ ] Ajouter produits à la wishlist
- [ ] Créer un panier test
- [ ] Passer une première commande
- [ ] Créer un devis
- [ ] Consulter les factures

---

**🎉 Félicitations ! Vous êtes maintenant prêt à utiliser la plateforme B2B Multi-Tenant !**

**Besoin d'aide ?** Consultez la documentation ou contactez le support.

---

**Date de création :** 07 Octobre 2025
**Version du tutoriel :** 1.0
**Application version :** 2.5.0
**Auteur :** Équipe B2B Platform
