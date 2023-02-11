<?php

namespace App\Services\Auth;

use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Responders\Responder;

class AuthService
{
    protected $response;
    public function __construct(Responder $response){
        $this->response = $response;
    }

    /**
     * @throws GuzzleException
     */
    public function token($user){

        $http = new Client();
        $client = DB::table('oauth_clients')->select('id', 'secret')->where('id', '=', 2)->first();

        $response = $http->post(config("auth.app_url").'/oauth/token', [
            'form_params' => [
                'grant_type'    => 'password',
                'client_id'     => intval($client->id),
                'client_secret' => (string)$client->secret,
                'username'      => (string)$user->phone_number,
                'password'      => '123'
            ]
        ]);

        if ($response->getStatusCode() === 500){
            return $this->response->error('401 Unauthorized', [], 401);
        }
        return  json_decode((string) $response->getBody(), true);
    }


    /**
     * Тупая логика, надо, переделать так, чтобы ошибок не было или чтобы ошибки обрабатывались правильно. Бір сөзбен дұрыстау керек
     * @param $refreshToken
     * @throws GuzzleException
     */
    public function refreshToken($refreshToken)
    {
        $http = new Client();
        $client = DB::table('oauth_clients')->select('id', 'secret')->where('id', '=', 2)->first();

        try {
            $response = $http->request('POST',config("auth.app_url").'/oauth/token', [
                'form_params' => [
                    'grant_type'    => 'refresh_token',
                    'refresh_token' => $refreshToken,
                    'client_id'     => intval($client->id),
                    'client_secret' => (string)$client->secret
                ]
            ]);

            return json_decode((string) $response->getBody(), true);
        }catch (ClientException $e){
            return $this->response->error('401 Unauthorized', [], 401);
        }
    }

    /**
     * @param $name
     * @param $email
     * @param $password
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function register($name, $email, $password) : Response{
        $user = User::create([
            "name" => $name,
            "email" => $email,
            "password" => Hash::make($password),
        ]);

        return response([
            "user" => $user,
        ], 200);
    }

}
