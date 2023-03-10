<?php

namespace App\Services\Auth;

use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
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
            $response = $http->request('POST', config("auth.app_url").'/oauth/token', [
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
     * @param $request
     */
    public function register($request)
    {
        $profile_photo = array_key_exists('profile_photo', $request) ? $request['profile_photo']->store('profile_photo/'.Carbon::now()->format('Y')."/".Carbon::now()->format('m')."/".Carbon::now()->format('d'), 'public') : null;

        $user_info = [
            'name' => $request['name'],
            'email' => array_key_exists('email', $request) ? $request['email'] : null,
            'phone_number' => $request['phone_number'],
            'profile_photo' => array_key_exists('profile_photo', $request) ? config('auth.app_url').'/app/public/'.$profile_photo : null,
        ];

        $user = User::updateOrCreate($user_info, ['phone_number'])->first();
        if ($user){
            $token = $this->token($user);
            $token += ['user' => $user_info];
            return $token;
        }
        return $this->response->error('error', [], 500);
    }

}
