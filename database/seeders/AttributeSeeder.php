<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AttributeSeeder extends Seeder
{
    public function run()
    {
        $attributes = [
            [
                'name' => 'Couleur',
                'type' => 'color',
                'is_filterable' => true,
                'is_required' => false,
                'sort_order' => 1,
                'values' => ['Rouge', 'Bleu', 'Vert', 'Noir', 'Blanc', 'Jaune']
            ],
            [
                'name' => 'Taille',
                'type' => 'select',
                'is_filterable' => true,
                'is_required' => false,
                'sort_order' => 2,
                'values' => ['XS', 'S', 'M', 'L', 'XL', 'XXL']
            ],
            [
                'name' => 'Matériau',
                'type' => 'select',
                'is_filterable' => true,
                'is_required' => false,
                'sort_order' => 3,
                'values' => ['Coton', 'Polyester', 'Laine', 'Soie', 'Lin', 'Cuir']
            ],
            [
                'name' => 'Capacité',
                'type' => 'select',
                'is_filterable' => true,
                'is_required' => false,
                'sort_order' => 4,
                'values' => ['250ml', '500ml', '1L', '2L', '5L']
            ],
            [
                'name' => 'Poids',
                'type' => 'number',
                'is_filterable' => false,
                'is_required' => false,
                'sort_order' => 5,
                'values' => []
            ],
            [
                'name' => 'Bio',
                'type' => 'boolean',
                'is_filterable' => true,
                'is_required' => false,
                'sort_order' => 6,
                'values' => []
            ],
            [
                'name' => 'Garantie',
                'type' => 'select',
                'is_filterable' => false,
                'is_required' => false,
                'sort_order' => 7,
                'values' => ['6 mois', '1 an', '2 ans', '3 ans', '5 ans']
            ],
            [
                'name' => 'Origine',
                'type' => 'select',
                'is_filterable' => true,
                'is_required' => false,
                'sort_order' => 8,
                'values' => ['France', 'Italie', 'Espagne', 'Allemagne', 'Tunisie', 'Maroc']
            ],
            [
                'name' => 'Parfum',
                'type' => 'multiselect',
                'is_filterable' => true,
                'is_required' => false,
                'sort_order' => 9,
                'values' => ['Lavande', 'Citron', 'Vanille', 'Menthe', 'Floral', 'Fruité']
            ],
            [
                'name' => 'Certification',
                'type' => 'multiselect',
                'is_filterable' => true,
                'is_required' => false,
                'sort_order' => 10,
                'values' => ['Ecocert', 'AB Bio', 'Label Rouge', 'AOC', 'IGP', 'Fair Trade']
            ],
        ];

        foreach ($attributes as $attributeData) {
            $attribute = Attribute::create([
                'name' => $attributeData['name'],
                'slug' => Str::slug($attributeData['name']),
                'type' => $attributeData['type'],
                'is_filterable' => $attributeData['is_filterable'],
                'is_required' => $attributeData['is_required'],
                'sort_order' => $attributeData['sort_order'],
            ]);

            // Créer les valeurs pour les attributs select/multiselect/color
            if (!empty($attributeData['values'])) {
                foreach ($attributeData['values'] as $index => $value) {
                    AttributeValue::create([
                        'attribute_id' => $attribute->id,
                        'value' => $value,
                        'sort_order' => $index + 1,
                    ]);
                }
            }
        }
    }
}
