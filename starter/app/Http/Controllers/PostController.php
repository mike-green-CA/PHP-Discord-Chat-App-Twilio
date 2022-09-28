<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:post');
    }

    public function all(Request $request)
    {
        $posts = Post::all();

        return response()->json([
            'wishes' => $posts
        ]);
    }

    public function wishes(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);

        $posts = Post::where('user_id',  $request->input('id'))->get();

        foreach($posts as $post)
        {
            $post->author         = $post->user->name;
            $post->author_picture = $post->user->picture;
        }

        return response()->json([
            'wishes' => $posts
        ]);
    }

    public function new(Request $request)
    {
        $request->validate([
            'title'     => ['required', 'regex:/[a-z ]+$/i'],
            'wish'      => ['required', 'regex:/[a-z0-9 ,\.\?!]$/i'],
        ]);

        $allParams = $request->all();

        $post = new Post();
        $post->user_id  = Auth::id();
        $post->title    = $allParams['title'];
        $post->wish     = $allParams['wish'];

        $post->save();

        return response()->json(['status'=>'saved']);
    }
}
