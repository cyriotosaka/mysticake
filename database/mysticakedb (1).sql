-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Dec 02, 2025 at 10:22 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id_address` int(11) NOT NULL,
  `full_address` text DEFAULT NULL,
  `map_point` varchar(255) DEFAULT NULL,
  `address_contact_number` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id_address`, `full_address`, `map_point`, `address_contact_number`) VALUES
(1, 'Jl. Mawar No 10', '-6.2000,106.8166', '08123456789');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id_cart` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id_cart`, `id_user`, `created_at`) VALUES
(1, 1, '2025-11-25 23:46:06'),
(2, 1, '2025-11-25 23:46:06');

-- --------------------------------------------------------

--
-- Table structure for table `cart_item`
--

CREATE TABLE `cart_item` (
  `id_cart_item` int(11) NOT NULL,
  `id_cart` int(11) DEFAULT NULL,
  `id_product` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat`
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

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE `delivery` (
  `id_delivery` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `delivery_charges` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery`
--

INSERT INTO `delivery` (`id_delivery`, `type`, `delivery_charges`) VALUES
(1, 'Motor', 10000),
(2, 'Mobil', 15000),
(3, 'Express Motor', 20000),
(4, 'Express Mobil', 30000);

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id_history` int(11) NOT NULL,
  `id_order` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id_history`, `id_order`, `date`, `time`) VALUES
(1, 1, '2025-11-25', '23:57:52');

-- --------------------------------------------------------

--
-- Table structure for table `mystery_box`
--

CREATE TABLE `mystery_box` (
  `id_mystery_box` int(11) NOT NULL,
  `name_box` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mystery_box`
--

INSERT INTO `mystery_box` (`id_mystery_box`, `name_box`, `description`) VALUES
(1, 'Gacha Elektronik', 'Hadiah acak barang elektronik');

-- --------------------------------------------------------

--
-- Table structure for table `mystery_box_product`
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
-- Dumping data for table `mystery_box_product`
--

INSERT INTO `mystery_box_product` (`id_mystery_box`, `id_product`, `price`, `point_gacha`, `history_gacha`, `type_gacha`, `drop_rate`, `cashback`) VALUES
(1, 1, 50000, 10, 'First Spin', 'Electronics', 0.25, 5000);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
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
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id_order`, `id_user`, `id_delivery`, `id_address`, `id_payment_method`, `order_date`, `extra_charges`, `total_payment`, `status_order`) VALUES
(1, NULL, 1, 1, 1, '2025-11-26 19:45:48', 1000, 250000, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
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
-- Table structure for table `payment_method`
--

CREATE TABLE `payment_method` (
  `id_payment_method` int(11) NOT NULL,
  `name_method` varchar(255) DEFAULT NULL,
  `payment_barcode` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_method`
--

INSERT INTO `payment_method` (`id_payment_method`, `name_method`, `payment_barcode`) VALUES
(1, 'Debit Card', NULL),
(2, 'Bank Transfer', NULL),
(3, 'E-Wallet', NULL),
(4, 'Indomaret', 'INDO-12345'),
(5, 'Alfamart', 'ALFA-67890'),
(6, 'Cash', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product`
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
-- Dumping data for table `product`
--

INSERT INTO `product` (`id_product`, `id_store`, `price`, `stock`, `name_product`, `description`, `product_picture`) VALUES
(1, 1, 10000, 40, 'Red Velvet Cupcake', 'Moist red velvet cupcake with cream cheese frosting and fresh strawberry crumbs.', 'cupcake_red.png'),
(2, 1, 15000, 45, 'Chocolate Nut Donut', 'A fluffy, yeast-raised donut covered in silky chocolate glaze, finished with white chocolate drizzle and crushed pistachios.', 'donut_choco.png'),
(3, 1, 15000, 50, 'Caramel Donut', 'Soft fluffy donut with melted caramel topping, offering a perfect balance of sweet and savory.', 'donut_caramel.png'),
(4, 1, 20000, 60, 'Vanilla Eclair', 'Classic long pastry filled with cold vanilla custard and topped with white chocolate.', 'eclair_vanilla.png'),
(5, 1, 25000, 30, 'Caramel Choco Icecream', 'Creamy vanilla ice cream served on a rich chocolate brownie, topped with caramel sauce and wafer rolls.', 'icecream_caramel.png'),
(6, 1, 45000, 15, 'Matcha Mille Crepes', 'Delicate layer cake with thousands of authentic Japanese matcha cream layers.', 'crepes_matcha.png'),
(7, 1, 55000, 30, 'Macaron Set (5 pcs)', 'A set of colorful macarons with various fruity and creamy fillings.', 'macaron_set.png'),
(8, 1, 65000, 25, 'Strawberry Shortcake', 'Light vanilla sponge cake layered with fresh whipped cream and juicy strawberry slices.', 'cake_strawberry.png'),
(9, 1, 85000, 20, 'Blueberry Cheesecake', 'Premium cheesecake with authentic blueberry jam and a crunchy biscuit crust.', 'cake_berry.png'),
(10, 1, 120000, 10, 'Belgium Chocolate Cake', 'Luxurious chocolate cake made with authentic Belgian chocolate. Rich and decadent.', 'cake_choco.png'),
(11, 1, 200000, 5, 'Gold Leaf Brownie', 'Premium roasted brownie garnished with edible gold leaf for a luxurious touch.', 'brownie_gold.png');

-- --------------------------------------------------------

--
-- Table structure for table `review_product`
--

CREATE TABLE `review_product` (
  `id_review_product` int(11) NOT NULL,
  `id_product` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `like_review` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review_store`
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
-- Dumping data for table `review_store`
--

INSERT INTO `review_store` (`id_review_store`, `id_store`, `id_user`, `comment`, `like_review`, `rating`) VALUES
(1, 1, 1, 'Toko terpercaya', 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE `store` (
  `id_store` int(11) NOT NULL,
  `name_store` varchar(255) DEFAULT NULL,
  `rating_store` double DEFAULT NULL,
  `store_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`id_store`, `name_store`, `rating_store`, `store_picture`) VALUES
(1, 'Toko A', 4.8, 'store_a.png'),
(2, 'Toko A', 4.8, 'store_a.png');

-- --------------------------------------------------------

--
-- Table structure for table `top_up`
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
-- Dumping data for table `top_up`
--

INSERT INTO `top_up` (`id_top_up`, `id_payment_method`, `id_user`, `total_top_up`, `date`, `time`, `admin_fee`) VALUES
(1, 1, 1, 150000, '2025-11-25', '23:57:24', 1500),
(2, 1, 1, 150000, '2025-11-25', '23:57:24', 1500);

-- --------------------------------------------------------

--
-- Table structure for table `user`
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
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `id_address`, `email`, `password`, `username`, `phone_number`, `profile_picture`, `role`) VALUES
(1, 1, 'test@example.com', 'hashed_pw', 'fikri', '0812000000', 'pp.png', 'customer'),
(2, 1, 'test@example.com', 'hashed_pw', 'fikri', '0812000000', 'pp.png', 'customer'),
(3, NULL, 'coba@coba.com', '$2y$12$9jYpEmfaBo2Yx7a2TmawgeLZxFOrafzQM63/hcrb0mNB8kj6f1n4G', 'coba', '08123456789', NULL, 'buyer');

-- --------------------------------------------------------

--
-- Table structure for table `wallet`
--

CREATE TABLE `wallet` (
  `id_user` int(11) NOT NULL,
  `saldo_coin` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wallet`
--

INSERT INTO `wallet` (`id_user`, `saldo_coin`) VALUES
(1, 200000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id_address`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id_cart`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `cart_item`
--
ALTER TABLE `cart_item`
  ADD PRIMARY KEY (`id_cart_item`),
  ADD KEY `id_cart` (`id_cart`),
  ADD KEY `id_product` (`id_product`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id_chat`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_store` (`id_store`),
  ADD KEY `id_order` (`id_order`),
  ADD KEY `id_product` (`id_product`);

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`id_delivery`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id_history`),
  ADD KEY `id_order` (`id_order`);

--
-- Indexes for table `mystery_box`
--
ALTER TABLE `mystery_box`
  ADD PRIMARY KEY (`id_mystery_box`);

--
-- Indexes for table `mystery_box_product`
--
ALTER TABLE `mystery_box_product`
  ADD PRIMARY KEY (`id_mystery_box`,`id_product`),
  ADD KEY `id_product` (`id_product`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `fk_orders_user` (`id_user`),
  ADD KEY `fk_orders_delivery` (`id_delivery`),
  ADD KEY `fk_orders_address` (`id_address`),
  ADD KEY `fk_orders_payment` (`id_payment_method`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`id_order_item`),
  ADD KEY `id_order` (`id_order`),
  ADD KEY `id_product` (`id_product`);

--
-- Indexes for table `payment_method`
--
ALTER TABLE `payment_method`
  ADD PRIMARY KEY (`id_payment_method`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id_product`),
  ADD KEY `id_store` (`id_store`);

--
-- Indexes for table `review_product`
--
ALTER TABLE `review_product`
  ADD PRIMARY KEY (`id_review_product`),
  ADD KEY `id_product` (`id_product`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `review_store`
--
ALTER TABLE `review_store`
  ADD PRIMARY KEY (`id_review_store`),
  ADD KEY `id_store` (`id_store`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`id_store`);

--
-- Indexes for table `top_up`
--
ALTER TABLE `top_up`
  ADD PRIMARY KEY (`id_top_up`),
  ADD KEY `id_payment_method` (`id_payment_method`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_address` (`id_address`);

--
-- Indexes for table `wallet`
--
ALTER TABLE `wallet`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id_address` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id_cart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart_item`
--
ALTER TABLE `cart_item`
  MODIFY `id_cart_item` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id_chat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `id_delivery` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id_history` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mystery_box`
--
ALTER TABLE `mystery_box`
  MODIFY `id_mystery_box` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `id_order_item` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_method`
--
ALTER TABLE `payment_method`
  MODIFY `id_payment_method` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `review_product`
--
ALTER TABLE `review_product`
  MODIFY `id_review_product` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review_store`
--
ALTER TABLE `review_store`
  MODIFY `id_review_store` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `store`
--
ALTER TABLE `store`
  MODIFY `id_store` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `top_up`
--
ALTER TABLE `top_up`
  MODIFY `id_top_up` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `cart_item`
--
ALTER TABLE `cart_item`
  ADD CONSTRAINT `cart_item_ibfk_1` FOREIGN KEY (`id_cart`) REFERENCES `cart` (`id_cart`),
  ADD CONSTRAINT `cart_item_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`);

--
-- Constraints for table `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `chat_ibfk_2` FOREIGN KEY (`id_store`) REFERENCES `store` (`id_store`),
  ADD CONSTRAINT `chat_ibfk_3` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`),
  ADD CONSTRAINT `chat_ibfk_4` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`);

--
-- Constraints for table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`);

--
-- Constraints for table `mystery_box_product`
--
ALTER TABLE `mystery_box_product`
  ADD CONSTRAINT `mystery_box_product_ibfk_1` FOREIGN KEY (`id_mystery_box`) REFERENCES `mystery_box` (`id_mystery_box`),
  ADD CONSTRAINT `mystery_box_product_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_address` FOREIGN KEY (`id_address`) REFERENCES `address` (`id_address`),
  ADD CONSTRAINT `fk_orders_delivery` FOREIGN KEY (`id_delivery`) REFERENCES `delivery` (`id_delivery`),
  ADD CONSTRAINT `fk_orders_payment` FOREIGN KEY (`id_payment_method`) REFERENCES `payment_method` (`id_payment_method`),
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `order_item_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_item_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`id_store`) REFERENCES `store` (`id_store`);

--
-- Constraints for table `review_product`
--
ALTER TABLE `review_product`
  ADD CONSTRAINT `review_product_ibfk_1` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`),
  ADD CONSTRAINT `review_product_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `review_store`
--
ALTER TABLE `review_store`
  ADD CONSTRAINT `review_store_ibfk_1` FOREIGN KEY (`id_store`) REFERENCES `store` (`id_store`),
  ADD CONSTRAINT `review_store_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `top_up`
--
ALTER TABLE `top_up`
  ADD CONSTRAINT `top_up_ibfk_1` FOREIGN KEY (`id_payment_method`) REFERENCES `payment_method` (`id_payment_method`),
  ADD CONSTRAINT `top_up_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_address`) REFERENCES `address` (`id_address`);

--
-- Constraints for table `wallet`
--
ALTER TABLE `wallet`
  ADD CONSTRAINT `wallet_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
