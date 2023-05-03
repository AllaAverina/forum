<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Topic;
use App\Http\Requests\PostRequest;
use App\Http\Requests\SearchRequest;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Create the controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Post::class, 'post');
        $this->middleware('auth')->except('index', 'show');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request)
    {
        $search = $request->search ?? '';

        if ($search) {
            $posts = Post::whereHas('topic', function ($query) {
                $query->where('deleted_at', null);
            })
                ->with('user', 'topic')
                ->withCount('comments')
                ->where('title', 'LIKE', "%$search%")
                ->latest('updated_at')
                ->paginate(20)
                ->withQueryString();
        } else {
            $posts = Post::whereHas('topic', function ($query) {
                $query->where('deleted_at', null);
            })
                ->with('user', 'topic')
                ->withCount('comments')
                ->latest('updated_at')
                ->paginate(20);
        }

        return view('post.index', compact('posts', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $topics = Topic::orderBy('title')->get();
        return view('post.create-edit', compact('topics'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $post = new Post;
        $post->topic_id = $request->topic;
        $post->title = $request->title;
        $post->subtitle = $request->subtitle;
        $post->body = $request->body;
        $post->user_id = $request->user()->id;
        $post->save();

        return to_route('posts.edit', $post->id)->withSuccess(__('Created successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $comments = $post->comments()->with('user')->paginate(20)->fragment('comments');
        return view('post.post-comments', compact('post', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $topics = Topic::orderBy('title')->get();
        return view('post.create-edit', compact('post', 'topics'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        $post->title = $request->title;
        $post->subtitle = $request->subtitle;
        $post->body = $request->body;
        $post->save();

        return back()->withSuccess(__('Updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return back()->withSuccess(__('Deleted successfully, it can be restored within 3 days'));
    }

    /**
     * Restore the specified resource to storage.
     */
    public function restore(Request $request)
    {
        $post = Post::onlyTrashed()->findOrFail($request->id)->restore();

        return back()->withSuccess(__('Restored successfully'));
    }
}
