<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class CommentController extends Controller
{

//-----------------------------Commentaires HOME--------------------------------
    public function list(Request $request, $exerciceId = null)
{
    if ($request->routeIs('comments.home')) {
        $comments = Comment::limit(6)->get();

        foreach ($comments as $comment) {
            $comment->user;
            $comment->exercice;
        }

        return $comments;
    }

//--------------------------Commentaires EXERCICE--------------------------------
    if ($request->routeIs('comments.exercice')) {

        $perPage = 4;
        $page = $request->input('page', 1);

        $comments = Comment::where('exercice_id', $exerciceId)
            ->orderBy('id', 'desc')
            ->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->where('id', '>', 6)
            ->get();

        foreach ($comments as $comment) {
            $comment->user;
        }

        return $comments;
    }
}


//------------------------Création d'un commentaire--------------------------------
public function create(Request $request, $exerciceId)
  {
    try {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'regex:' . $this->regex],
            'rating' => ['required', 'min:1', 'integer'],
            'content' => ['required', 'regex:' . $this->regex]
        ]);
        $validator->validate();
    } catch (ValidationException $error) {
        return response()->json(['errors' => $error->errors()], 400);
    }

    $currentDate = Carbon::now();

    $comment = new Comment();
    $comment->exercice_id = $exerciceId;
    $comment->title = $request->input('title');
    $comment->rating = $request->input('rating');
    $comment->content = $request->input('content');

    $comment->date = $currentDate->toDateString();;

    $comment->user()->associate(auth()->user());

    $comment->save();

    return $comment;
  }


//------------------------Supprimer un commentaire--------------------------------
  public function delete($id)
  {

    $user = Auth::user();
    $userId = $user->id;

      $comment = Comment::where('user_id', $userId)->find($id);
      $comment->delete();

      return response()->json(['message' => 'Comment deleted']);
  }
}


