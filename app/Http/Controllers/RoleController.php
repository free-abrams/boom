<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;

class RoleController extends Controller
{
	private $title = '角色';
	
	private $grid = [
		['field' => 'id', 'title' => 'ID', 'sort' => true, 'fixed' => 'left'],
		['field' => 'name', 'title' => 'name', 'sort' => true, 'fixed' => 'left'],
		['field' => 'guard_name', 'title' => 'guard_name', 'sort' => true, 'fixed' => 'left'],
		['field' => 'title', 'title' => 'title', 'sort' => true, 'fixed' => 'left'],
		['field' => 'created_at', 'title' => 'created_at', 'sort' => true, 'fixed' => 'left'],
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
		    'grid' => $this->grid
	    ];
    	
    	$role = Role::findOrFail($id);
    	
        return view('admin/role/edit', compact('data', 'id', 'role'));
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
        $param = $request->all(['name', 'guard_name', 'title']);
        $role = Role::findOrFail($id);
        $role->update($param);
        $res = $role->save();
        
        if ($res) {
        	session()->flash('success', '保存成功');
            return redirect()->route('role.edit', ['role' => $id]);
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
        //
    }
}
