<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;


class SiteController extends Controller
{

    public function index(Request $request){
            $posts = Post::orderBy('created_at','desc')
            ->whereStatus('PUBLISHED')
            ->take(4)
            ->get();
            return view('index', compact('posts'));
        }

}
