<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Material;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalSubjects' => Subject::count(),
            'totalMaterials' => Material::count(),
            'totalUsers' => User::count(),
            'totalComments' => Comment::count(),
            'latestUsers' => User::latest()->take(5)->get(),
            'latestMaterials' => Material::with('subject')->latest()->take(5)->get(),
            'latestComments' => Comment::with('user', 'material')->latest()->take(5)->get(),
        ];

        return view('admin.dashboard', $data);
    }
}