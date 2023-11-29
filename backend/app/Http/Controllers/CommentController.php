<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CommentController extends Controller
{
    public function list()
    {
        $comments = Comment::limit(6)->get();

        foreach ($comments as $comment) {
            $comment->user;
            $comment->exercice;
        }
        return $comments;
    }


    public function create(Request $request, $exerciceId)
    {

    $user = Auth::user();
    $userId = $user->id;

        try {
            $validator = Validator::make($request->all(), [
                'title' => ['required', 'regex:' . $this->regex],
                'rating' => 'required',
                'date' => 'required',
                'content' => ['required', 'regex:' . $this->regex]
            ]);
            $validator->validate();

        } catch (ValidationException $error) {

            return response()->json(['errors' => $error->errors()], 400);
        }

        $comment = new Comment();
        $comment->user_id = $userId;
        $comment->exercice_id = $exerciceId;
        $comment->title = $request->input('title');
        $comment->rating = $request->input('rating');
        $comment->date = $request->input('date');
        $comment->content = $request->input('content');

        $comment->save();

        return $comment;
    }
}
