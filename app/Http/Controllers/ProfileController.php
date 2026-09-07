<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request): View
{
    $user = $request->user();
    $favorites = $user->favorites()->with('subject')->get();
    $comments = $user->comments()->with('material')->latest()->get();

    return view('profile.index', compact('user', 'favorites', 'comments'));
}
}
