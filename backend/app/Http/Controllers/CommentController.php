<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class CommentController extends Controller
{
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

    if ($request->routeIs('comments.exercice')) {

        $comments = Comment::where('exercice_id', $exerciceId)
            ->where('id', '>', 6)
            ->get();

        foreach ($comments as $comment) {
            $comment->user;
        }

        return $comments;
    }
}


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
}


