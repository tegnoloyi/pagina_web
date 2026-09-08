<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function __construct(protected CartService $cart)
    {
    }

    public function show()
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('cart.index')->with('status', 'Tu carrito está vacío.');
        }

        $customer = Auth::guard('customer')->user();

        return view('checkout.show', [
            'lines' => $this->cart->lines(),
            'subtotal' => $this->cart->subtotal(),
            'shippingCost' => (float) config('shop.shipping_cost'),
            'customer' => $customer,
        ]);
    }

    public function store(Request $request)
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('cart.index')->with('status', 'Tu carrito está vacío.');
        }

        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:120'],
            'customer_email' => ['required', 'email', 'max:120'],
            'customer_phone' => ['nullable', 'string', 'max:20'],
            'shipping_address' => ['required', 'string', 'max:255'],
            'shipping_city' => ['required', 'string', 'max:100'],
            'shipping_state' => ['required', 'string', 'max:100'],
            'shipping_zip' => ['required', 'string', 'max:15'],
            'payment_method' => ['required', 'in:' . implode(',', Order::PAYMENT_METHODS)],
            'notes' => ['nullable', 'string', 'max:1000'],
            // Checkout de invitado con opción de crear cuenta en el mismo paso
            'create_account' => ['nullable', 'boolean'],
            'password' => ['nullable', 'required_if:create_account,1', 'string', 'min:8', 'confirmed'],
        ]);

        $authCustomer = Auth::guard('customer')->user();

        try {
            $order = DB::transaction(function () use ($data, $authCustomer) {
                $lines = $this->cart->lines();

                if ($lines->isEmpty()) {
                    throw ValidationException::withMessages([
                        'cart' => 'Tu carrito está vacío.',
                    ]);
                }

                // Bloqueamos las variantes involucradas para evitar sobreventa
                // si dos personas compran lo último en existencia al mismo tiempo.
                $variantIds = $lines->pluck('variant.id');
                $lockedVariants = ProductVariant::whereIn('id', $variantIds)
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id');

                $subtotal = 0;
                $itemsToCreate = [];

                foreach ($lines as $line) {
                    $variant = $lockedVariants->get($line['variant']->id);

                    if (! $variant || $variant->stock < $line['qty']) {
                        throw ValidationException::withMessages([
                            'cart' => "Ya no hay stock suficiente de \"{$line['variant']->sku}\". Ajusta tu carrito.",
                        ]);
                    }

                    $price = (float) ($variant->price ?? $variant->product->base_price);
                    $subtotal += $price * $line['qty'];

                    $itemsToCreate[] = [
                        'variant' => $variant,
                        'qty' => $line['qty'],
                        'unit_price' => $price,
                    ];
                }

                $subtotal = round($subtotal, 2);
                $shipping = (float) config('shop.shipping_cost');
                $total = round($subtotal + $shipping, 2);

                // Cliente: si está logueado usamos su cuenta; si no, buscamos
                // por correo (pudo haber comprado antes como invitado) o
                // creamos un registro nuevo. Si pidió crear cuenta, le
                // asignamos password.
                $customer = $authCustomer;

                if (! $customer) {
                    $customer = Customer::where('email', $data['customer_email'])->first();

                    if (! $customer) {
                        $customer = new Customer();
                    }

                    $customer->name = $data['customer_name'];
                    $customer->email = $data['customer_email'];
                    $customer->phone = $data['customer_phone'] ?? $customer->phone;

                    if (! empty($data['create_account']) && ! $customer->hasAccount()) {
                        $customer->password = $data['password'];
                    }

                    $customer->save();
                }

                $isCardPayment = $data['payment_method'] === 'tarjeta';

                $order = Order::create([
                    'customer_id' => $customer->id,
                    'customer_name' => $data['customer_name'],
                    'customer_email' => $data['customer_email'],
                    'customer_phone' => $data['customer_phone'] ?? null,
                    'shipping_address' => $data['shipping_address'],
                    'shipping_city' => $data['shipping_city'],
                    'shipping_state' => $data['shipping_state'],
                    'shipping_zip' => $data['shipping_zip'],
                    'payment_method' => $data['payment_method'],
                    // "tarjeta" se procesa (simulado) al instante; efectivo y
                    // transferencia quedan pendientes de confirmación manual
                    // por el admin. Este es el punto de integración para una
                    // pasarela real (Stripe/Mercado Pago) más adelante.
                    'is_paid' => $isCardPayment,
                    'paid_at' => $isCardPayment ? now() : null,
                    'status' => $isCardPayment ? 'pagado' : 'pendiente',
                    'notes' => $data['notes'] ?? null,
                    'subtotal' => $subtotal,
                    'shipping' => $shipping,
                    'total' => $total,
                ]);

                foreach ($itemsToCreate as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'variant_id' => $item['variant']->id,
                        'qty' => $item['qty'],
                        'unit_price' => $item['unit_price'],
                    ]);

                    $item['variant']->decrement('stock', $item['qty']);
                }

                return $order;
            });
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }

        $this->cart->clear();
        session(['last_order_id' => $order->id]);

        return redirect()->route('checkout.confirmation', $order);
    }

    public function confirmation(Order $order)
    {
        $customer = Auth::guard('customer')->user();

        $ownsOrder = session('last_order_id') === $order->id
            || ($customer && $order->customer_id === $customer->id);

        abort_unless($ownsOrder, 403);

        return view('checkout.confirmation', [
            'order' => $order->load('items.variant.product'),
        ]);
    }
}
