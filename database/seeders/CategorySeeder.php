<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Alimentation',
                'slug' => 'alimentation',
                'description' => 'Produits alimentaires divers',
                'children' => [
                    ['name' => 'Épicerie salée', 'slug' => 'epicerie-salee'],
                    ['name' => 'Épicerie sucrée', 'slug' => 'epicerie-sucree'],
                    ['name' => 'Conserves', 'slug' => 'conserves'],
                    ['name' => 'Boissons', 'slug' => 'boissons'],
                ]
            ],
            [
                'name' => 'Hygiène & Beauté',
                'slug' => 'hygiene-beaute',
                'description' => 'Produits d\'hygiène et de beauté',
                'children' => [
                    ['name' => 'Soins du corps', 'slug' => 'soins-corps'],
                    ['name' => 'Soins du visage', 'slug' => 'soins-visage'],
                    ['name' => 'Parfumerie', 'slug' => 'parfumerie'],
                ]
            ],
            [
                'name' => 'Entretien',
                'slug' => 'entretien',
                'description' => 'Produits d\'entretien ménager',
                'children' => [
                    ['name' => 'Nettoyage sols', 'slug' => 'nettoyage-sols'],
                    ['name' => 'Vaisselle', 'slug' => 'vaisselle'],
                    ['name' => 'Lessive', 'slug' => 'lessive'],
                ]
            ],
            [
                'name' => 'Électronique',
                'slug' => 'electronique',
                'description' => 'Appareils électroniques',
                'children' => [
                    ['name' => 'Téléphones', 'slug' => 'telephones'],
                    ['name' => 'Accessoires', 'slug' => 'accessoires'],
                ]
            ],
        ];

        foreach ($categories as $index => $categoryData) {
            $category = Category::create([
                'name' => $categoryData['name'],
                'slug' => $categoryData['slug'],
                'description' => $categoryData['description'] ?? null,
                'sort_order' => $index + 1,
                'is_active' => true,
                'level' => 0,
            ]);

            if (isset($categoryData['children'])) {
                foreach ($categoryData['children'] as $childIndex => $child) {
                    Category::create([
                        'name' => $child['name'],
                        'slug' => $child['slug'],
                        'description' => $child['description'] ?? null,
                        'parent_id' => $category->id,
                        'sort_order' => $childIndex + 1,
                        'is_active' => true,
                        'level' => 1,
                    ]);
                }
            }
        }
    }
}