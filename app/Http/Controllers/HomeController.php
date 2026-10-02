<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Material;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $totalTopics = Material::distinct()->pluck('title')->count();

        $data = [
            'totalSubjects' => Subject::count(),
            'totalTopics' => $totalTopics,
            'totalMaterials' => Material::count(),
            'totalUsers' => User::count(),

            'subjects' => Subject::withCount('materials')
                ->orderBy('materials_count', 'desc')
                ->take(6)
                ->get(),
        ];

        return view('home', $data);
    }
}