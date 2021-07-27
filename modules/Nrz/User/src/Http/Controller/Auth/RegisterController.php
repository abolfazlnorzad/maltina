<?php


namespace Nrz\User\Http\Controller\Auth;


use App\Http\Controllers\Controller;

use Nrz\User\Http\Requests\RegisterRequest;
use Nrz\User\Http\Resources\UserResource;
use Nrz\User\Models\User;
use Nrz\User\Repo\UserRepo;
use Nrz\User\Traits\TokenTrait;

class RegisterController extends Controller
{
    use TokenTrait;
    public function register(RegisterRequest $request,UserRepo $userRepo)
    {
        $user =$userRepo->createUser($request->only(['name','email','password']));

        $response = $this->getToken($request);
        if ($response->getStatusCode() !== 200) {
            return $response;
        }
        return new UserResource($user,$this->getContent());

    }


}
