<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\UserRepositoryInterface;
use App\DataTables\UserDataTable;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) 
    {   
        $this->userRepository = $userRepository;
    }

    public function index(UserDataTable $dataTable)
    {
        $user = User::get();
        return $dataTable->render('content.user.user.index',compact('user'));
    }

    public function create()
    {
        $user = User::first();
        $userRole = $user->roles->pluck('name')->toArray();
        $roles = Role::latest()->get();
        return view('content.user.user.create',compact('user','userRole','roles'));
    }

    public function store(Request $request) 
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
        ]);

        $users = $this->userRepository->createUser($request->all());
        $users->syncRoles($request->get('role'));
        return redirect()->route('user.index')
        ->with('success', 'User created successfully.');

    }

    public function edit(User $user)
    {
        $userRole = $user->roles->pluck('name')->toArray();
        $roles = Role::latest()->get();
        return view('content.user.user.edit', compact('user','userRole','roles'));
    }

    public function update(Request $request)
    {   
        $userId = $request->route('id');
        $user = User::findOrFail($userId);
        $request->validate([
            'name' => 'required'
        ]);


        $userDetails = $request->only([
            'name'
        ]);

        $users = $this->userRepository->updateUser($userId,$userDetails);
        $user->syncRoles($request->get('role'));

        return redirect()->route('user.index')
            ->with('success', 'User updated successfully');
    }

    public function destory($id){
        $user = User::findOrFail($id);
        if(Storage::exists('public/assets/'.$user->lincense)){
            Storage::delete('public/assets/'.$user->lincense);
        }
        $this->userRepository->deleteUser($id);

        return true;
    }

    public function statusUpdate($id,Request $request){
        $user = User::where('id',$id)->first();
        if($user){
            $user->update([
                'status' => $request->status 
            ]);
            $response['success'] = true;
            $response['message'] = $request->status=='1'?'User Has Been Activated.':'User Has Been Inactivated.';  
        }else{
            $response['success'] = false;
            $response['message'] = 'Selected Record Not Found.';
        }
        return $response;
    }

}
