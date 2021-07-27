<?php


namespace Nrz\User\Http\Controller\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Nrz\User\Http\Requests\LoginRequest;
use Nrz\User\Http\Resources\UserResource;
use Nrz\User\Models\User;
use Nrz\User\Repo\UserRepo;
use Nrz\User\Traits\TokenTrait;

class LoginController extends Controller
{
    use TokenTrait;

    public function login(LoginRequest $request,UserRepo $userRepo)
    {
        //find user
        $user = $userRepo->findUser($request->email);

        //check user password && valid user
        $this->checkValidUser($user,$request->password);

        //get token
        $response = $this->getToken($request);
        if ($response->getStatusCode() !== 200) {
            return $response;
        }
        return new UserResource($user,$this->getContent());
    }

    public function checkValidUser($user,$password)
    {
        if (!$user){
            throw ValidationException::withMessages([
                "email" => "از صحت اطلاعات وارد شده اطمینان حاصل نمایید"
            ]);
        }
        if (!Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                "email" => "اطلاعات شما با داده های ما سازگار نیست ."
            ]);
        }
    }


}
