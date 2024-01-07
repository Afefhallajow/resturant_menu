<?php


namespace App\Http\Controllers;


use App\Http\Resources\itemResource;
use http\Env\Response;
use Illuminate\Support\Collection;

trait ResponseFunction
{
public function success($data,$message,$type=200)
{if(is_array($data ) || $data instanceof \Illuminate\Database\Eloquent\Collection)

    return  response()->json(['message' => $message,'data'=>$data ,'success'=>true],$type);
else
    return  response()->json(['message' => $message,'data'=>[0=>$data] ,'success'=>true],$type);

}
    public function error($message,$type=500)
    {if(is_array($message))
        return  response()->json(['message' => $message,'data'=>[],'success'=>false],$type);
    else
        return  response()->json(['message' =>[0=> $message],'data'=>[],'success'=>false],$type);

    }

}
