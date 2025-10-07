<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Créer le grossiste principal
        User::create([
            'name' => 'Grossiste Principal',
            'email' => 'grossiste@b2b.com',
            'password' => Hash::make('password'),
            'role' => 'grossiste',
            'company_name' => 'Société de Gros',
            'phone' => '+216 12 345 678',
            'address' => '123 Rue des Grossistes',
            'city' => 'Tunis',
            'postal_code' => '1000',
            'is_active' => true,
            'preferred_language' => 'fr',
        ]);

        // Créer quelques vendeurs de test
        $vendeurs = [
            [
                'name' => 'Ahmed Ben Mohamed',
                'email' => 'ahmed@vendeur1.com',
                'company_name' => 'Magasin Ahmed',
                'city' => 'Sfax',
            ],
            [
                'name' => 'Fatma Trabelsi',
                'email' => 'fatma@vendeur2.com',
                'company_name' => 'Boutique Fatma',
                'city' => 'Sousse',
            ],
            [
                'name' => 'Mohamed Ali',
                'email' => 'ali@vendeur3.com',
                'company_name' => 'Épicerie Ali',
                'city' => 'Monastir',
            ],
            [
                'name' => 'Salma Karray',
                'email' => 'salma@vendeur4.com',
                'company_name' => 'Commerce Salma',
                'city' => 'Gabès',
            ],
        ];

        foreach ($vendeurs as $index => $vendeur) {
            User::create([
                'name' => $vendeur['name'],
                'email' => $vendeur['email'],
                'password' => Hash::make('password'),
                'role' => 'vendeur',
                'company_name' => $vendeur['company_name'],
                'phone' => '+216 ' . (20 + $index) . ' 123 456',
                'address' => 'Adresse ' . $vendeur['company_name'],
                'city' => $vendeur['city'],
                'postal_code' => (1000 + $index * 100),
                'is_active' => true,
                'preferred_language' => $index % 2 === 0 ? 'fr' : 'ar',
            ]);
        }
    }
}