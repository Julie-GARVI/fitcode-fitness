<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

// La méthode list récupère la base de données categories
    public function list()
    {
        $categories = Category::all();

        return $categories;
    }
}
