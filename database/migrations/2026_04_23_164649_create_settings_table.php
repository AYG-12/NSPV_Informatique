<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key', 100)->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        $defaults = [
            'shop_name'               => 'NSPV Informatique',
            'shop_email'              => 'contact@nspv-informatique.ci',
            'shop_phone'              => '+225 07 00 00 00 00',
            'shop_address'            => "Abidjan, Côte d'Ivoire",
            'shop_description'        => "Votre partenaire de confiance pour l'informatique et les services numériques en Côte d'Ivoire.",
            'products_per_page'       => '24',
            'default_sort'            => 'latest',
            'show_reviews'            => '1',
            'show_stock'              => '1',
            'wishlist_enabled'        => '0',
            'free_shipping_threshold' => '50000',
            'shipping_delay'          => '1-3 jours ouvrés',
            'express_shipping'        => '1',
            'store_pickup'            => '1',
            'payment_mobile_money'    => '1',
            'payment_stripe'          => '1',
            'payment_paypal'          => '0',
            'payment_cod'             => '1',
            'notif_new_order'         => '1',
            'notif_low_stock'         => '1',
            'notif_new_review'        => '0',
            'notif_weekly_report'     => '1',
        ];

        foreach ($defaults as $key => $value) {
            DB::table('settings')->insert([
                'key'        => $key,
                'value'      => $value,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
