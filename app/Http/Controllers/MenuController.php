<?php
namespace App\Http\Controllers;

use App\Models\Category;

class MenuController extends Controller
{
    public function index()
    {
        $categories = Category::with('menus')->get(); // Ambil kategori beserta menu terkait
        return view('landing.menu', compact('categories'));
    }
}