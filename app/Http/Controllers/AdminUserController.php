<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminUserController extends Controller
{
	private $title = '管理员';
	
	private $grid = [
		['field' => 'id', 'title' => 'ID', 'sort' => true, 'fixed' => 'left'],
		['field' => '', 'title' => '头像', 'templet' => '#avatar'],
		['field' => 'name', 'title' => '昵称', 'sort' => true],
		['field' => 'username', 'title' => '用户名', 'sort' => true],
		['field' => 'created_at', 'title' => '创建时间', 'sort' => true],
		['field' => 'right', 'title' => '操作', 'toolbar' => '#action']
	];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	$data = [
    		'title' => $this->title,
		    'grid' => $this->grid
	    ];

    	$param = $request->all();
    	
    	if (isset($param['page'])) {
    	    $res  = AdminUser::with(['role:name'])->paginate(\Arr::get($param, 'limit', 10), '*', 'page', $param['page']);
			
    	    return $this->showMsg($res->items(), 0, $res->total());
	    }
    	
        return view('admin/admin_user/index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$data = [
    		'title' => $this->title,
		    'role' => Role::all()->map(function ($item) {
	            return [
	                'title' => $item->title,
			        'value' => $item->id
		        ];
		    })
	    ];
    	
    	
        return view('admin/admin_user/add', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$param = $request->all(['name', 'username','avatar', 'password', 'password_confirmed', 'roles']);
    	
    	$validate = Validator::make($param, [
    		'name' => 'required',
		    'username' => 'required|unique:admin_users',
		    'password' => 'required',
		    'password_confirmed' => 'required|same:password',
	    ], [
	    	'title.required' => '昵称不能为空',
		    'username.required' => '用户名不能为空',
		    'username.unique' => '用户名已存在',
		    'password.required' => '密码不能为空',
		    'password_confirmed.same' => '两次密码不一致'
	    ]);
    	
    	if ($validate->fails()) {
    	    return response()->json(['code' => '200', 'data' => $param, 'msg' => $validate->errors()->first()]);
	    }
    	
    	$admin_user = AdminUser::create($param);
    	$admin_user->role()->attach($param['roles']);
    	
    	if ($admin_user) {
    	    return response()->json(['code' => '200', 'data' => $param, 'msg' => '保存成功']);
	    } else {
    		return response()->json(['code' => '400', 'data' => $param, 'msg' => '保存失败']);
	    }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$admin = AdminUser::with(['role'])->findOrFail($id);
    	
    	$data = [
    		'title' => $this->title,
		    'data' => $admin,
		    'role' => Role::all()->map(function ($item) {
		        return ['title' => $item->title, 'value' => $item->id];
		    }),
		    'value' => $admin->role->map(function ($item) {
		        return $item->id;
		    })
	    ];

        return view('admin/admin_user/edit', compact('data', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AdminUser::destroy($id);
        
        return response()->json(['code' => 1, 'data' => $id, 'msg' => '删除成功']);
    }
}
