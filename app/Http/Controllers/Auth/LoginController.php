<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
          'email'=>'required',
          'password'=>'required',
        ]);

        $credentials =$request->only(['email', 'password']);

//jika pada config/auth => default guard nya web maka pada
//if (! $token = auth('web')->attempt($credentials)) {


        if (! $token = auth()->attempt($credentials)) {
          return response()->json(['error' => 'unauthorized'], 401);
        }

        $data['token'] = $token;
        $data['user'] = auth()->user();

        return response()->json([
          'response_code' => '00',
          'response_massage' => 'user berhasil login',
          'data' => $data
        ], 200);
    }
}
