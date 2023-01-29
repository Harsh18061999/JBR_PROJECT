<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\PermissionDataTable;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{

    public function index(PermissionDataTable $dataTable, Request $request)
    {
        $permissions = Permission::orderBy('id','DESC')->paginate(5);
        return $dataTable->render('permissions.index',compact('permissions'));
    }

    public function create() 
    {   
        return view('permissions.create');
    }

    public function store(Request $request)
    {   
        $request->validate([
            'name' => 'required|unique:users,name'
        ]);

        Permission::create($request->only('name'));

        return redirect()->route('permissions.index')
            ->withSuccess(__('Permission created successfully.'));
    }

    public function edit(Permission $permission)
    {
        return view('permissions.edit', [
            'permission' => $permission
        ]);
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,'.$permission->id
        ]);

        $permission->update($request->only('name'));

        return redirect()->route('permissions.index')
            ->withSuccess(__('Permission updated successfully.'));
    }

    public function destroy($id)
    {
        Permission::where('id',$id)->delete();

        return redirect()->route('permissions.index')
            ->withSuccess(__('Permission deleted successfully.'));
    }
}
