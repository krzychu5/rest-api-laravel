<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
   public function register(Request $request){

     $fields = $request->validate([
       'name' => 'required|string',
       'email' => 'required|string|unique:users,email',
       'password' => 'required|string|confirmed'
     ]);

     $user = User::create([
       'name' => $fields['name'],
       'email' => $fields['email'],
       'password' => bcrypt($fields['password'])
     ]);
     $token = $user->createToken('myapptoken')->plainTextToken;
     $response = [
       'user' => $user,
       'token' => $token
     ];
       return response($token, 201);
   }
   public function login(Request $request){
     $feilds = $request->validate([
       'email' => 'required|string',
       'password' => 'required|string'
     ]);
     $user = User::where('email',$feilds['email'])->first();
     if(!$user || !Hash::check($feilds['password'],$user->password)){
       $response = [
         'messages' => 'bed data'
       ];
       return response($response, 401);
     }

     return $user->createToken('myapptoken')->plainTextToken;

   }
   public function logout(Request $request){
      auth()->user()->tokens()->delete();
      return [
        'message' => 'Logout'
      ];
   }
}
