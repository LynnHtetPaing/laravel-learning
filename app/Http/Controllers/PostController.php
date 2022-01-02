<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    public function index()
    {
        $post = Post::latest()->filter(request(['search','category','author']))->paginate(6)->withQueryString();
        return view('posts.index', [
            'posts' => $post,
        ]);
    }

    public function show(Post $post)
    {
        return view('posts.show',[
            'post' => $post
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }
}
