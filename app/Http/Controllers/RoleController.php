<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;

class RoleController extends Controller
{
	private $title = '角色';
	
	private $grid = [
		['field' => 'id', 'title' => 'ID', 'sort' => true, 'fixed' => 'left'],
//		['field' => 'name', 'title' => 'name', 'sort' => true, 'fixed' => 'left'],
//		['field' => 'guard_name', 'title' => 'guard_name', 'sort' => true, 'fixed' => 'left'],
		['field' => 'title', 'title' => '角色名称', 'sort' => true, 'fixed' => 'left'],
		['field' => 'created_at', 'title' => '创建时间', 'sort' => true, 'fixed' => 'left'],
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
    	    $res  = Role::paginate(Arr::get($param, 'limit', 10), '*', 'page', '1');
			
    	    return $this->showMsg($res->items(), 0, $res->total());
	    }
    	
        return view('admin/role/index', compact('data'));
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
		    'permissions' => Role::allPermissions()->map(function ($item) {
	            return ['title' => $item->title, 'value' => $item->id];
		    })
	    ];
    	
        return view('admin/role/add', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $param = $request->all(['name', 'permissions']);

        $validate = Validator::make($param, [
        	'name' => 'required|max:255|unique:roles,name',
	        'permissions' => 'required'
        ], [
        	'name.required' => '角色名称为空',
        	'name.unique' => '角色已存在',
	        'permissions.required' => '没有选择权限'
        ]);

        if ($validate->fails()) {
            return response()->json(['code' => 400, 'data' => $param, 'msg' => $validate->errors()->first()]);
        }
        
        $data = [
        	'title' => $param['name'],
	        'name' => $param['name'],
	        'guard_name' => 'admin'
        ];
        $role = Role::create($data);
        $role->permissions()->attach($param['permissions']);
        if ($role) {
        	return response()->json(['code' => 200, 'data' => $param, 'msg' => '创建成功']);
        } else {
            return response()->json(['code' => 400, 'data' => $param, 'msg' => '创建失败']);
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
    	$data = [
    		'title' => $this->title,
		    'grid' => $this->grid,
		    'permissions' => Role::allPermissions()->map(function ($item) {
	            return ['title' => $item->title, 'value' => $item->id];
		    })
	    ];
    	
    	$role = Role::with(['permissions'])->findOrFail($id);
    	
    	$value = $role->permissions->map(function ($item) {
    		if (isset($item->id)) {
    		    return $item->id;
		    }
	    });

        return view('admin/role/edit', compact('data', 'id', 'role', 'value'));
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
        $param = $request->all(['name', 'guard_name', 'title', 'permissions']);
        
        $role = Role::findOrFail($id);
        $role->update(['name' => $param['name'], 'title' => $param['name']]);
        
        $res = $role->permissions()->sync($param['permissions']);
        
        if ($res) {
        	return response()->json(['code' => 200, 'data' => $param, 'msg' => '保存成功']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::destroy($id);
    }
}
