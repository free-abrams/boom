<?php

namespace App\Http\Controllers;

use App\Handlers\Tree;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
	
	private $title = '权限';
	
	private $grid = [
		['field' => 'id', 'title' => 'ID', 'sort' => true, 'fixed' => 'left'],
		['field' => 'name', 'title' => 'name', 'sort' => true, 'fixed' => 'left'],
		['field' => 'guard_name', 'title' => 'guard_name', 'sort' => true, 'fixed' => 'left'],
		['field' => 'title', 'title' => 'title', 'sort' => true, 'fixed' => 'left'],
		['field' => 'created_at', 'title' => 'created_at', 'sort' => true, 'fixed' => 'left'],
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
    	
		$res = Permission::all(['id', 'title', 'parent_id'])->toArray();
        $res = Tree::array_tree($res);

        return view('admin/permission/index', compact('res', 'data'));
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
        //
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
        //
    }
}
