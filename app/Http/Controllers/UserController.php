<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserEditPost;
use App\Http\Service\UserService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    /**
     * GET '/users'
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = UserService::getAll();

        return view('users.index', compact('users'));
    }


    public function create()
    {
        // GET '/users/create'
        // TODO: 実装
        return view('users.create', compact('user'));
    }

    public function store(Request $request)
    {
        // POST '/users'
        // TODO: 保存
        // TODO: 一覧ページへリダイレクト
    }

    /**
     * GET '/users/{id}'
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        // GET '/users/{id}/edit'
        // TODO: 実装
        return view('users.edit', compact('user'));
    }

    /**
     * PUT '/users/{id}'
     *
     * @param UserEditPost $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UserEditPost $request, User $user)
    {
        $params = $request->all();

        try {
            UserService::update($user, $params['name'], $params['htn_webhook_token'], $params['password']);
        } catch (\Throwable $e) {
            // TODO: ページに留まる
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        }

        return redirect('/users');
    }

    public function destroy(User $user)
    {
        // DELETE '/users/{id}'
        // TODO: 実装
    }
}