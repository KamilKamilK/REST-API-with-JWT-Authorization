<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        $token_validity = 24 *60;

        $this->guard()->factory()->setTTL($token_validity);

        if (!$token = $this->guard()->attempt($validator->validated())){
            return response()->json(['error' =>'Unathorized'], 401);
        }
        return $this->responseWithToken($token);

    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name'=>'required|string|between:2,100',
                'email'=>'required|email|unique:users',
                'password'=>'required|min:6',
            ]);

        if ($validator->fails()){
            return response()->json([
                $validator->errors()
            ],422);
        }

        $user = User::create(array_merge(
            $validator->validated(),
            ['password'=>bcrypt($request->password)]
        ));
        return response()->json(['message' => 'Nowy użytkownik powstał poprawnie', 'user'=>$user]);
    }

    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message'=>'Użytkownik wylogował się']);
    }
    public function profile()
    {
        return response()->json($this->guard()->user());
    }
    public function refresh()
    {
        return$this->responseWithToken($this->guard()->refresh());
    }

    protected function responseWithToken($token){
        return response()->json([
            'token'=>$token,
            'token_type' => 'bearer',
            'token_validity'=>$this->guard()->factory()->getTTL()*60
        ]);
    }
    protected function guard()
    {
        return Auth::guard();
    }



}

