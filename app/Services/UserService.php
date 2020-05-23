<?php
/**
 * Created by PhpStorm.
 * User: Sin
 * Date: 2/4/2020
 * Time: 4:04 μμ
 */

namespace App\Services;


use App\Traits\ConsumesExternalService;

class UserService
{
    use ConsumesExternalService;

    public $baseUri;


    public function __construct()
    {
        $this->baseUri = env('USERS_SERVICE_BASE_URL');

    }

    /**
     * Generate Token for Client User
     * @param array $data
     * @return mixed
     */
    public function login(array $data)
    {
        $payload = [
            'client_id' => env('PASSWORD_CLIENT_ID'),
            'client_secret' => env('PASSWORD_CLIENT_SECRET'),
            'grant_type' => env('PASSWORD_CLIENT_GRANT'),
            'username' => $data['username'],
            'password' => $data['password']
        ];
        $this->performRequest('POST', '/oauth/token', $payload);


    }

    /**
     * Generate the Token for API User
     * @return mixed
     */
    public function generateToken()
    {
        $payload = [
            'client_id' => env('API_CLIENT_ID'),
            'client_secret' => env('API_CLIENT_SECRET'),
            'grant_type' => env('API_CLIENT_GRANT')
        ];

        return $this->performRequest('POST', '/oauth/token', $payload);
    }
}
