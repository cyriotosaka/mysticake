-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Nov 2025 pada 16.03
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mysticakedb`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `address`
--

CREATE TABLE `address` (
  `id_address` int(11) NOT NULL,
  `full_address` text DEFAULT NULL,
  `map_point` varchar(255) DEFAULT NULL,
  `address_contact_number` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `address`
--

INSERT INTO `address` (`id_address`, `full_address`, `map_point`, `address_contact_number`) VALUES
(1, 'Jl. Mawar No 10', '-6.2000,106.8166', '08123456789');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cart`
--

CREATE TABLE `cart` (
  `id_cart` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `cart`
--

INSERT INTO `cart` (`id_cart`, `id_user`, `created_at`) VALUES
(1, 1, '2025-11-25 23:46:06'),
(2, 1, '2025-11-25 23:46:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cart_item`
--

CREATE TABLE `cart_item` (
  `id_cart_item` int(11) NOT NULL,
  `id_cart` int(11) DEFAULT NULL,
  `id_product` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `cart_item`
--

INSERT INTO `cart_item` (`id_cart_item`, `id_cart`, `id_product`, `quantity`) VALUES
(1, 1, 1, 2),
(2, 1, 1, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `chat`
--

CREATE TABLE `chat` (
  `id_chat` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_store` int(11) DEFAULT NULL,
  `id_order` int(11) DEFAULT NULL,
  `id_product` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `chat`
--

INSERT INTO `chat` (`id_chat`, `id_user`, `id_store`, `id_order`, `id_product`, `date`, `time`, `message`) VALUES
(1, 1, 1, 1, 1, '2025-11-25', '23:58:04', 'Halo, pesanan saya sudah diproses?');

-- --------------------------------------------------------

--
-- Struktur dari tabel `delivery`
--

CREATE TABLE `delivery` (
  `id_delivery` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `delivery_charges` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `delivery`
--

INSERT INTO `delivery` (`id_delivery`, `type`, `delivery_charges`) VALUES
(1, 'Motor', 10000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `history`
--

CREATE TABLE `history` (
  `id_history` int(11) NOT NULL,
  `id_order` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `history`
--

INSERT INTO `history` (`id_history`, `id_order`, `date`, `time`) VALUES
(1, 1, '2025-11-25', '23:57:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mystery_box`
--

CREATE TABLE `mystery_box` (
  `id_mystery_box` int(11) NOT NULL,
  `name_box` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mystery_box`
--

INSERT INTO `mystery_box` (`id_mystery_box`, `name_box`, `description`) VALUES
(1, 'Gacha Elektronik', 'Hadiah acak barang elektronik');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mystery_box_product`
--

CREATE TABLE `mystery_box_product` (
  `id_mystery_box` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `price` double DEFAULT NULL,
  `point_gacha` int(11) DEFAULT NULL,
  `history_gacha` varchar(255) DEFAULT NULL,
  `type_gacha` varchar(255) DEFAULT NULL,
  `drop_rate` double DEFAULT NULL,
  `cashback` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mystery_box_product`
--

INSERT INTO `mystery_box_product` (`id_mystery_box`, `id_product`, `price`, `point_gacha`, `history_gacha`, `type_gacha`, `drop_rate`, `cashback`) VALUES
(1, 1, 50000, 10, 'First Spin', 'Electronics', 0.25, 5000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id_order` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_delivery` int(11) DEFAULT NULL,
  `id_address` int(11) DEFAULT NULL,
  `id_payment_method` int(11) DEFAULT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `extra_charges` double DEFAULT NULL,
  `total_payment` double DEFAULT NULL,
  `status_order` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id_order`, `id_user`, `id_delivery`, `id_address`, `id_payment_method`, `order_date`, `extra_charges`, `total_payment`, `status_order`) VALUES
(1, NULL, 1, 1, 1, '2025-11-26 19:45:48', 1000, 250000, 'Pending');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_item`
--

CREATE TABLE `order_item` (
  `id_order_item` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `subtotal` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `payment_method`
--

CREATE TABLE `payment_method` (
  `id_payment_method` int(11) NOT NULL,
  `name_method` varchar(255) DEFAULT NULL,
  `payment_barcode` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `payment_method`
--

INSERT INTO `payment_method` (`id_payment_method`, `name_method`, `payment_barcode`) VALUES
(1, 'Debit Card', NULL),
(2, 'Bank Transfer', NULL),
(3, 'E-Wallet', NULL),
(4, 'Indomaret', 'INDO-12345'),
(5, 'Alfamart', 'ALFA-67890');

-- --------------------------------------------------------

--
-- Struktur dari tabel `product`
--

CREATE TABLE `product` (
  `id_product` int(11) NOT NULL,
  `id_store` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `name_product` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `product_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `product`
--

INSERT INTO `product` (`id_product`, `id_store`, `price`, `stock`, `name_product`, `description`, `product_picture`) VALUES
(1, 1, 120000, 0, 'Mouse Gaming', 'RGB gaming mouse', 'mouse.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `review_product`
--

CREATE TABLE `review_product` (
  `id_review_product` int(11) NOT NULL,
  `id_product` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `like_review` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `review_product`
--

INSERT INTO `review_product` (`id_review_product`, `id_product`, `id_user`, `comment`, `like_review`, `rating`) VALUES
(1, 1, 1, 'Barang bagus!', 3, 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `review_store`
--

CREATE TABLE `review_store` (
  `id_review_store` int(11) NOT NULL,
  `id_store` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `like_review` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `review_store`
--

INSERT INTO `review_store` (`id_review_store`, `id_store`, `id_user`, `comment`, `like_review`, `rating`) VALUES
(1, 1, 1, 'Toko terpercaya', 2, 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `store`
--

CREATE TABLE `store` (
  `id_store` int(11) NOT NULL,
  `name_store` varchar(255) DEFAULT NULL,
  `rating_store` double DEFAULT NULL,
  `store_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `store`
--

INSERT INTO `store` (`id_store`, `name_store`, `rating_store`, `store_picture`) VALUES
(1, 'Toko A', 4.8, 'store_a.png'),
(2, 'Toko A', 4.8, 'store_a.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `top_up`
--

CREATE TABLE `top_up` (
  `id_top_up` int(11) NOT NULL,
  `id_payment_method` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `total_top_up` double DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `admin_fee` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `top_up`
--

INSERT INTO `top_up` (`id_top_up`, `id_payment_method`, `id_user`, `total_top_up`, `date`, `time`, `admin_fee`) VALUES
(1, 1, 1, 150000, '2025-11-25', '23:57:24', 1500),
(2, 1, 1, 150000, '2025-11-25', '23:57:24', 1500);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `id_address` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `phone_number` varchar(50) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `id_address`, `email`, `password`, `username`, `phone_number`, `profile_picture`, `role`) VALUES
(1, 1, 'test@example.com', 'hashed_pw', 'fikri', '0812000000', 'pp.png', 'customer'),
(2, 1, 'test@example.com', 'hashed_pw', 'fikri', '0812000000', 'pp.png', 'customer');

-- --------------------------------------------------------

--
-- Struktur dari tabel `wallet`
--

CREATE TABLE `wallet` (
  `id_user` int(11) NOT NULL,
  `saldo_coin` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `wallet`
--

INSERT INTO `wallet` (`id_user`, `saldo_coin`) VALUES
(1, 200000);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id_address`);

--
-- Indeks untuk tabel `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id_cart`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `cart_item`
--
ALTER TABLE `cart_item`
  ADD PRIMARY KEY (`id_cart_item`),
  ADD KEY `id_cart` (`id_cart`),
  ADD KEY `id_product` (`id_product`);

--
-- Indeks untuk tabel `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id_chat`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_store` (`id_store`),
  ADD KEY `id_order` (`id_order`),
  ADD KEY `id_product` (`id_product`);

--
-- Indeks untuk tabel `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`id_delivery`);

--
-- Indeks untuk tabel `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id_history`),
  ADD KEY `id_order` (`id_order`);

--
-- Indeks untuk tabel `mystery_box`
--
ALTER TABLE `mystery_box`
  ADD PRIMARY KEY (`id_mystery_box`);

--
-- Indeks untuk tabel `mystery_box_product`
--
ALTER TABLE `mystery_box_product`
  ADD PRIMARY KEY (`id_mystery_box`,`id_product`),
  ADD KEY `id_product` (`id_product`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `fk_orders_user` (`id_user`),
  ADD KEY `fk_orders_delivery` (`id_delivery`),
  ADD KEY `fk_orders_address` (`id_address`),
  ADD KEY `fk_orders_payment` (`id_payment_method`);

--
-- Indeks untuk tabel `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`id_order_item`),
  ADD KEY `id_order` (`id_order`),
  ADD KEY `id_product` (`id_product`);

--
-- Indeks untuk tabel `payment_method`
--
ALTER TABLE `payment_method`
  ADD PRIMARY KEY (`id_payment_method`);

--
-- Indeks untuk tabel `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id_product`),
  ADD KEY `id_store` (`id_store`);

--
-- Indeks untuk tabel `review_product`
--
ALTER TABLE `review_product`
  ADD PRIMARY KEY (`id_review_product`),
  ADD KEY `id_product` (`id_product`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `review_store`
--
ALTER TABLE `review_store`
  ADD PRIMARY KEY (`id_review_store`),
  ADD KEY `id_store` (`id_store`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`id_store`);

--
-- Indeks untuk tabel `top_up`
--
ALTER TABLE `top_up`
  ADD PRIMARY KEY (`id_top_up`),
  ADD KEY `id_payment_method` (`id_payment_method`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_address` (`id_address`);

--
-- Indeks untuk tabel `wallet`
--
ALTER TABLE `wallet`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `address`
--
ALTER TABLE `address`
  MODIFY `id_address` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `cart`
--
ALTER TABLE `cart`
  MODIFY `id_cart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `cart_item`
--
ALTER TABLE `cart_item`
  MODIFY `id_cart_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `chat`
--
ALTER TABLE `chat`
  MODIFY `id_chat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `delivery`
--
ALTER TABLE `delivery`
  MODIFY `id_delivery` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `history`
--
ALTER TABLE `history`
  MODIFY `id_history` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `mystery_box`
--
ALTER TABLE `mystery_box`
  MODIFY `id_mystery_box` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `order_item`
--
ALTER TABLE `order_item`
  MODIFY `id_order_item` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `payment_method`
--
ALTER TABLE `payment_method`
  MODIFY `id_payment_method` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `product`
--
ALTER TABLE `product`
  MODIFY `id_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `review_product`
--
ALTER TABLE `review_product`
  MODIFY `id_review_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `review_store`
--
ALTER TABLE `review_store`
  MODIFY `id_review_store` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `store`
--
ALTER TABLE `store`
  MODIFY `id_store` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `top_up`
--
ALTER TABLE `top_up`
  MODIFY `id_top_up` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `cart_item`
--
ALTER TABLE `cart_item`
  ADD CONSTRAINT `cart_item_ibfk_1` FOREIGN KEY (`id_cart`) REFERENCES `cart` (`id_cart`),
  ADD CONSTRAINT `cart_item_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`);

--
-- Ketidakleluasaan untuk tabel `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `chat_ibfk_2` FOREIGN KEY (`id_store`) REFERENCES `store` (`id_store`),
  ADD CONSTRAINT `chat_ibfk_3` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`),
  ADD CONSTRAINT `chat_ibfk_4` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`);

--
-- Ketidakleluasaan untuk tabel `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`);

--
-- Ketidakleluasaan untuk tabel `mystery_box_product`
--
ALTER TABLE `mystery_box_product`
  ADD CONSTRAINT `mystery_box_product_ibfk_1` FOREIGN KEY (`id_mystery_box`) REFERENCES `mystery_box` (`id_mystery_box`),
  ADD CONSTRAINT `mystery_box_product_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`);

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_address` FOREIGN KEY (`id_address`) REFERENCES `address` (`id_address`),
  ADD CONSTRAINT `fk_orders_delivery` FOREIGN KEY (`id_delivery`) REFERENCES `delivery` (`id_delivery`),
  ADD CONSTRAINT `fk_orders_payment` FOREIGN KEY (`id_payment_method`) REFERENCES `payment_method` (`id_payment_method`),
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `order_item_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_item_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`);

--
-- Ketidakleluasaan untuk tabel `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`id_store`) REFERENCES `store` (`id_store`);

--
-- Ketidakleluasaan untuk tabel `review_product`
--
ALTER TABLE `review_product`
  ADD CONSTRAINT `review_product_ibfk_1` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`),
  ADD CONSTRAINT `review_product_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `review_store`
--
ALTER TABLE `review_store`
  ADD CONSTRAINT `review_store_ibfk_1` FOREIGN KEY (`id_store`) REFERENCES `store` (`id_store`),
  ADD CONSTRAINT `review_store_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `top_up`
--
ALTER TABLE `top_up`
  ADD CONSTRAINT `top_up_ibfk_1` FOREIGN KEY (`id_payment_method`) REFERENCES `payment_method` (`id_payment_method`),
  ADD CONSTRAINT `top_up_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_address`) REFERENCES `address` (`id_address`);

--
-- Ketidakleluasaan untuk tabel `wallet`
--
ALTER TABLE `wallet`
  ADD CONSTRAINT `wallet_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
