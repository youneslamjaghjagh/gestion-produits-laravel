<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatasetSeeder extends Seeder
{
    public function run(): void
    {
        // Chemin vers votre document exact
        $file = database_path('data/products.csv');

        if (!file_exists($file)) {
            $this->command->error("Le fichier CSV est introuvable à l'emplacement : " . $file);
            return;
        }

        $handle = fopen($file, 'r');

        // Lire la ligne d'en-tête pour récupérer les noms de vos colonnes
        $header = fgetcsv($handle, 2000, ',');

        if (!$header) {
            return;
        }

        $count = 0;

        // Lecture ligne par ligne de votre fichier
        while (($row = fgetcsv($handle, 2000, ',')) !== false) {
            if (count($header) !== count($row)) {
                continue;
            }

            $data = array_combine($header, $row);

            // 1. Création ou récupération de la catégorie
            $categoryName = trim($data['Category']);
            if (empty($categoryName)) {
                $categoryName = 'Non classé';
            }

            $category = Category::firstOrCreate(
                ['name' => $categoryName],
                ['slug' => Str::slug($categoryName)]
            );

            // 2. Création du produit
            Product::create([
                'category_id' => $category->id,
                'name'        => trim($data['Product Name']),
                'description' => trim($data['Brand Desc']),
                'price'       => floatval($data['SellPrice']),
                'stock'       => rand(5, 100),
                'image_path'  => null,
                'is_active'   => true,
            ]);

            $count++;
        }

        fclose($handle);
        $this->command->info("Super ! {$count} produits ont été importés avec succès depuis votre document !");
    }
}
