<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerAuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::guard('customer')->check()) {
            return redirect()->route('customer.orders.index');
        }

        return view('customer.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Un cliente que solo compró como invitado (sin password) no puede
        // loguearse hasta que "active" su cuenta poniendo una contraseña.
        $customer = Customer::where('email', $credentials['email'])->first();

        if (! $customer || ! $customer->hasAccount() || ! Hash::check($credentials['password'], $customer->password)) {
            return back()
                ->withErrors(['email' => 'Credenciales incorrectas.'])
                ->onlyInput('email');
        }

        Auth::guard('customer')->login($customer, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->intended(route('customer.orders.index'));
    }

    public function showRegister()
    {
        if (Auth::guard('customer')->check()) {
            return redirect()->route('customer.orders.index');
        }

        return view('customer.auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:120'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Puede que ya exista un Customer creado por una compra de invitado
        // con ese correo; en ese caso solo le agregamos la contraseña.
        $customer = Customer::where('email', $data['email'])->first();

        if ($customer && $customer->hasAccount()) {
            return back()
                ->withErrors(['email' => 'Ya existe una cuenta con ese correo.'])
                ->onlyInput('email', 'name', 'phone');
        }

        if ($customer) {
            $customer->update([
                'name' => $data['name'],
                'phone' => $data['phone'] ?? $customer->phone,
                'password' => $data['password'],
            ]);
        } else {
            $customer = Customer::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'password' => $data['password'],
            ]);
        }

        Auth::guard('customer')->login($customer);
        $request->session()->regenerate();

        return redirect()->route('customer.orders.index');
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('shop.index');
    }
}
