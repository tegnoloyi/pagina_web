<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['category', 'images', 'variants'])
            ->search($request->input('search'))
            ->when($request->input('category'), fn ($q, $cat) => $q->where('category_id', $cat))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $product = new Product();
        $product->setRelation('variants', collect());
        $product->setRelation('images', collect());

        return view('admin.products.form', compact('product', 'categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validateProduct($request);

        $product = DB::transaction(function () use ($data, $request) {
            $product = Product::create($data['product']);

            $this->syncVariants($product, $data['variants']);
            $this->storeNewImages($product, $request);

            return $product;
        });

        return redirect()->route('admin.products.edit', $product)->with('status', 'Producto creado.');
    }

    public function edit(Product $product)
    {
        $product->load(['variants', 'images']);
        $categories = Category::orderBy('name')->get();

        return view('admin.products.form', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validateProduct($request);

        DB::transaction(function () use ($product, $data, $request) {
            $product->update($data['product']);

            $this->syncVariants($product, $data['variants']);
            $this->storeNewImages($product, $request);
            $this->deleteRequestedImages($request);
        });

        return redirect()->route('admin.products.edit', $product)->with('status', 'Producto actualizado.');
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $image) {
            $this->deleteImageFile($image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('status', 'Producto eliminado.');
    }

    protected function validateProduct(Request $request): array
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string'],
            'material' => ['nullable', 'string'],
            'base_price' => ['required', 'numeric', 'min:0'],
            'old_price' => ['nullable', 'numeric', 'min:0'],
            'is_new' => ['nullable', 'boolean'],

            'variants' => ['nullable', 'array'],
            'variants.*.id' => ['nullable', 'integer', 'exists:product_variants,id'],
            'variants.*.sku' => ['required_with:variants', 'string', 'max:60'],
            'variants.*.size' => ['required_with:variants', 'string', 'max:10'],
            'variants.*.color' => ['required_with:variants', 'string', 'max:30'],
            'variants.*.color_hex' => ['nullable', 'string', 'max:7'],
            'variants.*.stock' => ['required_with:variants', 'integer', 'min:0'],
            'variants.*.price' => ['nullable', 'numeric', 'min:0'],

            'images.*' => ['nullable', 'image', 'max:4096'],
            'image_urls' => ['nullable', 'array'],
            'image_urls.*' => ['nullable', 'url'],
            'delete_images' => ['nullable', 'array'],
        ]);

        return [
            'product' => [
                'category_id' => $validated['category_id'],
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'material' => $validated['material'] ?? null,
                'base_price' => $validated['base_price'],
                'old_price' => $validated['old_price'] ?? null,
                'is_new' => $request->boolean('is_new'),
            ],
            'variants' => $validated['variants'] ?? [],
        ];
    }

    /**
     * Crea/actualiza las variantes enviadas y borra las que ya no vienen
     * en el formulario (patrón "reemplazar por lo enviado").
     */
    protected function syncVariants(Product $product, array $variants): void
    {
        $keepIds = [];

        foreach ($variants as $row) {
            $variant = $product->variants()->updateOrCreate(
                ['id' => $row['id'] ?? null],
                [
                    'sku' => $row['sku'],
                    'size' => $row['size'],
                    'color' => $row['color'],
                    'color_hex' => $row['color_hex'] ?? null,
                    'stock' => $row['stock'],
                    'price' => $row['price'] ?? null,
                ]
            );

            $keepIds[] = $variant->id;
        }

        ProductVariant::where('product_id', $product->id)
            ->whereNotIn('id', $keepIds)
            ->delete();
    }

    protected function storeNewImages(Product $product, Request $request): void
    {
        $position = $product->images()->max('position') ?? 0;

        foreach ($request->file('images', []) as $file) {
            if (! $file) {
                continue;
            }

            $path = $file->store('products', 'public');

            $product->images()->create([
                'url' => Storage::url($path),
                'position' => ++$position,
            ]);
        }

        foreach ($request->input('image_urls', []) as $url) {
            if (blank($url)) {
                continue;
            }

            $product->images()->create([
                'url' => $url,
                'position' => ++$position,
            ]);
        }
    }

    protected function deleteRequestedImages(Request $request): void
    {
        $ids = $request->input('delete_images', []);

        if (empty($ids)) {
            return;
        }

        $images = ProductImage::whereIn('id', $ids)->get();

        foreach ($images as $image) {
            $this->deleteImageFile($image);
            $image->delete();
        }
    }

    protected function deleteImageFile(ProductImage $image): void
    {
        // Solo borramos el archivo físico si la imagen vive en nuestro
        // disco público (las que son URLs externas no se tocan).
        if (str_starts_with($image->url, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $image->url));
        }
    }
}
