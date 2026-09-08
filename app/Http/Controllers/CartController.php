<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(protected CartService $cart)
    {
    }

    public function index()
    {
        $lines = $this->cart->lines();

        return view('cart.index', [
            'lines' => $lines,
            'subtotal' => $this->cart->subtotal(),
        ]);
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'variant_id' => ['required', 'integer', 'exists:product_variants,id'],
            'qty' => ['nullable', 'integer', 'min:1', 'max:50'],
        ]);

        $variant = ProductVariant::findOrFail($data['variant_id']);
        $qty = $data['qty'] ?? 1;

        if ($variant->stock < $qty) {
            return back()->withErrors(['qty' => 'No hay suficiente stock disponible para esa cantidad.']);
        }

        $this->cart->add($variant->id, $qty);

        return back()->with('status', 'Producto agregado al carrito.');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'variant_id' => ['required', 'integer'],
            'qty' => ['required', 'integer', 'min:0', 'max:50'],
        ]);

        $this->cart->update($data['variant_id'], $data['qty']);

        return back()->with('status', 'Carrito actualizado.');
    }

    public function remove(Request $request)
    {
        $data = $request->validate([
            'variant_id' => ['required', 'integer'],
        ]);

        $this->cart->remove($data['variant_id']);

        return back()->with('status', 'Producto eliminado del carrito.');
    }
}
