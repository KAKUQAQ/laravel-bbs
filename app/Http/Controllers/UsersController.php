<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }

    public function show(User $user): Factory|View|Application
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user): Factory|View|Application
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user): RedirectResponse
    {
        $this->authorize('update', $user);
        $data = $request->all();
        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id, 416);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }
        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', 'Profile updated successfully.');
    }
    /** 模拟登录*/
    public function impersonateUser($id, Request $request): RedirectResponse|Redirector|Application
    {
        $user = User::find($id);
        if ($user) {
            Auth::user()->impersonate($user);

            session(['impersonate' => true]);

            $redirectTo = $request->input('redirect_to', '/');
            return redirect($redirectTo);
        }
        return redirect()->back()->with('error', 'You cannot impersonate this user.');
    }

    /** 停止模拟*/
    public function stopImpersonating(Request $request): RedirectResponse|Application|Redirector
    {
        Auth::user()->leaveImpersonation();
        
        session()->forget('impersonate');

        $redirectTo = $request->input('redirect_to', '/');
        return redirect($redirectTo);
    }
}
