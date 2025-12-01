<?php
namespace App\Helpers ;
class ApiResponse 
{
    public static function success($code=200,$data = null , $message = null)
    { 
        return response()->json([
         'success' => true,
         'data' => $data,
         'message' => $message,
         'error' => null,
        ], $code);
    }

    public static function error($code=500,$error = null , $message = null,)
    {
        return response()->json([
            'success' => false,
            'data' => null,
            'message' => $message,
            'error' => $error,
                
        ], $code);
    }
   
}
