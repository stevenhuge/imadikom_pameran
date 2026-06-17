<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:voter,participant'],
        ];

        if ($request->role === 'participant') {
            $rules['nim'] = ['required', 'string', 'max:20', 'unique:users,nim'];
        }

        $request->validate($rules, [
            'nim.required' => 'NIM wajib diisi jika mendaftar sebagai peserta.',
            'nim.unique' => 'NIM ini sudah terdaftar sebagai akun peserta.',
        ]);

        $isBidikmisi = false;
        if ($request->role === 'participant') {
            $isBidikmisi = \Illuminate\Support\Facades\DB::table('bidikmisi_members')
                ->where('nim', $request->nim)
                ->exists();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'nim' => $request->role === 'participant' ? $request->nim : null,
            'is_bidikmisi' => $isBidikmisi,
        ]);

        event(new Registered($user));

        Auth::login($user);

        if ($user->role === 'participant') {
            return redirect()->route('participant.dashboard');
        }

        return redirect(route('home', absolute: false));
    }
}
