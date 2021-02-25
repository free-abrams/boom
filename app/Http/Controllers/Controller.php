<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
    
    public function upload(Request $request)
    {
    	$param = $request->all();
        $file = $param['file'];
        
        $validate = Validator::make($param, [
        	'file' => 'image'
        ]);
        
    	if ($validate->fails()) {
    	    return response()->json(['code' => 0, 'data' => [], 'msg' => $validate->errors()->first()]);
	    }
    	
        $res = Storage::put('img/'.Carbon::now()->format('Ymd'), $file);

        if ($res) {
            return response()->json(['code' => 0, 'data' => asset('/storage').'/'.$res, 'msg' => '上传完成']);
        } else {
        	return response()->json(['code' => 0, 'data' => $res, 'msg' => '上传失败']);
        }
    }
}
