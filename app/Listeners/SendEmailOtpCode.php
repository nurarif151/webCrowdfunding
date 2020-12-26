<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\UserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\SendOtpCodeMail;
use Mail;

class SendEmailOtpCode implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        if ($event->condition == 'register'){
          $pesan = "We're excited to have you get started. First, you need to confirm your account. This is your OTP : ";

        }
        elseif ($event->condition == 'regenerate'){
          $pesan = "Regenerate OTP succesfull. This is your OTP Code : ";
        }
        Mail::to($event->user)->send(new SendOtpCodeMail($event->user, $pesan));
    }
}
