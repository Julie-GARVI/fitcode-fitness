<?php

namespace App\Http\Controllers;

use App\Models\Multimedia;
use Illuminate\Http\Request;

class MultimediaController extends Controller
{

    // Recopier la fonction list et ne pas oublier d'établir les mêmes relations dans les models catégories et multimédias
    public function list()
{
    $multimedias = Multimedia::with('category')->take(4)->get();

    foreach ($multimedias as $multimedia) {
        $multimedia->category;
        $multimedia->multimedia;
    }

    return $multimedias;
}

}
