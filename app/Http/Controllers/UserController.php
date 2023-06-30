<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Http\Requests\SearchUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SearchUserRequest $request)
    {
        $users = User::withCount('topics', 'posts', 'comments')
            ->with('roles')
            ->where('name', 'LIKE', '%' . $request->get('search', '') . '%')
            ->orderBy($request->get('sort', 'name'), $request->get('order', 'asc'))
            ->paginate(20)
            ->withQueryString()
            ->fragment('users');

        return view('user.index', compact('users'));
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

    /**
     * Give the user the role of moderator.
     */
    public function assignModerator(User $user)
    {
        $this->authorize('manage-moderators');
        $user->roles()->sync(Role::where('role', 'moderator')->first()->id);

        return back()->withSuccess(__('The user is assigned as a moderator'));
    }

    /**
     * Deprive the user of the moderator role.
     */
    public function removeModerator(User $user)
    {
        $this->authorize('manage-moderators');
        $user->roles()->detach(Role::where('role', 'moderator')->first()->id);

        return back()->withSuccess(__('The user is removed as a moderator'));
    }
}
