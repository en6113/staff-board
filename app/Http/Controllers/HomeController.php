<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $newsItems = News::latest()->get();
        $posts = Post::latest()->get();

        return view('home', ['user' => $request->user(),'newsItems' => $newsItems, 'posts' => $posts]);
    }
}
