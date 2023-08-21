<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Event;
use Illuminate\Support\Facades\Mail;

class StartEventNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function handle()
    {
        $user = $this->event->user;

        Mail::raw("Розпочинається подія '{$this->event->title}'", function ($message) use ($user) {
            $message->to($user->email)->subject('Подія розпочалася');
        });
    }
}
