<?php

namespace Database\Seeders;

use App\Models\CustomerGroup;
use App\Models\User;
use Illuminate\Database\Seeder;

class CustomerGroupSeeder extends Seeder
{
    public function run()
    {
        // Créer les groupes de clients
        $groups = [
            [
                'name' => 'VIP',
                'description' => 'Clients VIP avec remise privilégiée',
                'discount_percentage' => 15.00,
            ],
            [
                'name' => 'Grosses commandes',
                'description' => 'Clients avec volume d\'achat important',
                'discount_percentage' => 10.00,
            ],
            [
                'name' => 'Partenaires privilégiés',
                'description' => 'Partenaires commerciaux de longue date',
                'discount_percentage' => 12.00,
            ],
            [
                'name' => 'Standard',
                'description' => 'Clients standard sans remise particulière',
                'discount_percentage' => 0.00,
            ],
        ];

        foreach ($groups as $groupData) {
            CustomerGroup::create($groupData);
        }

        // Assigner quelques vendeurs aux groupes
        $vendeurs = User::where('role', 'vendeur')->get();
        $groups = CustomerGroup::all();

        if ($vendeurs->count() > 0 && $groups->count() > 0) {
            // Premier vendeur en VIP
            if ($vendeurs->count() > 0) {
                $vendeurs[0]->customerGroups()->attach($groups->where('name', 'VIP')->first()->id);
            }

            // Deuxième vendeur en Grosses commandes
            if ($vendeurs->count() > 1) {
                $vendeurs[1]->customerGroups()->attach($groups->where('name', 'Grosses commandes')->first()->id);
            }

            // Troisième vendeur en Partenaires privilégiés
            if ($vendeurs->count() > 2) {
                $vendeurs[2]->customerGroups()->attach($groups->where('name', 'Partenaires privilégiés')->first()->id);
            }

            // Quatrième vendeur en Standard
            if ($vendeurs->count() > 3) {
                $vendeurs[3]->customerGroups()->attach($groups->where('name', 'Standard')->first()->id);
            }
        }
    }
}