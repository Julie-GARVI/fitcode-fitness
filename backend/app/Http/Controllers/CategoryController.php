<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function list(Request $request)
    {
        if ($request->routeIs('category.coachs')) {

            $categories = Category::all();

            return $categories;

        } else if ($request->routeIs('category.users')) {

            // -------------------CATEGORIES UTILISATEUR--------------------------
            $categories = $user->categories;

            return response()->json($categories);
        }
    }     
}





