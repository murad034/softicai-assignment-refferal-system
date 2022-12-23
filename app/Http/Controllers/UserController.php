<?php

namespace App\Http\Controllers;
use App\Helpers\CustomsHelper;
use App\ProfileModel;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class UserController extends Controller
{
    public $user;
    public $extra_title;
    public function __construct()
    {
        $this->extra_title = "- User";
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function addUser(){
        if (is_null($this->user) ||  !$this->user->can('adduser')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $data['extra_title'] = $this->extra_title;
        $data['roles'] = DB::table('roles')->get();
        return view('admin.set.userAddEdit',$data);
    }

    public function listUser(){
        if (is_null($this->user) ||  !$this->user->can('userlist')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $data['extra_title'] = $this->extra_title;
        $data['users']=User::all();

        return view('admin.set.userList', $data);
    }

    public function saveUser(Request $request){
        if (is_null($this->user) ||  !$this->user->can('user.save')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = new User();
        if(isset($request->id) &&!empty($request->id)){
            $data = User::find($request->id);
            if($data->email!=$request->email){
                $validator = \Validator::make($request->all(), [
                    'email' => 'required|email|max:30|unique:users,email',
                ]);
                if ($validator->fails()) {
                    return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
                }
            }
            $data->roles()->detach();
            if (!empty($request->roles)) {
                foreach ($request->roles as $role) {
                    $data->assignRole($role);
                }
            }
            $status=$request->status;
        }
        else{
            $validator = \Validator::make($request->all(), [
                'email' => 'required|email|max:30|unique:users,email',
                'password' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            if ($request->roles != null) {
                foreach ($request->roles as $role) {
                    $data->assignRole($role);
                }
            }
            $status=1;
            $data->refer_code = CustomsHelper::generateReferCode();
        }
        $data->name=$request->name;
        $data->email=$request->email;
        if(!empty($request->password))
        $data->password=bcrypt($request->password);
        $data->status = $status;
        if($data->save()==true) {
            return redirect('users')->with('success_message','Successfully Saved');
        } else{
            return redirect('users/add')->with('error_message','Unsuccessful,Please try again');
        }
    }

    public function deleteUser(Request $request){
        if (is_null($this->user) ||  !$this->user->can('user.delete')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $data=User::find($request->id);
        $data->roles()->detach();
        $data->delete();
        return redirect()->back()->with('success_message','Successfully Deleted');
    }

    public function editUser(Request $request){
        if (is_null($this->user) ||  !$this->user->can('user.edit')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $data['extra_title'] = $this->extra_title;
        $data['users'] = User::find($request->id);
        $data['roles'] = DB::table('roles')->get();
        return view('admin.set.userAddEdit',$data);
    }
}
