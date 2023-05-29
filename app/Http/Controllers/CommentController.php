<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Http\Requests\CommentRequest;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Create the controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Comment::class, 'comment');
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request, Post $post)
    {
        Comment::create([
            'body' => $request->body,
            'post_id' => $post->id,
            'user_id' => $request->user()->id,
        ]);

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        return view('comment.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentRequest $request, Comment $comment)
    {
        $comment->update($request->only('body'));

        return back()->withSuccess(__('Updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return back()->withSuccess(__('Deleted successfully, it can be restored within 3 days'));
    }

    /**
     * Restore the specified resource to storage.
     */
    public function restore(int $id)
    {
        Comment::onlyTrashed()->findOrFail($id)->restore();

        return back()->withSuccess(__('Restored successfully'));
    }
}
