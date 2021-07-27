<?php

namespace Nrz\User\Repo;
use Nrz\User\Models\User;

class UserRepo
{

    public function findUser($email)
    {
       return User::query()->where("email", $email)->first();
    }

    public function createUser($data)
    {
        return User::query()->create([
            "name"=>$data['name'],
            "email"=>$data['email'],
            "password"=>bcrypt($data['password']),
        ]);
    }

}
