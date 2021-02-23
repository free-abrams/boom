<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function showMsg($data = [], $code = 200, $count = 0,$msg = 'SUCCESS')
    {
        $return['code'] = $code;
        $return['msg'] = $msg;
        $return['data'] = $data;
        $return['count'] = $count;
        
        return Response()->json($return);
    }
}
