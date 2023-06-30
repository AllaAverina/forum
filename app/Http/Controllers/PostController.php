<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Topic;
use App\Http\Requests\StoreUpdatePostRequest;
use App\Http\Requests\SearchPostRequest;
use Illuminate\Support\Str;

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
    public function index(SearchPostRequest $request)
    {
        $posts = Post::whereHas('topic', function ($query) {
            $query->where('deleted_at', null);
        })
            ->with('user', 'topic')
            ->withCount('comments')
            ->where('title', 'LIKE', '%' . $request->get('search', '') . '%')
            ->orderBy($request->get('sort', 'updated_at'), $request->get('order', 'asc'))
            ->paginate(20)
            ->withQueryString()
            ->fragment('posts');

        return view('post.index', compact('posts'));
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
    public function store(StoreUpdatePostRequest $request)
    {
        $post = Post::create($request->merge(['slug' => Str::slug($request->title, '-'), 'user_id' => $request->user()->id])
            ->only('topic_id', 'title', 'slug', 'subtitle', 'body', 'user_id'));

        return to_route('posts.edit', $post->slug)->withSuccess(__('Created successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $comments = $post->comments()->with('user', 'user.roles')->latest('updated_at')->paginate(10)->fragment('comments');
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
    public function update(StoreUpdatePostRequest $request, Post $post)
    {
        $post->update($request->merge(['slug' => Str::slug($request->title, '-')])
            ->only('topic_id', 'title', 'slug', 'subtitle', 'body'));

        return to_route('posts.edit', $post->slug)->withSuccess(__('Updated successfully'));
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
    public function restore(Post $post)
    {
        $post->restore();

        return back()->withSuccess(__('Restored successfully'));
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDelete(Post $post)
    {
        $post->forceDelete();

        return back()->withSuccess(__('Deleted successfully'));
    }
}
