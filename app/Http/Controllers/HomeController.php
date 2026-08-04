<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $newsItems = News::latest()->limit(5)->get();
        $posts = Post::latest()->limit(5)->get();
        $rooms = $request->user()->rooms()->with('users')->latest('rooms.updated_at')->get();

        return view('home', compact('newsItems', 'posts', 'rooms'));
    }
}
