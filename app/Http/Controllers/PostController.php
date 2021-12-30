<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->filter(request(['search','category']));
        return view('posts', [
            'posts' => $posts->get(),
            'categories' => Category::all(),
            'currentCategory' => Category::firstWhere('slug', request('category'))
        ]);
    }

    public function show(Post $post)
    {
        return view('post',[
            'post' => $post
        ]);
    }
}
