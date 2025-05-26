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
use Http;
use Tymon\JWTAuth\Exceptions\JWTException;
class AdminController extends Controller
{

    public function CreatAdmin(Request $request)
        {
             if(auth()->user()->user_type=='super_admin')
       {
                $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
                'photo' => 'required',
                'age' => 'required',
                'gender' => 'required',
                'working_days' => 'required',
                'the_job' => 'required',
                'start_work_date' => 'required',
                'salary' => 'required',
                'phone' => 'required',

            ]);

            if($validator->fails()){
                    return response()->json($validator->errors()->toJson(), 400);
            }

            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
                'start_work_date' => $request->get('start_work_date'),
                'gender' => $request->get('gender'),
                'the_job' => $request->get('the_job'),
                'working_days' => $request->get('working_days'),
                'salary' => $request->get('salary'),
                'phone' => $request->get('phone'),
                'user_type'=>'administor',
            ]);
            $user->attachRole('administor');
           if($request->hasFile('photo'))
           {
           $photoName =rand().time().'.'.$request->photo->getClientOriginalExtension();
            $path=$request->file('photo')->move('upload/', $photoName );
          $user->photo=$photoName;
          $user->age=$request->age;
          $user->fcm_token=$request->fcm_token;
          $user->save();
        }

            $token = JWTAuth::fromUser($user);

             return [
            'user'=>$user,
            'password_user'=>$request->get('password'),
            'token'=>$token

            ];
        }
        else
        {
            return ["error"=>"you dont have permission to do this"];
        }
        }
    
    public function index()
    
    {
        return User::where("user_type","like","administor")->select('id','name','email','photo','start_work_date','age','gender','the_job','working_days','phone','salary','user_type')->get();

    }


    public function indexSuper()
    
    {
        return User::where("user_type","like","super_admin")->get();

    }


    public function search($name)
    {

    return User::where("name","like","%".$name."%")->get();
    }
    public function delete($id)
    {
        if(auth()->user()->id==1)
       {
       
       $user= User::find($id);
       $result=$user->delete();
       if($result){
        return ["Result"=>"data has been deleted"];
                  }
     
     }
        else
        {
            return ["error"=>"you dont have permission to do this"];
        }
    }

public function update ($id,Request $request )
 { 
   if(auth()->user()->user_type=='super_admin')
    {
   $validator = Validator::make($request->all(), [
    'working_days' => 'required',
    'the_job' => 'required',
    'salary' => 'required',
    'phone' => 'required',
    ]);

   if($validator->fails()){
   return response()->json($validator->errors()->toJson(), 400);
    }
   
   $user= User::find($request->id);
   $user->working_days=$request->working_days;
   if($request->user_type_bolean==1)
  {
   $user->user_type_bolean=1;
   $user->user_type='super_admin';
  }
   $user->the_job=$request->the_job;
   $user->salary=$request->salary;
   $user->phone=$request->phone;
   $result=$user->save();
   if($result)
   {
    return ["Result"=>"data has been update"];
   }
    }
        else
        {
            return ["error"=>"you dont have permission to do this"];
        }
}


public function refreshToken(Request $request)
{

    $user_id=$request->user_id;
    $fcm_token=$request->fcm_token;
    User::where('id',$user_id)->update(['fcm_token'=>$fcm_token]);
    return User::find($user_id);
} 
public function sendNotification(Request $request)
{
    $user_id=$request->user_id;
    $fcm_token=$request->fcm_token;
    $server_key=env('FCM_SERVER_KEY');
    $fcm=Http::acceptJson()->withToken($server_key)->post(
        'https://fcm.googleapis.com/fcm/send',
        [
         'to'=>$fcm_token,
          'notification'=>[
           'title'=>'hello',
           'body'=>'hi'
          ]

        ]
);
    return json_decode($fcm);
}


public function sendNotifications(Request $request)
{
    $user_ids=$request->user_ids;
    $fcm_token=User::find($user_ids)->pluck('fcm_token');
    $server_key=env('FCM_SERVER_KEY');
    $fcm=Http::acceptJson()->withToken($server_key)->post(
        'https://fcm.googleapis.com/fcm/send',
        [
         'registration_ids'=>$fcm_token,
          'notification'=>[
           'title'=>'hello',
           'body'=>'hi'
          ]

        ]
);
    return json_decode($fcm);
}
}