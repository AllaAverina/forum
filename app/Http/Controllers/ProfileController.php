<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show(Request $request, string $part = 'info')
    {
        $user = $request->user();

        if ($part === 'posts') {
            $posts = $user->posts()->with('topic')->withTrashed()->latest('updated_at')->paginate(10);
            return view('profile.show', compact('user', 'posts', 'part'));
        }

        if ($part === 'comments') {
            $comments = $user->comments()->with('post')->withTrashed()->latest('updated_at')->paginate(10);
            return view('profile.show', compact('user', 'comments', 'part'));
        }

        if ($part === 'topics') {
            $topics = $user->topics()->withTrashed()->latest('updated_at')->paginate(10);
            return view('profile.show', compact('user', 'topics', 'part'));
        }

        return view('profile.show', compact('user', 'part'));
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit(Request $request)
    {
        $user = $request->user();

        return view('profile.edit', compact('user'));
    }

    /**
     * Delete the user's profile.
     */
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->user()->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('index');
    }
}
