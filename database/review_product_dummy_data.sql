-- =====================================================
-- REVIEW PRODUCT DUMMY DATA
-- MystiCake Database - Review Product Table
-- Generated: 2025-12-03
-- =====================================================

-- Insert sample reviews for all products
-- Products: Red Velvet Cupcake, Chocolate Donut, Caramel Donut, Vanilla Eclair, 
--           Caramel Choco Icecream, Matcha Mille Crepes, Macaron Set, Strawberry Shortcake,
--           Blueberry Cheesecake, Belgium Chocolate Cake, Gold Leaf Brownie

INSERT INTO `review_product` (`id_review_product`, `id_product`, `id_user`, `comment`, `like_review`, `rating`) VALUES

-- Reviews for Red Velvet Cupcake (id_product = 1)
(1, 1, 1, 'Cupcake-nya lembut banget! Cream cheese frosting-nya pas ga terlalu manis. Recommended!', 12, 5),
(2, 1, 1, 'Enak sih tapi agak kecil porsinya. Harga segini bisa lebih besar dikit.', 3, 4),
(3, 1, 1, 'Red velvet terenak yang pernah aku coba. Warnanya cantik, rasanya juga juara!', 8, 5),
(4, 1, 1, 'Teksturnya lembut, tapi rasanya kurang nendang menurut aku.', 2, 3),

-- Reviews for Chocolate Nut Donut (id_product = 2)
(5, 2, 1, 'Donatnya fluffy banget! Toppingnya melimpah, worth it!', 15, 5),
(6, 2, 1, 'Cokelatnya enak, tapi terlalu manis buatku. Overall masih oke.', 4, 4),
(7, 2, 1, 'Pistachionya sedikit ya, tapi donatnya empuk. Enak!', 7, 4),

-- Reviews for Caramel Donut (id_product = 3)
(8, 3, 1, 'Lelehan caramelnya berasa banget! Ga gosong kaya di tempat lain ><', 18, 5),
(9, 3, 1, 'Rasanya mewah banget! Donatnya lembut, caramelnya pas.', 9, 5),
(10, 3, 1, 'Enak tapi terlalu manis. Mungkin buat yang suka manis cocok.', 3, 4),

-- Reviews for Vanilla Eclair (id_product = 4)
(11, 4, 1, 'Custard-nya creamy dan dingin. Pastrynya crispy. Perfect!', 11, 5),
(12, 4, 1, 'Classic eclair tapi eksekusinya bagus. Recommended!', 6, 5),
(13, 4, 1, 'Enak sih, tapi harganya agak mahal untuk ukuran segini.', 2, 4),

-- Reviews for Caramel Choco Icecream (id_product = 5)
(14, 5, 1, 'Ice cream-nya creamy, brownie-nya fudgy, caramel sauce-nya juara!', 20, 5),
(15, 5, 1, 'Porsinya pas, ga terlalu besar ga terlalu kecil. Enak banget!', 8, 5),
(16, 5, 1, 'Agak pricey tapi worth it sih. Rasanya nagih!', 5, 4),

-- Reviews for Matcha Mille Crepes (id_product = 6)
(17, 6, 1, 'Matchanya authentic banget! Ga terlalu manis, cocok buat yang suka matcha original.', 22, 5),
(18, 6, 1, 'Layer-nya banyak, creamy, dan lembut. Worth the price!', 14, 5),
(19, 6, 1, 'Enak sih tapi harganya agak mahal ya. Tapi kualitas oke!', 6, 4),
(20, 6, 1, 'Matcha lover wajib coba! Rasanya balance antara manis dan pahit.', 10, 5),

-- Reviews for Macaron Set (id_product = 7)
(21, 7, 1, 'Macaronnya cantik dan rasanya variatif. Ada rasa strawberry, vanilla, chocolate. Enak semua!', 16, 5),
(22, 7, 1, 'Macaronnya crispy di luar, chewy di dalam. Perfect texture!', 9, 5),
(23, 7, 1, 'Lumayan enak tapi ada yang terlalu manis. Overall oke lah.', 4, 4),

-- Reviews for Strawberry Shortcake (id_product = 8)
(24, 8, 1, 'Strawberry-nya segar, sponge cake-nya lembut. Light and fluffy!', 13, 5),
(25, 8, 1, 'Whipped cream-nya ga terlalu heavy. Cocok buat yang ga suka terlalu manis.', 8, 5),
(26, 8, 1, 'Klasik banget. Rasanya enak, presentasinya juga bagus.', 7, 4),

-- Reviews for Blueberry Cheesecake (id_product = 9)
(27, 9, 1, 'Cheesecake-nya creamy, blueberry jam-nya asam manis. Perfect combination!', 19, 5),
(28, 9, 1, 'Crustnya crunchy, isian cheesecake-nya smooth. Premium quality!', 11, 5),
(29, 9, 1, 'Cobain ini karena lagi viral. Ternyata emang seenak itu TT', 15, 5),
(30, 9, 1, 'Enak banget! Tapi porsi agak kecil untuk harga segini.', 5, 4),

-- Reviews for Belgium Chocolate Cake (id_product = 10)
(31, 10, 1, 'Chocolatenya rich banget! Buat chocolate lover ini surga dunia.', 25, 5),
(32, 10, 1, 'Moist, fudgy, dan ga terlalu manis. Belgian chocolate beneran ini!', 17, 5),
(33, 10, 1, 'Mahal tapi worth every rupiah. Quality chocolate cake!', 12, 5),
(34, 10, 1, 'Onde mandeee. Enaknyooo', 8, 5),

-- Reviews for Gold Leaf Brownie (id_product = 11)
(35, 11, 1, 'Gold leaf-nya bikin keliatan mewah. Brownie-nya fudgy dan enak!', 20, 5),
(36, 11, 1, 'Selain cantik, rasanya juga juara. Cocok buat gift atau treat yourself.', 13, 5),
(37, 11, 1, 'Pricey banget tapi experience-nya beda. Sekali-kali boleh lah.', 7, 4),
(38, 11, 1, 'Brownies terenak yang pernah aku makan. Premium banget!', 16, 5);

-- Update AUTO_INCREMENT
ALTER TABLE `review_product`
  MODIFY `id_review_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

-- ========================================
-- Dummy Data untuk Tabel Product
-- Database: mysticakedb
-- Created by: Okky Priscila_168
-- ========================================

-- Hapus data lama jika ada (optional - uncomment jika perlu)
-- DELETE FROM product WHERE id_product > 0;

-- ========================================
-- INSERT 20 Dummy Products
-- ========================================
-- Kategori berdasarkan harga:
-- Normal Gacha: Rp 0 - Rp 49.999 (id 1-12)
-- Premium Gacha: Rp 50.000 - Rp 1.000.000 (id 13-20)
-- ========================================

INSERT INTO `product` (`id_product`, `id_store`, `price`, `stock`, `name_product`, `description`, `product_picture`) VALUES

-- ========================================
-- NORMAL GACHA PRODUCTS (Harga < Rp 50.000)
-- ========================================

-- Low Price Range (Rp 10.000 - Rp 20.000)
(1, 1, 10000, 40, 'Red Velvet Cupcake', 'Moist red velvet cupcake with cream cheese frosting and fresh strawberry crumbs.', 'images/products/cupcake_red.png'),
(2, 1, 12000, 55, 'Chocolate Chip Cookie', 'Crispy on the outside, chewy on the inside with premium dark chocolate chips.', 'images/products/cookie_choco.png'),
(3, 1, 15000, 45, 'Chocolate Nut Donut', 'A fluffy donut covered in silky chocolate glaze with crushed pistachios.', 'images/products/donut_choco.png'),
(4, 1, 15000, 50, 'Caramel Donut', 'Soft fluffy donut with melted caramel topping.', 'images/products/donut_caramel.png'),
(5, 1, 18000, 35, 'Strawberry Mochi', 'Soft Japanese mochi filled with fresh strawberry and sweet red bean paste.', 'images/products/mochi_strawberry.png'),
(6, 1, 20000, 60, 'Vanilla Eclair', 'Classic long pastry filled with cold vanilla custard and topped with white chocolate.', 'images/products/eclair_vanilla.png'),

-- Medium Price Range (Rp 22.000 - Rp 35.000)
(7, 1, 22000, 30, 'Matcha Pudding', 'Creamy Japanese matcha pudding with a hint of vanilla and caramel sauce.', 'images/products/pudding_matcha.png'),
(8, 1, 25000, 40, 'Caramel Choco Icecream', 'Creamy vanilla ice cream on a rich chocolate brownie with caramel sauce.', 'images/products/icecream_caramel.png'),
(9, 1, 28000, 25, 'Tiramisu Cup', 'Individual tiramisu cup with layers of mascarpone cream and espresso-soaked ladyfingers.', 'images/products/tiramisu_cup.png'),
(10, 1, 32000, 20, 'Fruit Tart Mini', 'Buttery tart shell filled with vanilla custard and topped with fresh seasonal fruits.', 'images/products/tart_fruit.png'),

-- High Normal Range (Rp 38.000 - Rp 48.000)
(11, 1, 38000, 18, 'Cheese Souffle', 'Light and airy Japanese-style cheese souffle cake, fluffy like a cloud.', 'images/products/souffle_cheese.png'),
(12, 1, 45000, 15, 'Matcha Mille Crepes', 'Delicate layer cake with thousands of authentic Japanese matcha cream layers.', 'images/products/crepes_matcha.png'),

-- ========================================
-- PREMIUM GACHA PRODUCTS (Harga >= Rp 50.000)
-- ========================================

-- Entry Premium (Rp 55.000 - Rp 75.000)
(13, 1, 55000, 30, 'Macaron Set (5 pcs)', 'A set of colorful macarons with various fruity and creamy fillings.', 'images/products/macaron_set.png'),
(14, 1, 65000, 25, 'Strawberry Shortcake', 'Light vanilla sponge cake layered with fresh whipped cream and juicy strawberry slices.', 'images/products/cake_strawberry.png'),
(15, 1, 72000, 22, 'Chocolate Lava Cake', 'Warm chocolate cake with molten chocolate center, served with vanilla ice cream.', 'images/products/cake_lava.png'),

-- Mid Premium (Rp 85.000 - Rp 120.000)
(16, 1, 85000, 20, 'Blueberry Cheesecake', 'Premium cheesecake with authentic blueberry jam and a crunchy biscuit crust.', 'images/products/cake_blueberry.png'),
(17, 1, 95000, 15, 'Opera Cake', 'Classic French cake with layers of almond sponge, coffee buttercream, and chocolate ganache.', 'images/products/cake_opera.png'),
(18, 1, 120000, 12, 'Red Velvet Layer Cake', 'Three-layer red velvet cake with premium cream cheese frosting and red velvet crumbs.', 'images/products/cake_redvelvet.png'),

-- High Premium (Rp 150.000 - Rp 250.000)
(19, 1, 150000, 8, 'Premium Fruit Pavlova', 'Crispy meringue base topped with fresh cream and exotic seasonal fruits.', 'images/products/pavlova_fruit.png'),
(20, 1, 250000, 5, 'Grand Chocolate Tower', 'Luxurious 5-tier chocolate cake with Belgian chocolate ganache and gold leaf decoration.', 'images/products/cake_grand.png');

-- ========================================
-- Verifikasi Data
-- ========================================
-- SELECT * FROM product ORDER BY price ASC;

-- ========================================
-- Summary:
-- ========================================
-- Normal Gacha (< Rp 50.000): 12 products
--   Total Stock: 433 units
--   Price Range: Rp 10.000 - Rp 45.000
--
-- Premium Gacha (>= Rp 50.000): 8 products
--   Total Stock: 137 units
--   Price Range: Rp 55.000 - Rp 250.000
--
-- Grand Total: 20 products, 570 units
-- ========================================