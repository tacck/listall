<?php
namespace App\Http\Controllers;

use App\Http\Service\UserService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

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

    public function edit($message)
    {
        // GET '/users/{id}/edit'
        // TODO: 実装
    }

    public function update($message)
    {
        // POST '/users/{id}'
        // TODO: 実装
    }

    public function destroy($message)
    {
        // DELETE '/users/{id}'
        // TODO: 実装
    }
}