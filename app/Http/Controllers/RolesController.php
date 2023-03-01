<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\RolesDataTable;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{

    public function index(RolesDataTable $dataTable, Request $request)
    {
        $roles = Role::orderBy('id','DESC')->paginate(5);
        return $dataTable->render('roles.index',compact('roles'));
    }
    
    public function create()
    {
        $permissions = Permission::get();

        $permissions_array = [];
        foreach($permissions as $permission){
            $permissions_array[$permission->title][] = $permission;
        }
        return view('roles.create', compact('permissions_array'));
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);
    
        $role = Role::create(['name' => $request->get('name'),'guard_name' => 'web']);
        $role->syncPermissions($request->get('permission'));
    
        return redirect()->route('roles.index')
                        ->with('success','Role created successFully');
    }

    public function show(Role $role)
    {
        $role = $role;
        $rolePermissions = $role->permissions;
    
        return view('roles.show', compact('role', 'rolePermissions'));
    }
    
    public function edit(Role $role)
    {
        $role = $role;
        $rolePermissions = $role->permissions->toArray();
        $parent_array = array_count_values(array_column($rolePermissions,'title'));
        $rolePermissions_array = array_column($rolePermissions,'name');
        $permissions = Permission::get();

        $total_count = count($permissions);

        $permissions_array = [];
        foreach($permissions as $permission){
            $permissions_array[$permission->title][] = $permission;
        }
    
        return view('roles.edit', compact('role', 'rolePermissions_array', 'parent_array','permissions_array','total_count'));
    }    

    public function update(Role $role, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);
        
        $role->update([
            "name" => $request->name,
            "guard_name" => "web"
        ]);
    
        $role->syncPermissions($request->get('permission'));
    
        return redirect()->route('roles.index')
                        ->with('success','Role updated successFully');
    }

    public function destroy($id)
    {
        Role::where('id',$id)->delete();

        return redirect()->route('roles.index')
            ->withSuccess(__('Role deleted successFully.'));
    }
}
