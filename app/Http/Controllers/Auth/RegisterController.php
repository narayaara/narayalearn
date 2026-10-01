<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Avatar;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Tampilin form register, sekalian kirim daftar avatar preset.
     */
    public function showRegistrationForm()
    {
        $avatars = Avatar::latest()->get();

        return view('auth.register', compact('avatars'));
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'avatar_id' => ['nullable', 'exists:avatars,id'],
        ]);
    }

    protected function create(array $data)
    {
        $avatarFilename = null;

        if (!empty($data['avatar_id'])) {
            $avatar = Avatar::find($data['avatar_id']);
            $avatarFilename = $avatar?->filename;
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'avatar' => $avatarFilename,
        ]);
    }
}