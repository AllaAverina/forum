<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Http\Requests\StoreUpdateTopicRequest;
use App\Http\Requests\SearchTopicRequest;
use Illuminate\Support\Str;

class TopicController extends Controller
{
    /**
     * Create the controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Topic::class, 'topic');
        $this->middleware('auth')->except('index', 'show');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(SearchTopicRequest $request)
    {
        $topics = Topic::withCount('posts')
            ->where('title', 'LIKE', '%' . $request->get('search', '') . '%')
            ->orderBy($request->get('sort', 'updated_at'), $request->get('order', 'asc'))
            ->paginate(20)
            ->withQueryString()
            ->fragment('topics');

        return view('topic.index', compact('topics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('topic.create-edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateTopicRequest $request)
    {
        $topic = Topic::create($request->merge(['slug' => Str::slug($request->title, '-'), 'user_id' => $request->user()->id,])
            ->only('title', 'slug', 'subtitle', 'user_id'));

        return to_route('topics.edit', $topic->slug)->withSuccess(__('Created successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Topic $topic)
    {
        $posts = $topic->posts()->withCount('comments')->latest('updated_at')->paginate(20);
        return view('topic.topic-posts', compact('topic', 'posts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Topic $topic)
    {
        return view('topic.create-edit', compact('topic'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateTopicRequest $request, Topic $topic)
    {
        $topic->update($request->merge(['slug' => Str::slug($request->title, '-')])->only('title', 'slug', 'subtitle'));

        return to_route('topics.edit', $topic->slug)->withSuccess(__('Updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Topic $topic)
    {
        $topic->delete();

        return back()->withSuccess(__('Deleted successfully, it can be restored within 3 days'));
    }

    /**
     * Restore the specified resource to storage.
     */
    public function restore(Topic $topic)
    {
        $topic->restore();

        return back()->withSuccess(__('Restored successfully'));
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDelete(Topic $topic)
    {
        $topic->forceDelete();

        return back()->withSuccess(__('Deleted successfully'));
    }
}
