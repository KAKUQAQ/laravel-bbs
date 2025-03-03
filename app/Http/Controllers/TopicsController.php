<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Category;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use Illuminate\Support\Facades\Auth;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request, Topic $topic): Factory|View|Application
	{
		$topics = $topic->withOrder($request->order)
            ->with('user', 'category')
            ->paginate(20);
		return view('topics.index', compact('topics'));
	}

    public function show(Topic $topic): Factory|View|Application
    {
        return view('topics.show', compact('topic'));
    }

	public function create(Topic $topic): Factory|View|Application
	{
        $categories = Category::all();
		return view('topics.create', compact('topic', 'categories'));
	}

	public function store(TopicRequest $request, Topic $topic): RedirectResponse
	{
		$topic->fill($request->all());
        $topic->user_id = Auth::id();
        $topic->save();
		return redirect()->route('topics.show', $topic->id)->with('message', 'Created successfully.');
	}

	public function edit(Topic $topic): Factory|View|Application
	{
        $this->authorize('update', $topic);
        $categories = Category::all();
		return view('topics.edit', compact('topic', 'categories'));
	}

	public function update(TopicRequest $request, Topic $topic): RedirectResponse
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->route('topics.show', $topic->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Topic $topic): RedirectResponse
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('message', 'Deleted successfully.');
	}
}
