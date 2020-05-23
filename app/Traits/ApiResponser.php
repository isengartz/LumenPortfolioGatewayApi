<?php
/**
 * Created by PhpStorm.
 * User: Sin
 * Date: 1/4/2020
 * Time: 12:07 μμ
 */
namespace App\Traits;
use Illuminate\Http\Response;

trait ApiResponser {


    /**
     * @param $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($data, $code = Response::HTTP_OK){
        return response($data,$code)->header('Content-Type','application/json');
    }
    /**
     * Build valid response
     * @param  string|array $data
     * @param  int $code
     * @return Illuminate\Http\JsonResponse
     */
    public function validResponse($data, $code = Response::HTTP_OK)
    {
        return response()->json(['data' => $data], $code);
    }

    /**
     * Return the payload of an error response
     * @param $message
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($message,$code){
        return response()->json(['error'=>$message,'code'=>$code],$code);
    }

    /**
     * Return the Error Message
     * @param $message
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorMessage($message,$code){
        return response()->json($message,$code)->header('Content-Type','application/json');
    }
}
