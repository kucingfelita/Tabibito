<?php

namespace App\Jobs;

use App\Mail\FeedbackMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendFeedbackMailJob implements ShouldQueue
{
   use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

   protected $data;

   public function __construct($data)
   {
      $this->data = $data;
   }

   public function handle()
   {
      Mail::to(config('mail.admin_email', env('ADMIN_EMAIL', 'admin@example.com')))->send(new FeedbackMail($this->data));
   }
}
