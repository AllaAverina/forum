<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\SearchRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request)
    {
        $search = $request->get('search', '');
        $users = User::withCount('topics', 'posts', 'comments')
            ->where('name', 'LIKE', "%$search%")
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('user.index', compact('users', 'search'));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user, string $part = 'info')
    {
        if ($part === 'posts') {
            $posts = $user->posts()->with('topic')->latest('updated_at')->paginate(10);
            return view('user.show', compact('user', 'posts', 'part'));
        }

        if ($part === 'comments') {
            $comments = $user->comments()->with('post')->latest('updated_at')->paginate(10);
            return view('user.show', compact('user', 'comments', 'part'));
        }

        if ($part === 'topics') {
            $topics = $user->topics()->latest('updated_at')->paginate(10);
            return view('user.show', compact('user', 'topics', 'part'));
        }

        return view('user.show', compact('user', 'part'));
    }
}
