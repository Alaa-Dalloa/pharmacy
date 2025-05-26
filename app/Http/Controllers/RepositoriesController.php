<?php

namespace App\Http\Controllers;
use App\Http\LaratrustUserTrait;
use Illuminate\Http\Request;
use App\Models\Role;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
class RepositoriesController extends Controller
{
    public function create(Request $request)
        {
                $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
                'phone' => 'required',
                'adress' => 'required',

            ]);

            if($validator->fails()){
                    return response()->json($validator->errors()->toJson(), 400);
            }

            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
                'phone' => $request->get('phone'),
                'adress' => $request->get('adress'),
                
                'user_type'=>'supplier',
            ]);
            $user->attachRole('supplier');

            $token = JWTAuth::fromUser($user);

            return [
            'user'=>$user,
            'password_user'=>$request->get('password'),
            'token'=>$token

            ];

        }
    public function index()
    
    {
        return User::where("user_type","like","supplier")->select('id','name','email','phone','adress')->get();

    }
    
    public function search(Request $request)
    {

    return User::where("name","like","%".$request->name."%")->get();
    }
    public function delete($id)
    {
       
       $user= User::find($id);
       $result=$user->delete();
       if($result){
        return ["Result"=>"data has been deleted"];
                  }
     return ["Result"=>"operation failed"];
    }

    public function update ($id,Request $request )
 { 
  $validator = Validator::make($request->all(), [
    'name' => 'required|string|max:255',
    'email' => 'required|string|email|max:255|unique:users',
    'password' => 'required|string|min:6',
    'phone' => 'required',
    'adress' => 'required'

    ]);

   if($validator->fails()){
   return response()->json($validator->errors()->toJson(), 400);
    }
   
   $user= User::find($id);
   $user->name=$request->name;
   $user->email=$request->email;
   $user->password=$request->password;
   $user->phone=$request->phone;
   $user->adress=$request->adress;
   $user->user_type=$request->user_type;
   $result=$user->save();
   if($result)
   {
    return ["Result"=>"data has been update"];
   }
 return ["Result"=>"operation failed"];
}

}