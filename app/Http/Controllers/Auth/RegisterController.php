<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewUserRegisteredNotification;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {   
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        Auth::login($user); // login otomatis setelah register

        return $this->redirectToBasedOnRole($user);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nama'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role'     => ['required', 'in:admin,rt,rw,warga'],
        ]);
    }

    protected function create(array $data): User
    {
        $user = User::create([
            'nama' => $data['nama'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'status_akun' => 'pending',
        ]);

        // Kirim notifikasi ke semua pengguna RT/RW/Admin
        $rtAdmins = User::whereIn('role', ['rt', 'rw', 'admin'])->get();
        foreach ($rtAdmins as $admin) {
            // $admin->notify(new NewUserRegisteredNotification($user));
        }

        return $user;
    }

    protected function redirectToBasedOnRole(User $user)
    {
        return match ($user->role) {
            'admin' => redirect()->route('dashboard'),
            'rt', 'rw' => redirect()->route('dashboard'),
            default => redirect('/login'),
        };
    }
}

