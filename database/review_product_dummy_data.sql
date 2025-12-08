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
