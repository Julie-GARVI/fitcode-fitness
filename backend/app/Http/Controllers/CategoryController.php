<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function list()
    {
        $categories = Category::all();

        return $categories;
    }


    // -------------------CATEGORIES UTILISATEUR--------------------------
    public function listUserCategories(User $user)
    {
        $categories = $user->categories;

        return response()->json($categories);
    }
}



