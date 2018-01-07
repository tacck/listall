<?php
namespace App\Http\Service;


use App\User;

class UserService
{

    /**
     * @return array
     */
    public static function getAll() {
        return User::orderBy('id', 'asc')->get()->toArray();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getById($id) {
        return User::find($id);
    }
}