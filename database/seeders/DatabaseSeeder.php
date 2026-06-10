<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::firstOrCreate(
            ['email' => 'admin@nspv.com'],
            ['name' => 'Admin NSPV', 'password' => Hash::make('password'), 'role' => 'admin']
        );

        // Catégories
        $cats = [
            ['name' => 'Ordinateurs', 'slug' => 'ordinateurs', 'description' => 'PC portables et de bureau'],
            ['name' => 'Accessoires', 'slug' => 'accessoires', 'description' => 'Claviers, souris, câbles...'],
            ['name' => 'Composants',  'slug' => 'composants',  'description' => 'RAM, SSD, processeurs...'],
            ['name' => 'Services',    'slug' => 'services',    'description' => 'Maintenance et installation'],
            ['name' => 'Téléphones',  'slug' => 'telephones',  'description' => 'Smartphones et accessoires'],
        ];
        foreach ($cats as $c) {
            Category::firstOrCreate(['slug' => $c['slug']], $c);
        }

        $ordinateurs = Category::where('slug', 'ordinateurs')->first();
        $accessoires  = Category::where('slug', 'accessoires')->first();
        $composants   = Category::where('slug', 'composants')->first();
        $services     = Category::where('slug', 'services')->first();
        $telephones   = Category::where('slug', 'telephones')->first();

        // Produits
        $products = [
            [
                'category_id' => $ordinateurs->id, 'type' => 'product',
                'name' => 'PC Portable HP EliteBook 840', 'slug' => 'pc-portable-hp-elitebook-840',
                'short_description' => 'Intel Core i5, 8 Go RAM, 256 Go SSD',
                'description' => 'Ordinateur portable professionnel HP EliteBook 840 G8, processeur Intel Core i5.',
                'price' => 450000, 'sale_price' => 399000, 'stock' => 5,
                'is_active' => true, 'is_featured' => true, 'sku' => 'HP-EB840-01',
            ],
            [
                'category_id' => $ordinateurs->id, 'type' => 'product',
                'name' => 'PC Bureau Dell OptiPlex 7080', 'slug' => 'pc-bureau-dell-optiplex-7080',
                'short_description' => 'Intel Core i7, 16 Go RAM, 512 Go SSD',
                'description' => 'PC de bureau Dell OptiPlex 7080, processeur Intel Core i7-10700.',
                'price' => 550000, 'sale_price' => null, 'stock' => 3,
                'is_active' => true, 'is_featured' => true, 'sku' => 'DL-OP7080-01',
            ],
            [
                'category_id' => $accessoires->id, 'type' => 'product',
                'name' => 'Clavier Mécanique Logitech K845', 'slug' => 'clavier-mecanique-logitech-k845',
                'short_description' => 'Clavier filaire TKL, switches Cherry MX Red',
                'description' => 'Clavier mécanique compact Logitech K845, rétroéclairage blanc.',
                'price' => 45000, 'sale_price' => null, 'stock' => 20,
                'is_active' => true, 'is_featured' => false, 'sku' => 'LG-K845-01',
            ],
            [
                'category_id' => $accessoires->id, 'type' => 'product',
                'name' => 'Souris Gaming Logitech G502', 'slug' => 'souris-gaming-logitech-g502',
                'short_description' => 'Souris filaire haute précision, 25 600 DPI',
                'description' => 'Souris gaming Logitech G502 HERO, 11 boutons programmables.',
                'price' => 38000, 'sale_price' => 32000, 'stock' => 15,
                'is_active' => true, 'is_featured' => true, 'sku' => 'LG-G502-01',
            ],
            [
                'category_id' => $composants->id, 'type' => 'product',
                'name' => 'SSD Samsung 860 EVO 1To', 'slug' => 'ssd-samsung-860-evo-1to',
                'short_description' => 'SSD SATA 2.5", 560 Mo/s en lecture',
                'description' => 'SSD Samsung 860 EVO 1 To, interface SATA III.',
                'price' => 65000, 'sale_price' => null, 'stock' => 10,
                'is_active' => true, 'is_featured' => false, 'sku' => 'SS-860EVO-1T',
            ],
            [
                'category_id' => $services->id, 'type' => 'service',
                'name' => 'Installation & Configuration PC', 'slug' => 'installation-configuration-pc',
                'short_description' => 'Installation Windows, drivers et logiciels',
                'description' => 'Installation complète de Windows 10/11, drivers, configuration réseau.',
                'price' => 15000, 'sale_price' => null, 'stock' => null,
                'is_active' => true, 'is_featured' => true, 'sku' => 'SV-INSTALL-01',
            ],
            [
                'category_id' => $services->id, 'type' => 'service',
                'name' => 'Maintenance & Nettoyage PC', 'slug' => 'maintenance-nettoyage-pc',
                'short_description' => 'Nettoyage complet, changement pâte thermique',
                'description' => 'Maintenance préventive : nettoyage interne, changement de la pâte thermique.',
                'price' => 10000, 'sale_price' => null, 'stock' => null,
                'is_active' => true, 'is_featured' => false, 'sku' => 'SV-MAINT-01',
            ],
            [
                'category_id' => $telephones->id, 'type' => 'product',
                'name' => 'Samsung Galaxy A54 5G', 'slug' => 'samsung-galaxy-a54-5g',
                'short_description' => '128 Go, 8 Go RAM, écran 6.4" Super AMOLED',
                'description' => 'Samsung Galaxy A54 5G, Exynos 1380, triple caméra 50 MP.',
                'price' => 280000, 'sale_price' => 250000, 'stock' => 8,
                'is_active' => true, 'is_featured' => true, 'sku' => 'SS-GA54-01',
            ],
        ];

        foreach ($products as $data) {
            Product::firstOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
