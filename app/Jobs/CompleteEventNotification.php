<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Event;
use Illuminate\Support\Facades\Mail;

class CompleteEventNotification implements ShouldQueue
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

        Mail::raw("Завершення події '{$this->event->title}'", function ($message) use ($user) {
            $message->to($user->email)->subject('Подія завершилася');
        });
    }
}
