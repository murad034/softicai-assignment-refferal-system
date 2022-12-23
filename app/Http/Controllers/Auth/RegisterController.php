<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\CustomsHelper;
use App\Refer;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;


    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/adminUser';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
//        $data1 = DB::table('profile_models')
//            ->where('profile_models.student_id', $data['student_id'], '=')
//            ->first();

        return Validator::make($data, [
            'email' => 'required|string|email|max:255|unique:users',
            'name' => 'required|string|max:14',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }



    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $url_components = parse_url($_SERVER['HTTP_REFERER']);
        if(!empty($url_components['query'])){
            parse_str($url_components['query'], $params);
            $code = $params["refer"];
            $referrer_user = User::where('refer_code', $code)->first();
        }

        $refer_code =CustomsHelper::generateReferCode();

        $user_data = User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'name' => $data['name'],
            'refer_code' => $refer_code,
        ]);
        $user_data->assignRole("3");

        if(!empty($referrer_user)){
            $refer = new Refer();
            $refer->referrer = $referrer_user->id;
            $refer->user_id = $user_data->id;
            $refer->code = $code;
            $refer->reward_points = 15;
            $refer->save();
        }

        return $user_data;

    }

}
