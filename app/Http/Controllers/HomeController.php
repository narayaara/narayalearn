<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Material;
use App\Models\User;
use App\Models\Comment;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            // Statistik
            'totalSubjects' => Subject::count(),
            'totalMaterials' => Material::count(),
            'totalUsers' => User::count(),
            'totalComments' => Comment::count(),

            // Subject populer (top 4 berdasarkan jumlah materi)
            'popularSubjects' => Subject::withCount('materials')
                ->orderBy('materials_count', 'desc')
                ->take(4)
                ->get(),

            // Konten terbaru (top 3)
            'latestMaterials' => Material::with('subject')
                ->latest()
                ->take(3)
                ->get(),
        ];

        return view('home', $data);
    }
}