<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\OtpCode;
use Carbon\Carbon;




class VerificationController extends Controller
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
            'otp' => 'required',
          ]);

          $otp_code = OtpCode::where('otp', $request->otp)->first();

          if(!$otp_code) {
            return response()->json([
              'response_code' => '01',
              'response_message' => 'OTP code tidak ditemukan' ,
            ], 200);
          }
          $show = Carbon::now();

          if ($show > $otp_code->valid_until)
          {
            return response()->json([
              'response_code' => '01',
              'response_message' => 'Kode otp sudah tidak berlaku, Silahkan generate ulang',
            ], 200);
          }
          //update users

          $user = User::find($otp_code->user_id);
          $user->email_verified_at = Carbon::now();
          $user->save();

          //delete otpCode
          $otp_code->delete();
          $data['user'] = $user;

          return response()->json([
            'response_code' => '00',
            'response_message' => 'User berhasiil di verifikasi',
            'data' => $data
          ], 200);
    }
}
