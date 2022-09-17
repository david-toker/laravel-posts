<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        // $posts = Post::get();
        // $posts = Post::orderBy('created_at', 'desc')->with(['user', 'likes'])->paginate(2);
        $posts = Post::latest()->with(['user', 'likes'])->paginate(2);

        return response($posts);
    }

    public function show(Post $post)
    {
        return response($post);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);

        // 1 way create relation post
        // Post::create([
        //     'user_id' => auth()->id(),
        //     'body' => $request->body
        // ]);

        // 2 way to create realtions post (best)
        // $createdPost = $request->user()->posts()->create([
        //     'body'  => $request->body
        // ]);

        // 3 way to create realtions post (2 way improved)
        $createdPost = $request->user()->posts()->create($request ->only('body'));

        return response($createdPost, 201);
    }

    public function destroy(Post $post)
    {
        // This condition replaced by Policy
        // if (!$post->ownedBy(auth()->user())) {
        //     return response(null, 403);
        // }

        $this->authorize('delete', $post);
        $post->delete();
    }
}
