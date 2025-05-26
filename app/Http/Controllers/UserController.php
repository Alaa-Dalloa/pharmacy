<?php

    namespace App\Http\Controllers;

    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use JWTAuth;
    use Tymon\JWTAuth\Exceptions\JWTException;
    use DB;
    use Carbon\Carbon;
    class UserController extends Controller
    {
        public function authenticate(Request $request)
        {
            $credentials = $request->only('email', 'password');

            try {
                if (! $token = JWTAuth::attempt($credentials)) {
                    return response()->json(['error' => 'invalid_credentials'], 400);
                }
            } catch (JWTException $e) {
                return response()->json(['error' => 'could_not_create_token'], 500);
            }
            $user_type=User::where('email','=',$request->email)->value('user_type');

            //return response()->json(compact('token'),$user_type);
            return [
            'token'=>$token,
            'user_type'=>$user_type
            ];
        }

        public function register(Request $request)
        {
                $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);

            if($validator->fails()){
                    return response()->json($validator->errors()->toJson(), 400);
            }

            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
                'user_type'=>'user',
            ]);
            $user->attachRole('user');
            $user->start_using_date=Carbon::now()->format('Y-m-d');

            $token = JWTAuth::fromUser($user);
            $user->save();

            return response()->json(compact('user','token'),201);
        }

        public function getAuthenticatedUser()
            {
                    try {

                            if (! $user = JWTAuth::parseToken()->authenticate()) {
                                    return response()->json(['user_not_found'], 404);
                            }

                    } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

                            return response()->json(['token_expired'], $e->getStatusCode());

                    } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

                            return response()->json(['token_invalid'], $e->getStatusCode());

                    } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

                            return response()->json(['token_absent'], $e->getStatusCode());

                    }

                    return response()->json(compact('user'));
            }
            public function logout() {
                     auth()->logout();

                   return response()->json(['message' => 'User successfully signed out']);
            }
   

            public function delete($id)
        {  
           $user= User::find($id);
           $result=$user->delete();
           if($result)
           {
            return ["Result"=>"data has been deleted"];
         }
         return ["Result"=>"operation failed"];

        }
        public function index()
    
    {
        return User::where("user_type","like","user")->select('id','name','start_using_date')->get();

    }


         public function update ($id,Request $request )
    { 
  
    $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
    ]);

   if($validator->fails()){
   return response()->json($validator->errors()->toJson(), 400);
    }
   
   $user= User::find($request->id);
   $user->name=$request->name;
   $user->email=$request->email;
   $user->password=$request->password;
   $result=$user->save();
   if($result)
   {
    return ["Result"=>"data has been update"];
   }
 return ["Result"=>"operation failed"];
}


}