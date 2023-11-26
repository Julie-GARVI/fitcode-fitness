<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

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
}
