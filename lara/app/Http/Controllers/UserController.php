<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
       $p = Post::all();
           dd($p->post);
    }
}
