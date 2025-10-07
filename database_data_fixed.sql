-- ================================================
-- Donnees de test B2B Platform - Version corrigee
-- ================================================

-- Desactiver les contraintes de cles etrangeres
SET FOREIGN_KEY_CHECKS=0;

-- Vider les tables dans le bon ordre (enfants avant parents)
DELETE FROM `promotion_users`;
DELETE FROM `promotion_products`;
DELETE FROM `promotions`;
DELETE FROM `order_items`;
DELETE FROM `orders`;
DELETE FROM `custom_prices`;
DELETE FROM `customer_group_users`;
DELETE FROM `customer_groups`;
DELETE FROM `products`;
DELETE FROM `categories`;
DELETE FROM `messages`;
DELETE FROM `notifications`;
DELETE FROM `users`;

-- Remettre les auto_increment à 1
ALTER TABLE `users` AUTO_INCREMENT = 1;
ALTER TABLE `categories` AUTO_INCREMENT = 1;
ALTER TABLE `products` AUTO_INCREMENT = 1;
ALTER TABLE `customer_groups` AUTO_INCREMENT = 1;
ALTER TABLE `custom_prices` AUTO_INCREMENT = 1;
ALTER TABLE `orders` AUTO_INCREMENT = 1;
ALTER TABLE `order_items` AUTO_INCREMENT = 1;
ALTER TABLE `messages` AUTO_INCREMENT = 1;
ALTER TABLE `promotions` AUTO_INCREMENT = 1;
ALTER TABLE `promotion_products` AUTO_INCREMENT = 1;
ALTER TABLE `promotion_users` AUTO_INCREMENT = 1;
ALTER TABLE `customer_group_users` AUTO_INCREMENT = 1;

-- Insertion des utilisateurs
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `company_name`, `phone`, `address`, `city`, `postal_code`, `is_active`, `preferred_language`, `created_at`, `updated_at`) VALUES
(1, 'Grossiste Principal', 'grossiste@b2b.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'grossiste', 'Societe de Gros', '+216 12 345 678', '123 Rue des Grossistes', 'Tunis', '1000', 1, 'fr', NOW(), NOW()),
(2, 'Ahmed Ben Mohamed', 'ahmed@vendeur1.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'vendeur', 'Magasin Ahmed', '+216 20 123 456', 'Adresse Magasin Ahmed', 'Sfax', '1000', 1, 'fr', NOW(), NOW()),
(3, 'Fatma Trabelsi', 'fatma@vendeur2.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'vendeur', 'Boutique Fatma', '+216 21 123 456', 'Adresse Boutique Fatma', 'Sousse', '1100', 1, 'ar', NOW(), NOW()),
(4, 'Mohamed Ali', 'ali@vendeur3.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'vendeur', 'Epicerie Ali', '+216 22 123 456', 'Adresse Epicerie Ali', 'Monastir', '1200', 1, 'fr', NOW(), NOW()),
(5, 'Salma Karray', 'salma@vendeur4.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'vendeur', 'Commerce Salma', '+216 23 123 456', 'Adresse Commerce Salma', 'Gabes', '1300', 1, 'ar', NOW(), NOW());

-- Insertion des categories principales
INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Alimentation', 'alimentation', 'Produits alimentaires divers', 1, 1, NOW(), NOW()),
(2, 'Hygiene & Beaute', 'hygiene-beaute', 'Produits d\'hygiene et de beaute', 2, 1, NOW(), NOW()),
(3, 'Entretien', 'entretien', 'Produits d\'entretien menager', 3, 1, NOW(), NOW()),
(4, 'Electronique', 'electronique', 'Appareils electroniques', 4, 1, NOW(), NOW());

-- Insertion des sous-categories
INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `parent_id`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(5, 'Epicerie salee', 'epicerie-salee', NULL, 1, 1, 1, NOW(), NOW()),
(6, 'Epicerie sucree', 'epicerie-sucree', NULL, 1, 2, 1, NOW(), NOW()),
(7, 'Conserves', 'conserves', NULL, 1, 3, 1, NOW(), NOW()),
(8, 'Boissons', 'boissons', NULL, 1, 4, 1, NOW(), NOW()),
(9, 'Soins du corps', 'soins-corps', NULL, 2, 1, 1, NOW(), NOW()),
(10, 'Soins du visage', 'soins-visage', NULL, 2, 2, 1, NOW(), NOW()),
(11, 'Parfumerie', 'parfumerie', NULL, 2, 3, 1, NOW(), NOW()),
(12, 'Nettoyage sols', 'nettoyage-sols', NULL, 3, 1, 1, NOW(), NOW()),
(13, 'Vaisselle', 'vaisselle', NULL, 3, 2, 1, NOW(), NOW()),
(14, 'Lessive', 'lessive', NULL, 3, 3, 1, NOW(), NOW()),
(15, 'Telephones', 'telephones', NULL, 4, 1, 1, NOW(), NOW()),
(16, 'Accessoires', 'accessoires', NULL, 4, 2, 1, NOW(), NOW());

-- Insertion des produits
INSERT INTO `products` (`id`, `name`, `sku`, `description`, `category_id`, `brand`, `unit`, `base_price`, `stock_quantity`, `min_order_quantity`, `order_multiple`, `stock_alert_threshold`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Riz Basmati 1kg', 'RIZ-BAS-1KG', 'Riz basmati de qualite superieure, grain long', 5, 'Premium Rice', 'kg', 8.500, 150, 10, 10, 10, 1, NOW(), NOW()),
(2, 'Huile d\'olive extra vierge 500ml', 'HUILE-OLV-500', 'Huile d\'olive extra vierge pressee a froid', 5, 'Mediterranee', 'bouteille', 12.750, 80, 6, 6, 10, 1, NOW(), NOW()),
(3, 'Pates spaghetti 500g', 'PATE-SPA-500', 'Spaghetti de ble dur, cuisson 8-10 minutes', 5, 'Pasta Bella', 'paquet', 2.200, 200, 12, 12, 10, 1, NOW(), NOW()),
(4, 'Chocolat noir 70% 100g', 'CHOC-NOIR-100', 'Chocolat noir 70% cacao, tablette premium', 6, 'Cacao Royal', 'tablette', 4.500, 60, 20, 20, 10, 1, NOW(), NOW()),
(5, 'Miel naturel 500g', 'MIEL-NAT-500', 'Miel naturel de fleurs sauvages', 6, 'Miel Dore', 'pot', 18.000, 40, 6, 6, 10, 1, NOW(), NOW()),
(6, 'Tomates pelees en conserve 400g', 'TOM-PEL-400', 'Tomates pelees italiennes en conserve', 7, 'San Marzano', 'boite', 3.200, 120, 24, 24, 10, 1, NOW(), NOW()),
(7, 'Thon a l\'huile d\'olive 160g', 'THON-HUILE-160', 'Thon albacore a l\'huile d\'olive extra vierge', 7, 'Ocean Bleu', 'boite', 6.500, 90, 12, 12, 10, 1, NOW(), NOW()),
(8, 'Eau minerale 1.5L', 'EAU-MIN-1.5L', 'Eau minerale naturelle source de montagne', 8, 'Source Pure', 'bouteille', 0.800, 300, 12, 12, 10, 1, NOW(), NOW()),
(9, 'Jus d\'orange 1L', 'JUS-ORA-1L', 'Jus d\'orange 100% pur jus sans sucre ajoute', 8, 'Vitamine C', 'brick', 4.200, 75, 8, 8, 10, 1, NOW(), NOW()),
(10, 'Gel douche hydratant 250ml', 'GEL-DOU-250', 'Gel douche hydratant a l\'aloe vera', 9, 'Doux Soin', 'flacon', 7.500, 85, 12, 12, 10, 1, NOW(), NOW()),
(11, 'Shampooing tous cheveux 400ml', 'SHAM-TOUS-400', 'Shampooing pour tous types de cheveux', 9, 'Hair Care', 'flacon', 9.200, 70, 6, 6, 10, 1, NOW(), NOW()),
(12, 'Nettoyant sol multi-surfaces 1L', 'NET-SOL-1L', 'Nettoyant pour tous types de sols', 12, 'Clean Pro', 'bouteille', 5.800, 100, 8, 8, 10, 1, NOW(), NOW()),
(13, 'Smartphone Android 128GB', 'TEL-AND-128', 'Smartphone Android avec ecran 6.5", 128GB de stockage', 15, 'TechMobile', 'unite', 450.000, 25, 1, 1, 10, 1, NOW(), NOW());

-- Insertion des groupes de clients
INSERT INTO `customer_groups` (`id`, `name`, `description`, `discount_percentage`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'VIP', 'Clients VIP avec remise privilegiee', 15.00, 1, NOW(), NOW()),
(2, 'Grosses commandes', 'Clients avec volume d\'achat important', 10.00, 1, NOW(), NOW()),
(3, 'Partenaires privilegies', 'Partenaires commerciaux de longue date', 12.00, 1, NOW(), NOW()),
(4, 'Standard', 'Clients standard sans remise particuliere', 0.00, 1, NOW(), NOW());

-- Association des vendeurs aux groupes
INSERT INTO `customer_group_users` (`user_id`, `customer_group_id`, `created_at`, `updated_at`) VALUES
(2, 1, NOW(), NOW()), -- Ahmed VIP
(3, 2, NOW(), NOW()), -- Fatma Grosses commandes
(4, 3, NOW(), NOW()), -- Ali Partenaires
(5, 4, NOW(), NOW()); -- Salma Standard

-- Insertion de prix personnalises
INSERT INTO `custom_prices` (`product_id`, `user_id`, `price`, `min_quantity`, `valid_from`, `valid_until`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 2, 7.225, 1, '2024-01-01', '2024-12-31', 1, NOW(), NOW()), -- Riz pour Ahmed (15% reduction)
(2, 3, 10.200, 10, '2024-01-01', '2024-06-30', 1, NOW(), NOW()); -- Huile pour Fatma (20% reduction pour 10+)

-- Prix pour groupe VIP
INSERT INTO `custom_prices` (`product_id`, `customer_group_id`, `price`, `min_quantity`, `valid_from`, `valid_until`, `is_active`, `created_at`, `updated_at`) VALUES
(3, 1, 1.870, 1, '2024-01-01', '2024-12-31', 1, NOW(), NOW()), -- Pates pour VIP
(4, 1, 3.825, 1, '2024-01-01', '2024-12-31', 1, NOW(), NOW()), -- Chocolat pour VIP
(5, 1, 15.300, 1, '2024-01-01', '2024-12-31', 1, NOW(), NOW()); -- Miel pour VIP

-- Insertion de quelques messages de demonstration
INSERT INTO `messages` (`from_user_id`, `to_user_id`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(2, 1, 'Bonjour, j\'aimerais savoir si vous avez une promotion sur le riz ce mois-ci ?', 1, NOW() - INTERVAL 2 DAY, NOW() - INTERVAL 2 DAY),
(1, 2, 'Bonjour Ahmed, nous avons effectivement une promotion de 15% sur le riz pour les clients VIP comme vous !', 1, NOW() - INTERVAL 2 DAY, NOW() - INTERVAL 2 DAY),
(3, 1, 'Pouvez-vous me dire quand vous allez recevoir de nouveaux stocks d\'huile d\'olive ?', 0, NOW() - INTERVAL 1 DAY, NOW() - INTERVAL 1 DAY),
(4, 1, 'Merci pour la livraison rapide de ma derniere commande !', 0, NOW() - INTERVAL 5 HOUR, NOW() - INTERVAL 5 HOUR);

-- Insertion d'une promotion de demonstration
INSERT INTO `promotions` (`id`, `name`, `description`, `type`, `value`, `valid_from`, `valid_until`, `is_active`, `usage_limit`, `used_count`, `created_at`, `updated_at`) VALUES
(1, 'Promotion Rentrée 2024', 'Remise exceptionnelle pour la rentrée', 'percentage', 20.000, '2024-09-01', '2024-09-30', 1, 100, 5, NOW(), NOW());

-- Association promotion-produits
INSERT INTO `promotion_products` (`promotion_id`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 1, NOW(), NOW()), -- Promotion sur le riz
(1, 3, NOW(), NOW()); -- Promotion sur les pâtes

-- Association promotion-utilisateurs (pour Ahmed VIP)
INSERT INTO `promotion_users` (`promotion_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 2, NOW(), NOW()); -- Promotion accessible à Ahmed

-- Reactiver les contraintes de cles etrangeres
SET FOREIGN_KEY_CHECKS=1;

-- Message de confirmation
SELECT 'Base de donnees initialisee avec succes !' as 'Statut';
SELECT COUNT(*) as 'Nombre d\'utilisateurs' FROM users;
SELECT COUNT(*) as 'Nombre de produits' FROM products;
SELECT COUNT(*) as 'Nombre de categories' FROM categories;