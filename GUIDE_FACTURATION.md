# 📘 Guide d'Utilisation - Système de Facturation

## 📋 Table des Matières
1. [Accéder au système de facturation](#accès)
2. [Générer une facture](#génération)
3. [Gérer les factures](#gestion)
4. [Exporter les factures](#export)
5. [FAQ](#faq)

---

## 🔐 1. Accéder au système de facturation {#accès}

### **Pour les Administrateurs/Grossistes:**

1. Connectez-vous à l'interface admin: `http://127.0.0.1:8001/admin`
2. Dans le menu latéral, cliquez sur **"Factures"**
   - Icône: 💵 File Invoice Dollar
   - Position: Entre "Commandes" et "Retours & SAV"
3. Vous arriverez sur le tableau de bord des factures

### **Badge de notification:**
- Un badge jaune indique le nombre de factures en attente de paiement
- Exemple: `Factures [3]` = 3 factures à traiter

---

## 📝 2. Générer une facture {#génération}

### **Méthode 1: Depuis une commande (Recommandé)**

1. **Accéder à la commande:**
   - Allez dans `Admin → Commandes`
   - Cliquez sur une commande pour voir les détails

2. **Générer la facture:**
   - En haut à droite, cliquez sur le bouton **"Générer Facture"**
   - Une confirmation s'affiche : "Générer une facture pour cette commande ?"
   - Cliquez sur **OK**

3. **Résultat:**
   - Une facture est créée automatiquement
   - Numérotation automatique: `INV-202510-0001`
   - Statut initial: **En attente** (pending)
   - Échéance: **30 jours** après la date de génération
   - Le bouton devient **"Voir la facture"** (en vert)

### **Méthode 2: Depuis la liste des factures**

1. Allez dans `Admin → Factures`
2. Cliquez sur le bouton **"+ Nouvelle Facture"** (si disponible)
3. Remplissez le formulaire
4. Enregistrez

---

## 📊 3. Gérer les factures {#gestion}

### **3.1 Tableau de bord factures**

**Statistiques affichées:**
- 📄 **Total Factures** - Nombre total de factures créées
- ⏰ **En Attente** - Factures non payées + montant total
- ✅ **Payées** - Nombre de factures réglées
- 💰 **Revenu Total** - Somme des factures payées

### **3.2 Filtrer les factures**

Utilisez les filtres pour trouver rapidement une facture:

| Filtre | Description | Exemples |
|--------|-------------|----------|
| **Recherche** | N° facture, N° commande, Client | `INV-202510-0001`, `ahmed@vendeur1.com` |
| **Statut** | État de la facture | Pending, Paid, Overdue, Cancelled |
| **Date début** | À partir de cette date | `01/10/2025` |
| **Date fin** | Jusqu'à cette date | `31/10/2025` |

**Boutons:**
- 🔍 **Rechercher** - Appliquer les filtres
- 🔄 **Réinitialiser** - Effacer tous les filtres

### **3.3 Actions sur une facture**

Dans le tableau des factures, vous pouvez:

| Action | Icône | Description |
|--------|-------|-------------|
| **Voir** | 👁️ | Afficher les détails complets |
| **Marquer comme payée** | ✅ | Changer le statut en "Payée" (si pending) |

### **3.4 Détails d'une facture**

**Informations affichées:**
- **Header:** Nom entreprise, coordonnées, logo (personnalisable)
- **Métadonnées:** N° facture, dates, statut
- **Client:** Nom, email, téléphone, société
- **Commande liée:** N° commande, date, statut
- **Articles:** Tableau détaillé (produit, quantité, prix, total)
- **Totaux:** Sous-total HT, TVA 19%, Total TTC
- **Notes:** Notes internes ou mentions légales

**Actions disponibles:**
- 🖨️ **Imprimer** - Version imprimable de la facture
- ✅ **Marquer comme payée** - Si facture en attente
- 📧 **Marquer comme envoyée** - Tracer l'envoi
- 🔄 **Changer statut** - Dropdown pour modifier manuellement

### **3.5 Statuts des factures**

| Statut | Badge | Description |
|--------|-------|-------------|
| **Pending** | 🟡 Jaune | En attente de paiement |
| **Paid** | 🟢 Vert | Facture payée |
| **Overdue** | 🔴 Rouge | Date d'échéance dépassée |
| **Cancelled** | ⚫ Gris | Facture annulée |

**Indicateurs automatiques:**
- Si date d'échéance dépassée ET statut ≠ Paid → Badge **"Retard"** rouge
- Après paiement → Affiche la date et heure exacte

---

## 📤 4. Exporter les factures {#export}

### **4.1 Export CSV pour comptabilité**

1. **Accéder à l'export:**
   - Depuis `Admin → Factures`
   - Cliquez sur **"Exporter CSV"** (en haut à droite)

2. **Filtres optionnels:**
   - Vous pouvez filtrer avant d'exporter
   - Exemple: Exporter uniquement les factures de septembre 2025

3. **Résultat:**
   - Fichier CSV téléchargé: `factures_2025-10-07_143045.csv`
   - Format: UTF-8 avec BOM (compatible Excel)
   - Délimiteur: `;` (point-virgule pour Excel français)

### **4.2 Colonnes du CSV**

| Colonne | Exemple | Format |
|---------|---------|--------|
| Numéro Facture | INV-202510-0001 | Texte |
| Numéro Commande | ORD-202510-0001 | Texte |
| Client | Ahmed Vendeur | Texte |
| Email | ahmed@vendeur1.com | Texte |
| Date Facture | 07/10/2025 | DD/MM/YYYY |
| Date Échéance | 06/11/2025 | DD/MM/YYYY |
| Sous-total (TND) | 1 500,00 | Nombre (virgule décimale) |
| TVA (TND) | 285,00 | Nombre (virgule décimale) |
| Total (TND) | 1 785,00 | Nombre (virgule décimale) |
| Statut | Paid | Texte |
| Date Paiement | 10/10/2025 14:30 | DD/MM/YYYY HH:MM ou "Non payée" |
| Date Envoi | 07/10/2025 16:45 | DD/MM/YYYY HH:MM ou "Non envoyée" |

### **4.3 Utilisation dans Excel**

1. Ouvrir Excel
2. Fichier → Ouvrir → Sélectionner le CSV
3. Les données sont correctement formatées (UTF-8 préservé)
4. Vous pouvez créer des tableaux croisés dynamiques

---

## 🔧 5. Workflow recommandé {#workflow}

### **Processus standard:**

```
1. Commande validée
   ↓
2. [Admin] Générer facture depuis commande
   ↓
3. Facture créée (statut: Pending)
   ↓
4. [Admin] Marquer comme envoyée (optionnel)
   ↓
5. Client paie la facture
   ↓
6. [Admin] Marquer comme payée
   ↓
7. Facture archivée (statut: Paid)
```

### **Cas particuliers:**

**Facture en retard:**
- Si échéance dépassée → Système affiche automatiquement "En retard"
- Action: Relancer le client OU changer statut en "Overdue"

**Facture annulée:**
- Si commande annulée → Changer statut en "Cancelled"
- La facture reste dans le système pour traçabilité

---

## ❓ 6. FAQ {#faq}

### **Q: Comment personnaliser le template de facture ?**
**R:** Modifiez le fichier `resources/views/invoices/pdf.blade.php`
- Ajoutez votre logo
- Changez les couleurs (variable `#2563eb` pour le bleu principal)
- Modifiez les informations entreprise

### **Q: Puis-je supprimer une facture ?**
**R:** Non, pour des raisons légales et de traçabilité. Vous pouvez:
- La marquer comme "Cancelled" (annulée)
- Ajouter une note expliquant la raison

### **Q: Comment changer la durée d'échéance par défaut ?**
**R:** Dans `AdminInvoiceController.php`, ligne 96:
```php
'due_date' => now()->addDays(30), // Changez 30 par le nombre de jours souhaité
```

### **Q: La numérotation saute un numéro, est-ce normal ?**
**R:** Oui, si une tentative de création échoue, le numéro suivant est utilisé. C'est normal.

### **Q: Comment générer des factures en masse ?**
**R:** Actuellement non supporté. Prochaine version inclura:
- Génération par lot depuis liste de commandes
- Génération automatique à validation de commande

### **Q: Puis-je envoyer la facture par email automatiquement ?**
**R:** Pas encore implémenté. Roadmap:
1. Installation package mail
2. Création template email
3. Envoi automatique avec PDF en attachement

### **Q: Comment ajouter une TVA différente ?**
**R:** Actuellement fixée à 19%. Pour modifier:
1. Ouvrir `AdminInvoiceController.php`
2. Ligne 94: `'tax' => $order->tax`
3. Le taux est hérité de la commande

### **Q: Les factures sont-elles conformes légalement ?**
**R:** Le système génère des factures avec:
- ✅ Numérotation séquentielle
- ✅ Informations obligatoires (dates, montants, TVA)
- ⚠️ À compléter: Logo, mentions légales spécifiques à votre pays

**Important:** Consultez votre comptable pour valider la conformité légale dans votre juridiction.

---

## 📞 Support

**Problème technique ?**
- Vérifiez les logs Laravel: `storage/logs/laravel.log`
- Base de données: Table `invoices` et `orders`

**Besoin d'aide ?**
- Documentation technique: `AMELIORATIONS_07_OCTOBRE_2025.md`
- Architecture: `app/Http/Controllers/Admin/AdminInvoiceController.php`

---

## 🎯 Raccourcis Clavier (à venir)

| Action | Raccourci |
|--------|-----------|
| Nouvelle facture | `Ctrl + N` |
| Rechercher | `Ctrl + F` |
| Exporter | `Ctrl + E` |
| Imprimer | `Ctrl + P` |

---

## 📈 Prochaines Fonctionnalités

- [ ] Génération PDF automatique (DomPDF)
- [ ] Envoi email avec template professionnel
- [ ] Paiement en ligne (Stripe/PayPal)
- [ ] Factures récurrentes (abonnements)
- [ ] Relances automatiques
- [ ] Multi-devises sur factures
- [ ] Génération avoir (credit notes)
- [ ] Signature électronique
- [ ] QR code paiement

---

**Version du guide:** 1.0
**Dernière mise à jour:** 07 Octobre 2025
**Système:** B2B Platform v1.9.0
