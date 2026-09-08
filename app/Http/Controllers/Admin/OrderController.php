<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('customer')
            ->when($request->input('status'), fn ($q, $status) => $q->where('status', $status))
            ->when($request->input('search'), function ($q, $term) {
                $q->where(function ($q) use ($term) {
                    $q->where('customer_name', 'like', "%{$term}%")
                      ->orWhere('customer_email', 'like', "%{$term}%")
                      ->orWhere('id', $term);
                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.orders.index', [
            'orders' => $orders,
            'statuses' => Order::STATUSES,
        ]);
    }

    public function show(Order $order)
    {
        $order->load('items.variant.product', 'customer');

        return view('admin.orders.show', [
            'order' => $order,
            'statuses' => Order::STATUSES,
        ]);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', 'in:' . implode(',', Order::STATUSES)],
        ]);

        $order->status = $data['status'];

        if ($data['status'] === 'cancelado' && $order->is_paid) {
            // No revertimos el pago automáticamente: eso lo maneja el admin
            // por fuera si hay que hacer un reembolso real.
        }

        $order->save();

        return back()->with('status', 'Estatus del pedido actualizado.');
    }

    public function markPaid(Order $order)
    {
        $order->markAsPaid();

        return back()->with('status', 'Pedido marcado como pagado.');
    }
}
