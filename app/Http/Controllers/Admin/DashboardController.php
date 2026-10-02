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
        $data = [
            'totalSubjects' => \App\Models\Subject::count(),
            'totalMaterials' => \App\Models\Material::count(),
            'totalUsers' => \App\Models\User::count(),
            'totalAvatars' => \App\Models\Avatar::count(),
            'latestUsers' => \App\Models\User::latest()->take(4)->get(),
            'latestMaterials' => \App\Models\Material::with('subject')->latest()->take(4)->get(),
        ];

        return view('admin.dashboard', $data);
    }
}