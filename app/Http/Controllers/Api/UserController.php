<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller{
    public function index(){
        $users=User::all();
        return $users;
    }
    public function register(Request $request){
        /** @var \App\Models\User $user */
       
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'            
        ]);
        //$user=User::create($request->all());
        $user= new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password = Hash::make($request->password);//encriptar password
        $user->save();
        //return response()->json(["status"=>1,"msg"=>"Registro exitoso"]);
        return response(['success' => true, 'msg' => 'Registro exitoso'],201);
        
    }
    public function login(Request $request){
        $credentials=$request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);
        /*$user=User::where("email","=",$request->email)->first();
        if (isset($user->id)) {
            if (Hash::check($request->password,$user->password)) {
                //crear el token
                $token=$user->createToken("auth_token")->plainTextToken;
                return response()->json(["error"=>false,"msg"=>"Login exitoso","access_token"=>$token],200);

            }else{
                return response()->json(["error"=>true,"msg"=>"Email o Password incorrectos"],401);
            }
        }else{
            return response()->json(["error"=>true,"msg"=>"Email o Password incorrectos"],401);
        }*/
        if (!Auth::guard('web')->attempt($credentials)) {
            return response()->json(["error"=>true,"msg"=>"Email o Password incorrectos"],401);
        }
        /** @var \App\Models\User $user **/
        $user=Auth::user();
        //$tokenResult = $user->createToken('auth-token',['*'],Carbon::now()->addMinutes(30));
        $tokenResult = $user->createToken('auth-token',['*']);
       

        $tokenPlainText = $tokenResult->plainTextToken; // El token para el cliente
        //$expiresAt =$tokenResult->accessToken->expires_at;//!en esta version de laravel no tiene el campo expires_at
        $expiresAt = Carbon::now()->addMinutes(30); // Establecer la
        
        /*$tokenResult->accessToken->expires_at = Carbon::now()->addMinutes(30);
        $tokenResult->accessToken->save();*/


        $cookie = cookie('cookie_token', $tokenPlainText, 60 * 24);


       //? $rolesById = $user->getRoleNames()->toArray();
        
        return response()->json([
            'status'=>true,
            'message'=>'Sesion iniciada correctamente',
            'user'=>$user,
            'expires_at'=>$expiresAt,
            'access_token'=>$tokenPlainText,
            //'expires_at' =>$expiresAt ? Carbon::parse($expiresAt)->toDateTimeString() : null,

        ])->withCookie($cookie); 

    
    }
    public function userProfile(){
        
        return response()->json(["success"=>true,"data"=>auth()->user()],200);
    
    }
    public function logout(User $user){
        /** @var \App\Models\User $user **/
        $user = Auth::user();
        $user->tokens()->delete();
    
       // auth()->user()->tokens()->delete();
        $cookie = Cookie::forget('cookie_token');
        return response()->json(["success"=>true,"msg"=>"Logout exitoso"])->withCookie($cookie);

    }
    
}