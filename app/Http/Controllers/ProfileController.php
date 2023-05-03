<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Create the controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
        $user = $request->user();

        return view('profile.edit', compact('user'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $part = 'info')
    {
        $user = $request->user();

        if ($part === 'posts') {
            $posts = $user->posts()->with('topic')->withTrashed()->latest('updated_at')->paginate(20);
            return view('profile.show', compact('user', 'posts', 'part'));
        }

        if ($part === 'comments') {
            $comments = $user->comments()->with('post')->withTrashed()->latest('updated_at')->paginate(20);
            return view('profile.show', compact('user', 'comments', 'part'));
        }

        if ($part === 'topics') {
            $topics = $user->topics()->withTrashed()->latest('updated_at')->paginate(10);
            return view('profile.show', compact('user', 'topics', 'part'));
        }

        return view('profile.show', compact('user', 'part'));
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('index');
    }
}