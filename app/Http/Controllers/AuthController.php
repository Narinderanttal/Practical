<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;
use Illuminate\support\Facades\Hash;
use Illuminate\support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\User;
class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users',
            'password' => 'required|string|min:6'
        ]);

        $user =new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $user->save();
        
        // dispatch(function (){
        //     Mail::to( users, "test@test.com")
        //     ->send(new SendMail());
        // })->delay(now()->addSeconds( value, 120));
            
        dispatch(new \App\Jobs\SendTestMailJob($user->id))->delay(now()->addSeconds(120));

        return response()->json(['message' => 'User has been registered'], 200);
    }

    public function login(Request $request)
    { 
        $request->validate([
            'email' => 'required',
            'password' => 'required|string'
        ]);

        $credentials = request(['email', 'password']);
        $checkUser = User::where('email',$request->email)->first();
        // If User Activate Then This get access token (With Passport)
        if($checkUser->status != 0)
        {
            if(Auth::attempt($credentials)){ 
                $user = Auth::user(); 
                $user['token'] =  $user->createToken('MyApp')-> accessToken; 
                return response()->json(['success' => $user], 200); 
            } 
            else{ 
                return response()->json(['error'=>'Unauthorised'], 401); 
            } 
        }
        else
        {
            return response()->json(['error'=>'This User is not activate'], 401);
        }
       
    }

 
}
