<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * GachaProductSeeder
 * 
 * Seeder untuk menambahkan produk-produk Mystery Box Gacha
 * - 20 produk untuk Normal Box (harga Rp 0 - Rp 49.999)
 * - 20 produk untuk Premium Box (harga Rp 50.000+)
 * 
 * Cara penggunaan:
 * 1. Letakkan file ini di: database/seeders/GachaProductSeeder.php
 * 2. Jalankan: php artisan db:seed --class=GachaProductSeeder
 * 
 * Atau tambahkan ke DatabaseSeeder.php:
 * $this->call(GachaProductSeeder::class);
 * 
 * @author MYstiCake Team
 * @date December 29, 2025
 */
class GachaProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ============================================================
        // PART 1: INSERT NEW PRODUCTS
        // ============================================================
        
        $products = [
            // =============================================
            // NORMAL BOX PRODUCTS (Price: Rp 0 - Rp 49,999)
            // =============================================
            
            // Cupcakes & Muffins (Rp 10,000 - Rp 18,000)
            [
                'id_store' => 1,
                'price' => 10000,
                'stock' => 35,
                'name_product' => 'Lemon Zest Cupcake',
                'description' => 'Refreshing lemon cupcake with tangy cream cheese frosting and lemon zest topping.',
                'product_picture' => 'cupcake_lemon.png',
            ],
            [
                'id_store' => 1,
                'price' => 12000,
                'stock' => 40,
                'name_product' => 'Chocolate Fudge Cupcake',
                'description' => 'Rich chocolate cupcake topped with creamy fudge frosting and chocolate chips.',
                'product_picture' => 'cupcake_choco.png',
            ],
            [
                'id_store' => 1,
                'price' => 10000,
                'stock' => 50,
                'name_product' => 'Vanilla Bean Cupcake',
                'description' => 'Classic vanilla cupcake with real vanilla bean buttercream frosting.',
                'product_picture' => 'cupcake_vanilla.png',
            ],
            [
                'id_store' => 1,
                'price' => 15000,
                'stock' => 30,
                'name_product' => 'Blueberry Muffin',
                'description' => 'Soft and fluffy muffin loaded with fresh blueberries and streusel topping.',
                'product_picture' => 'muffin_blueberry.png',
            ],
            [
                'id_store' => 1,
                'price' => 15000,
                'stock' => 28,
                'name_product' => 'Banana Walnut Muffin',
                'description' => 'Moist banana muffin with crunchy walnut pieces and cinnamon sugar.',
                'product_picture' => 'muffin_banana.png',
            ],

            // Donuts (Rp 12,000 - Rp 18,000)
            [
                'id_store' => 1,
                'price' => 12000,
                'stock' => 45,
                'name_product' => 'Strawberry Glazed Donut',
                'description' => 'Soft donut with sweet strawberry glaze and rainbow sprinkles.',
                'product_picture' => 'donut_strawberry.png',
            ],
            [
                'id_store' => 1,
                'price' => 14000,
                'stock' => 38,
                'name_product' => 'Cinnamon Sugar Donut',
                'description' => 'Warm donut coated in cinnamon sugar, perfect with coffee.',
                'product_picture' => 'donut_cinnamon.png',
            ],
            [
                'id_store' => 1,
                'price' => 16000,
                'stock' => 42,
                'name_product' => 'Maple Bacon Donut',
                'description' => 'Unique sweet and savory donut with maple glaze and crispy bacon bits.',
                'product_picture' => 'donut_maple.png',
            ],
            [
                'id_store' => 1,
                'price' => 18000,
                'stock' => 35,
                'name_product' => 'Cookies & Cream Donut',
                'description' => 'Vanilla glazed donut topped with crushed Oreo cookies.',
                'product_picture' => 'donut_oreo.png',
            ],

            // Pastries & Puffs (Rp 18,000 - Rp 25,000)
            [
                'id_store' => 1,
                'price' => 18000,
                'stock' => 25,
                'name_product' => 'Cheese Croissant',
                'description' => 'Buttery flaky croissant filled with melted cheddar cheese.',
                'product_picture' => 'croissant_cheese.png',
            ],
            [
                'id_store' => 1,
                'price' => 20000,
                'stock' => 30,
                'name_product' => 'Chocolate Croissant',
                'description' => 'Classic French croissant with rich dark chocolate filling.',
                'product_picture' => 'croissant_choco.png',
            ],
            [
                'id_store' => 1,
                'price' => 22000,
                'stock' => 28,
                'name_product' => 'Custard Cream Puff',
                'description' => 'Light choux pastry filled with silky vanilla custard cream.',
                'product_picture' => 'puff_custard.png',
            ],
            [
                'id_store' => 1,
                'price' => 25000,
                'stock' => 22,
                'name_product' => 'Taro Cream Puff',
                'description' => 'Purple taro flavored cream puff with sweet taro filling.',
                'product_picture' => 'puff_taro.png',
            ],

            // Cookies & Brownies (Rp 8,000 - Rp 35,000)
            [
                'id_store' => 1,
                'price' => 8000,
                'stock' => 60,
                'name_product' => 'Chocolate Chip Cookie',
                'description' => 'Classic chewy cookie loaded with semi-sweet chocolate chips.',
                'product_picture' => 'cookie_choco.png',
            ],
            [
                'id_store' => 1,
                'price' => 10000,
                'stock' => 55,
                'name_product' => 'Matcha White Choco Cookie',
                'description' => 'Soft matcha cookie with white chocolate chunks.',
                'product_picture' => 'cookie_matcha.png',
            ],
            [
                'id_store' => 1,
                'price' => 12000,
                'stock' => 48,
                'name_product' => 'Red Velvet Cookie',
                'description' => 'Soft red velvet cookie with cream cheese frosting drizzle.',
                'product_picture' => 'cookie_redvelvet.png',
            ],
            [
                'id_store' => 1,
                'price' => 28000,
                'stock' => 20,
                'name_product' => 'Classic Fudge Brownie',
                'description' => 'Dense and fudgy brownie with a crackly top. Chocolate lover approved!',
                'product_picture' => 'brownie_classic.png',
            ],
            [
                'id_store' => 1,
                'price' => 35000,
                'stock' => 18,
                'name_product' => 'Salted Caramel Brownie',
                'description' => 'Rich brownie swirled with salted caramel sauce and sea salt flakes.',
                'product_picture' => 'brownie_caramel.png',
            ],

            // Ice Cream & Parfait (Rp 20,000 - Rp 35,000)
            [
                'id_store' => 1,
                'price' => 20000,
                'stock' => 25,
                'name_product' => 'Vanilla Soft Serve',
                'description' => 'Creamy soft serve vanilla ice cream in a waffle cone.',
                'product_picture' => 'icecream_vanilla.png',
            ],
            [
                'id_store' => 1,
                'price' => 35000,
                'stock' => 15,
                'name_product' => 'Berry Yogurt Parfait',
                'description' => 'Layered Greek yogurt with mixed berries and granola crunch.',
                'product_picture' => 'parfait_berry.png',
            ],

            // =============================================
            // PREMIUM BOX PRODUCTS (Price: Rp 50,000+)
            // =============================================

            // Premium Cakes (Rp 55,000 - Rp 95,000)
            [
                'id_store' => 1,
                'price' => 55000,
                'stock' => 18,
                'name_product' => 'Tiramisu Slice',
                'description' => 'Authentic Italian tiramisu with espresso-soaked ladyfingers and mascarpone cream.',
                'product_picture' => 'cake_tiramisu.png',
            ],
            [
                'id_store' => 1,
                'price' => 60000,
                'stock' => 15,
                'name_product' => 'Mango Mousse Cake',
                'description' => 'Light and airy mango mousse layered on vanilla sponge with fresh mango pieces.',
                'product_picture' => 'cake_mango.png',
            ],
            [
                'id_store' => 1,
                'price' => 65000,
                'stock' => 20,
                'name_product' => 'Black Forest Cake',
                'description' => 'Classic chocolate cake with cherry filling, whipped cream, and chocolate shavings.',
                'product_picture' => 'cake_blackforest.png',
            ],
            [
                'id_store' => 1,
                'price' => 70000,
                'stock' => 12,
                'name_product' => 'Lemon Meringue Tart',
                'description' => 'Tangy lemon curd in buttery tart shell topped with torched meringue.',
                'product_picture' => 'tart_lemon.png',
            ],
            [
                'id_store' => 1,
                'price' => 75000,
                'stock' => 14,
                'name_product' => 'Passion Fruit Cheesecake',
                'description' => 'Creamy cheesecake with tropical passion fruit topping and graham crust.',
                'product_picture' => 'cake_passion.png',
            ],
            [
                'id_store' => 1,
                'price' => 80000,
                'stock' => 10,
                'name_product' => 'Red Wine Chocolate Cake',
                'description' => 'Sophisticated chocolate cake infused with red wine and dark berries.',
                'product_picture' => 'cake_wine.png',
            ],
            [
                'id_store' => 1,
                'price' => 85000,
                'stock' => 12,
                'name_product' => 'Earl Grey Lavender Cake',
                'description' => 'Elegant tea-infused cake with lavender buttercream and edible flowers.',
                'product_picture' => 'cake_earlgrey.png',
            ],
            [
                'id_store' => 1,
                'price' => 95000,
                'stock' => 8,
                'name_product' => 'Opera Cake',
                'description' => 'French classic with layers of almond sponge, coffee buttercream, and chocolate ganache.',
                'product_picture' => 'cake_opera.png',
            ],

            // Premium Mille Crepes (Rp 50,000 - Rp 85,000)
            [
                'id_store' => 1,
                'price' => 50000,
                'stock' => 20,
                'name_product' => 'Vanilla Mille Crepes',
                'description' => 'Delicate layers of crepes with smooth vanilla pastry cream.',
                'product_picture' => 'crepes_vanilla.png',
            ],
            [
                'id_store' => 1,
                'price' => 55000,
                'stock' => 18,
                'name_product' => 'Chocolate Hazelnut Crepes',
                'description' => 'Rich chocolate cream layers with roasted hazelnut crumble.',
                'product_picture' => 'crepes_hazelnut.png',
            ],
            [
                'id_store' => 1,
                'price' => 65000,
                'stock' => 15,
                'name_product' => 'Strawberry Mille Crepes',
                'description' => 'Fresh strawberry cream between delicate crepe layers with strawberry glaze.',
                'product_picture' => 'crepes_strawberry.png',
            ],
            [
                'id_store' => 1,
                'price' => 85000,
                'stock' => 8,
                'name_product' => 'Durian Mille Crepes',
                'description' => 'Premium D24 durian cream layered between thin crepes. For durian lovers!',
                'product_picture' => 'crepes_durian.png',
            ],

            // Premium Tarts & Pies (Rp 75,000 - Rp 150,000)
            [
                'id_store' => 1,
                'price' => 75000,
                'stock' => 10,
                'name_product' => 'Fresh Fruit Tart',
                'description' => 'Buttery tart shell with custard cream and assorted fresh seasonal fruits.',
                'product_picture' => 'tart_fruit.png',
            ],
            [
                'id_store' => 1,
                'price' => 90000,
                'stock' => 8,
                'name_product' => 'Chocolate Truffle Tart',
                'description' => 'Decadent dark chocolate ganache in crispy chocolate tart shell.',
                'product_picture' => 'tart_truffle.png',
            ],
            [
                'id_store' => 1,
                'price' => 110000,
                'stock' => 6,
                'name_product' => 'Apple Rose Tart',
                'description' => 'Beautiful rose-shaped apple slices on almond frangipane with vanilla glaze.',
                'product_picture' => 'tart_apple.png',
            ],
            [
                'id_store' => 1,
                'price' => 150000,
                'stock' => 5,
                'name_product' => 'Mixed Berry Galette',
                'description' => 'Rustic French pastry with mixed berries, almond cream, and vanilla ice cream.',
                'product_picture' => 'galette_berry.png',
            ],

            // Luxury Items (Rp 180,000 - Rp 500,000)
            [
                'id_store' => 1,
                'price' => 180000,
                'stock' => 6,
                'name_product' => 'Pistachio Raspberry Cake',
                'description' => 'Pistachio sponge with raspberry compote and rose water buttercream.',
                'product_picture' => 'cake_pistachio.png',
            ],
            [
                'id_store' => 1,
                'price' => 250000,
                'stock' => 4,
                'name_product' => 'Japanese Souffle Cheesecake',
                'description' => 'Ultra-light and jiggly Japanese style cheesecake with powdered sugar.',
                'product_picture' => 'cake_souffle.png',
            ],
            [
                'id_store' => 1,
                'price' => 350000,
                'stock' => 3,
                'name_product' => 'Signature Celebration Cake',
                'description' => 'Custom decorated 3-layer cake with buttercream flowers and gold accents.',
                'product_picture' => 'cake_celebration.png',
            ],
            [
                'id_store' => 1,
                'price' => 500000,
                'stock' => 2,
                'name_product' => 'Grand Patisserie Box',
                'description' => 'Luxurious box containing 12 assorted premium pastries and petit fours.',
                'product_picture' => 'box_grand.png',
            ],
        ];

        // Insert products dan simpan ID-nya
        $insertedProductIds = [];
        foreach ($products as $product) {
            $id = DB::table('product')->insertGetId($product);
            $insertedProductIds[] = [
                'id' => $id,
                'price' => $product['price'],
                'stock' => $product['stock'],
            ];
        }

        $this->command->info('✅ Inserted ' . count($products) . ' new products.');

        // ============================================================
        // PART 2: INSERT MYSTERY BOX PRODUCT RELATIONS
        // ============================================================

        // Ambil existing products yang belum ada di mystery_box_product
        $existingProducts = DB::table('product')
            ->whereNotIn('id_product', function ($query) {
                $query->select('id_product')->from('mystery_box_product');
            })
            ->get();

        $normalBoxProducts = [];
        $premiumBoxProducts = [];

        // Kategorikan berdasarkan harga
        foreach ($existingProducts as $product) {
            if ($product->price < 50000) {
                $normalBoxProducts[] = $product;
            } else {
                $premiumBoxProducts[] = $product;
            }
        }

        // Insert Normal Box relations (id_mystery_box = 1)
        $normalInsertData = [];
        foreach ($normalBoxProducts as $product) {
            // Hitung drop rate awal berdasarkan stock (akan di-override oleh controller)
            $dropRate = 0.20; // Default
            
            $normalInsertData[] = [
                'id_mystery_box' => 1,
                'id_product' => $product->id_product,
                'price' => 15000, // Harga gacha normal
                'point_gacha' => 10,
                'history_gacha' => null,
                'type_gacha' => 'Normal',
                'drop_rate' => $dropRate,
                'cashback' => $product->price * 0.1, // 10% cashback
            ];
        }

        if (!empty($normalInsertData)) {
            DB::table('mystery_box_product')->insert($normalInsertData);
            $this->command->info('✅ Inserted ' . count($normalInsertData) . ' products to Normal Box.');
        }

        // Insert Premium Box relations (id_mystery_box = 2)
        $premiumInsertData = [];
        foreach ($premiumBoxProducts as $product) {
            $dropRate = 0.10; // Default untuk premium
            
            $premiumInsertData[] = [
                'id_mystery_box' => 2,
                'id_product' => $product->id_product,
                'price' => 25000, // Harga gacha premium
                'point_gacha' => 15,
                'history_gacha' => null,
                'type_gacha' => 'Premium',
                'drop_rate' => $dropRate,
                'cashback' => $product->price * 0.1, // 10% cashback
            ];
        }

        if (!empty($premiumInsertData)) {
            DB::table('mystery_box_product')->insert($premiumInsertData);
            $this->command->info('✅ Inserted ' . count($premiumInsertData) . ' products to Premium Box.');
        }

        // ============================================================
        // SUMMARY
        // ============================================================
        $this->command->info('');
        $this->command->info('========================================');
        $this->command->info('🎰 GACHA PRODUCT SEEDER COMPLETED!');
        $this->command->info('========================================');
        $this->command->info('Normal Box: ' . count($normalInsertData) . ' products');
        $this->command->info('Premium Box: ' . count($premiumInsertData) . ' products');
        $this->command->info('');
        $this->command->info('📝 Note: Drop rate akan dihitung dinamis');
        $this->command->info('   berdasarkan stock di Controller.');
        $this->command->info('   Formula: (stock / total_stock) * 100%');
        $this->command->info('========================================');
    }
}
