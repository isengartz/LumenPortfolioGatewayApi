<?php
/**
 * Created by PhpStorm.
 * User: Sin
 * Date: 1/4/2020
 * Time: 2:01 μμ
 */
namespace App\Traits;
use GuzzleHttp\Client;

trait ConsumesExternalService {

    /**
     * Does a Guzzl HTTP Request
     * @param $method
     * @param $requestUrl
     * @param array $formParams
     * @param array $headers
     * @return string
     */
    public function performRequest($method,$requestUrl,$formParams = [], $headers = []) {

        $client = new Client([
            'base_uri' => $this->baseUri,
        ]);

        if (!empty($this->secret)) {
            $headers['Authorization']=$this->secret;
        }
         $response = $client->request($method,$requestUrl,['form_params' => $formParams,'headers'=>$headers]);
        return $response->getBody()->getContents();
    }
}
