<?php

namespace App\Http\Service;


use App\User;

class UserService
{

    /**
     * @return array
     */
    public static function getAll()
    {
        return User::orderBy('id', 'asc')->get()->toArray();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getById($id)
    {
        return User::find($id);
    }

    /**
     *
     * @param User $user
     * @param string|null $name
     * @param string|null $token
     * @param string|null $pass
     * @return bool
     * @throws \Throwable
     */
    public static function update(User $user, $name = null, $token = null, $pass = null)
    {
        $dirtyFlag = false;
        $resultFlag = false;

        if (!is_null($name) && strlen($name) !== 0 && $user->name !== $name) {
            $dirtyFlag = true;
            $user->name = $name;
        }

        if (!is_null($token) && strlen($token) !== 0 && $user->htn_webhook_token !== $token) {
            $dirtyFlag = true;
            $user->htn_webhook_token = $token;
        }

        $hashedPassword = bcrypt($pass);
        if (!is_null($pass) && strlen($pass) !== 0 && $user->password !== $hashedPassword) {
            $dirtyFlag = true;
            $user->password = $hashedPassword;
        }

        if ($dirtyFlag) {
            $resultFlag = $user->saveOrFail();
        }
        return $resultFlag;
    }
}