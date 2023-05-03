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
        $search = $request->search ?? '';
        
        if ($search) {
            $topics = Topic::withCount('posts')
                ->where('title', 'LIKE', "%$search%")
                ->latest()
                ->paginate(10)
                ->withQueryString();
        } else {
            $topics = Topic::withCount('posts')->latest()->paginate(10);
        }

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
        $topic = new Topic;
        $topic->title = $request->title;
        $topic->subtitle = $request->subtitle;
        $topic->user_id = $request->user()->id;
        $topic->save();

        return to_route('topics.edit', $topic)->withSuccess(__('Created successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Topic $topic)
    {
        $posts = $topic->posts()->withCount('comments')->paginate(20);
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
        $topic->title = $request->title;
        $topic->subtitle = $request->subtitle;
        $topic->save();

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
    public function restore(Request $request)
    {
        $topic = Topic::onlyTrashed()->findOrFail($request->id)->restore();

        return back()->withSuccess(__('Restored successfully'));
    }
}
