<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear Categorías
        $catPlayeras = Category::create([
            'name' => 'Playeras',
            'slug' => 'playeras',
            'image_url' => 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=600&auto=format&fit=crop&q=80'
        ]);

        $catPantalones = Category::create([
            'name' => 'Pantalones',
            'slug' => 'pantalones',
            'image_url' => 'https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?w=600&auto=format&fit=crop&q=80'
        ]);

        $catSudaderas = Category::create([
            'name' => 'Sudaderas',
            'slug' => 'sudaderas',
            'image_url' => 'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=600&auto=format&fit=crop&q=80'
        ]);

        $catAccesorios = Category::create([
            'name' => 'Accesorios',
            'slug' => 'accesorios',
            'image_url' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=600&auto=format&fit=crop&q=80'
        ]);

        // 2. Crear Productos y sus Variantes

        // --- PRODUCTO 1: Playera Minimalista Oversize ---
        $p1 = Product::create([
            'category_id' => $catPlayeras->id,
            'name' => 'Playera Oversize Essential',
            'description' => 'Confeccionada en algodón orgánico de alta densidad con un corte relajado y moderno. Ideal para el día a día manteniendo un look sofisticado.',
            'material' => '100% Algodón Peinado de 240 GSM. Lavar a máquina con agua fría.',
            'base_price' => 799.00,
            'old_price' => 999.00, // Activa el badge de descuento en la UI
            'is_new' => true,      // Activa el badge "Nuevo"
        ]);

        // Imágenes del producto 1
        ProductImage::create(['product_id' => $p1->id, 'url' => 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=800&auto=format&fit=crop&q=80', 'position' => 1]);
        ProductImage::create(['product_id' => $p1->id, 'url' => 'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?w=800&auto=format&fit=crop&q=80', 'position' => 2]);

        // Variantes (SKU, Talla, Color, Stock)
        $tallas = ['S', 'M', 'L'];
        $colores = [
            ['name' => 'Negro', 'hex' => '#111827'],
            ['name' => 'Blanco', 'hex' => '#F9FAFB'],
            ['name' => 'Arena', 'hex' => '#D4B996']
        ];

        foreach ($colores as $color) {
            foreach ($tallas as $talla) {
                ProductVariant::create([
                    'product_id' => $p1->id,
                    'sku' => 'ESS-' . strtoupper(substr($color['name'], 0, 3)) . '-' . $talla,
                    'size' => $talla,
                    'color' => $color['name'],
                    'color_hex' => $color['hex'],
                    'stock' => ($talla == 'M' && $color['name'] == 'Negro') ? 3 : rand(10, 25), // Simulando stock crítico en M Negro para el dashboard
                    'price' => 799.00
                ]);
            }
        }


        // --- PRODUCTO 2: Sudadera Minimalista con Cierre ---
        $p2 = Product::create([
            'category_id' => $catSudaderas->id,
            'name' => 'Sudadera Heavyweight Zip',
            'description' => 'Diseño estructurado con capucha de doble capa y herrajes metálicos mate. Comodidad absoluta con un acabado estético limpio.',
            'material' => '80% Algodón, 20% Poliéster afelpado interno.',
            'base_price' => 1699.00,
            'old_price' => null,
            'is_new' => true,
        ]);

        ProductImage::create(['product_id' => $p2->id, 'url' => 'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=800&auto=format&fit=crop&q=80', 'position' => 1]);
        
        foreach ($colores as $color) {
            ProductVariant::create([
                'product_id' => $p2->id,
                'sku' => 'ZIP-' . strtoupper(substr($color['name'], 0, 3)) . '-L',
                'size' => 'L',
                'color' => $color['name'],
                'color_hex' => $color['hex'],
                'stock' => 8,
                'price' => 1699.00
            ]);
        }
    }
}