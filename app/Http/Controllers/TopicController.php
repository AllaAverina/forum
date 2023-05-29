<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Http\Requests\TopicRequest;
use App\Http\Requests\SearchRequest;
use Illuminate\Http\Request;

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
    public function index(SearchRequest $request)
    {
        $search = $request->get('search', '');
        $topics = Topic::withCount('posts')
            ->where('title', 'LIKE', "%$search%")
            ->latest('updated_at')
            ->paginate(10)
            ->withQueryString();

        return view('topic.index', compact('topics', 'search'));
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
    public function store(TopicRequest $request)
    {
        $topic = Topic::create($request->merge(['user_id' => $request->user()->id])
            ->only('title', 'subtitle', 'user_id'));

        return to_route('topics.edit', $topic)->withSuccess(__('Created successfully'));
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
    public function update(TopicRequest $request, Topic $topic)
    {
        $topic->update($request->only('title', 'subtitle'));

        return back()->withSuccess(__('Updated successfully'));
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
    public function restore(int $id)
    {
        Topic::onlyTrashed()->findOrFail($id)->restore();

        return back()->withSuccess(__('Restored successfully'));
    }
}
