<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    /**
     * Home page
     *
     * @return Factory|View|Application
     */
    public function root(): Factory|View|Application
    {
        return view('pages.root');
    }

    public function permissionDenied(): Factory|View|Application|Redirector|RedirectResponse
    {
        if (config('administrator.permission')()) {
            return redirect(url(config('administrator.uri')), 302);
        }
        return view('pages.permission_denied');
    }
}
