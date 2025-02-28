<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show(Category $category): Factory|View|Application
    {
        $topics = Topic::where('category_id', $category->id)->paginate(20);
        return view('topics.index', compact('category', 'topics'));
    }
}
