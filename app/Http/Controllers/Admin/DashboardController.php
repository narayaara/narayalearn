<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Material;
use App\Models\Subject;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSubjects = Subject::count();
        $totalMaterials = Material::count();
        $totalUsers = User::count();

        $latestUsers = User::latest()->take(5)->get();
        $latestMaterials = Material::with('subject')->latest()->take(5)->get();

        $latestFavorites = Favorite::with(['user', 'material.subject', 'subject'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalSubjects',
            'totalMaterials',
            'totalUsers',
            'latestUsers',
            'latestMaterials',
            'latestFavorites'
        ));
    }
}