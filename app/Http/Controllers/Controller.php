<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    //
    public function successObjResponse($obj,$code = 200)
    {
        return response()->json([
            "error" => false,
            "message" => "Success",
            "data" => $obj
        ],$code);
    }

    public function successMsgResponse($msg,$code = 200)
    {
        return response()->json([
            "error" => false,
            "message" => $msg,
            "data" => null
        ],$code);
    }

    public function errorObjResponse($obj,$code = 200)
    {
        return response()->json([
            "error" => true,
            "message" => "Failed",
            "data" => $obj
        ],$code);
    }

    public function errorExceptionResponse($obj,$code = 200)
    {
        return response()->json([
            "error" => true,
            "message" => "Failed! Error " . $obj->getMessage() . " on line ". $obj->getLine(),
            "data" => $obj
        ],$code);
    }

    public function errorMsgResponse($msg,$code = 200)
    {
        return response()->json([
            "error" => true,
            "message" => $msg,
            "data" => null
        ],$code);
    }

    public function errorNotFound()
    {
        return $this->errorMsgResponse("Data not found!",404);
    }

    public function errorUnauthorize()
    {
        return $this->errorMsgResponse("Invalid Credentials",401);
    }

    
}
