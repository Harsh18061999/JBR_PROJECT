<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\UserRepositoryInterface;
use App\DataTables\UserDataTable;
use App\Models\User;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;
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
        $client = Client::get();
        return $dataTable->render('content.user.user.index',compact('user','client'));
    }

    public function create()
    {
        $user = User::first();
        $userRole = $user->roles->pluck('name')->toArray();
        $roles = Role::latest()->get();
        $client = Client::get();
        return view('content.user.user.create',compact('user','userRole','roles','client'));
    }

    public function store(Request $request) 
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email'
        ]);

        $users = $this->userRepository->createUser($request->all());
        $users->syncRoles($request->get('role'));
        
        $message = "Thank you for choosing Our Brand. Use the following link complete your procedures. \n";
        $message .= route('passwordCreate', $users->remember_token);

        $number = '+' . $users->countryCode . $users->contact_number;
        sendMessage($number, $message);

        return redirect()->route('user.index')
        ->with('success', 'User created successfully.');

    }

    public function edit(User $user)
    {
        $userRole = $user->roles->pluck('name')->toArray();
        $roles = Role::latest()->get();
        $client = Client::get();
        return view('content.user.user.edit', compact('user','userRole','roles','client'));
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

    public function checknumber(Request $request){
        try {
            $whatsappNumber = json_decode(checkNumber($request->countryCode . $request->contact_number));
            $response['numberCheck'] = $whatsappNumber->status == 'invalid' ? false : true;
            $user = User::where('contact_number', $request->contact_number)
                ->first();
            if ($user) {
                $response['success'] = true;
            } else {
                $response['success'] = false;
            }
            return response()->json($response);
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withError('Try again');
        }
    }

    public function passwordCreate($token){
        return view("auth.reset-password",compact("token"));
    }

    public function passwordConfirm(Request $request){
        User::where('remember_token',$request->user_token)
            ->update([
                'password' => Hash::make($request->password),
            ]);
        return redirect()->route('login');
    }
}
