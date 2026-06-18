-- Run this in phpMyAdmin or MySQL CLI to create the wishlist table
-- Database: mysticakedb2

USE mysticakedb2;

CREATE TABLE IF NOT EXISTS `wishlist` (
  `id_wishlist` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_wishlist`),
  UNIQUE KEY `wishlist_id_user_id_product_unique` (`id_user`,`id_product`),
  KEY `wishlist_id_user_foreign` (`id_user`),
  KEY `wishlist_id_product_foreign` (`id_product`),
  CONSTRAINT `wishlist_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE,
  CONSTRAINT `wishlist_id_product_foreign` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Also insert into migrations table so Laravel knows it's been run
INSERT IGNORE INTO `migrations` (`migration`, `batch`)
SELECT '2026_06_17_000001_create_wishlist_table', MAX(batch) + 1
FROM migrations
WHERE NOT EXISTS (
    SELECT 1 FROM migrations WHERE migration = '2026_06_17_000001_create_wishlist_table'
);
