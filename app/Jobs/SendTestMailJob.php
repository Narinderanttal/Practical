<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\User;
class SendTestMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
  
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $userid =$this->userid;
        $checkUser = User::where('id',$userid)->first();

        $users = User::find($userid);               
        $users->status = '1';
        $users->save();

        Mail::to($checkUser->email)
        ->send(new SendMail());
        
        
    }
}
