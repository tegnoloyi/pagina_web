<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $customer = Auth::guard('customer')->user();

        $orders = $customer->orders()->latest()->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    public function show(int $id)
    {
        $customer = Auth::guard('customer')->user();

        $order = $customer->orders()
            ->with('items.variant.product')
            ->findOrFail($id);

        return view('customer.orders.show', compact('order'));
    }
}
