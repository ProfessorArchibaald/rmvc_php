<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\RMVC\View\View;

class PostController extends Controller
{
    public function index()
    {
        return View::view('post.index');
    }

    public function show($post)
    {
        return View::view('post.show', compact('post'));
    }
}