<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    public function index()
    {
		$roles = Role::all();
		return view('backend.pages.roles.index',compact('roles'));
    }

    public function create()
    {
		$permissions = Permission::all();
		$groups = collect($permissions)->groupBy('group_name');
		return view('backend.pages.roles.create',compact('permissions', 'groups'));
    }

    public function store(Request $request)
    {
		$validator = CustomValidator::validate($request, [
			'role' => 'required|unique:roles,name'
		]);

		if($validator !== true) {
			return $validator;
		}

		DB::beginTransaction();

		try {

			$role = Role::create(['name' => $request->role]);

			if(!empty($request->permissions)){
				$role->syncPermissions(
					collect($request->permissions)->keys()->all()
				);
			}

			DB::commit();

			return response()->json([
				'status' => true
			]);

		}catch (\Exception $e){
			DB::rollBack();
			return response()->json([
				'status' => false,
				'message' => $e->getMessage()
			]);
		}

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
    	if (auth()->user()->can('post.create')) {
    		$role = Role::findById($id);
	        $permissions = Permission::all();
			$groups = collect($permissions)->groupBy('group_name');
			$groupName = $groups->keys();
	   		/*return $role->permissions->where('group_name', $groupName)->count();*/
			return view('backend.pages.roles.edit', compact('role', 'permissions', 'groups'));
    	}else{
			return redirect()->back()->with('warning', 'Youre not authorized to perform the action.');
    	}
    	
    }

    public function update(Request $request, $id)
    {

        $validator = CustomValidator::validate($request, [
			'role' => 'required|unique:roles,name,'.$id
		]);

		if($validator !== true) {
			return $validator;
		}
		try {
			$role = Role::findById($id);

			 Role::where('id',$id)->update(['name' => $request->role]);

			if(!empty($request->permissions)){
				$role->syncPermissions(
					collect($request->permissions)->keys()->all()
				);
			}

			return redirect()->back()->with('success', 'Role Updated successfully!');

		}catch (\Exception $e){

			return redirect()->back()->with('warning', $e->getMessage());
			
		}
    }

    public function destroy(Role $role)
    {
    	if (auth()->user()->can('post.delete')) {
    		try {
				$role->delete();
				return redirect()->back()->with('success', 'Role Deleted successfully!');
			}catch (\Exception $e){
				return redirect()->back()->with('warning', $e->getMessage());
			}
    	}else{
			return redirect()->back()->with('warning', 'Youre not authorized to perform the action.');
    	}
    	
    }
}
