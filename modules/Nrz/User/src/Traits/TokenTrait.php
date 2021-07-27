<?php

namespace Nrz\User\Traits;

use Illuminate\Http\Request;

trait TokenTrait
{
    protected $response;

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function getToken(Request $request)
    {
        $req = Request::create(
            '/oauth/token',
            'post',
            [
                'client_id' => config('maltina.passport.id'),
                'client_secret' => config('maltina.passport.secret'),
                "grant_type" => "password",
                "username" => $request->email,
                "password" => $request->password
            ]
        );

        return $this->response = app()->handle($req);
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return json_decode($this->response->getContent());
    }
}
