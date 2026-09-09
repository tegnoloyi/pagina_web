<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class CustomerPasswordController extends Controller
{
    public function showForgot()
    {
        return view('customer.auth.forgot');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        // Siempre respondemos igual, exista o no el correo, para no revelar
        // qué correos están registrados (evita que alguien "escanee" cuentas).
        Password::broker('customers')->sendResetLink(
            $request->only('email')
        );

        return back()->with('status', 'Si ese correo tiene una cuenta, te enviamos un enlace para restablecer tu contraseña.');
    }

    public function showReset(Request $request, string $token)
    {
        return view('customer.auth.reset', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function reset(Request $request)
    {
        $data = $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $status = Password::broker('customers')->reset(
            $data,
            function ($customer, $password) {
                $customer->forceFill([
                    'password' => $password,
                ])->setRememberToken(Str::random(60));

                $customer->save();

                event(new PasswordReset($customer));

                Auth::guard('customer')->login($customer);
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            return back()->withErrors(['email' => __($status)]);
        }

        return redirect()->route('customer.orders.index')->with('status', 'Tu contraseña se actualizó y ya iniciaste sesión.');
    }
}
