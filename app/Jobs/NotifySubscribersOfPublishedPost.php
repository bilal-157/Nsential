<?php

namespace App\Jobs;

use App\Mail\PostPublished;
use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotifySubscribersOfPublishedPost implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public function __construct(public Post $post)
    {
    }

    public function handle(): void
    {
        // Chunk to avoid loading every user into memory at once.
        // If you only want to notify actual "subscribers" rather than every
        // registered user, swap User::query() for whatever subscriber model/
        // scope you use (e.g. User::where('subscribed', true)).
        User::query()
            ->select('id', 'email', 'name')
            ->chunk(200, function ($users) {
                foreach ($users as $user) {
                    if (!empty($user->email)) {
                        Mail::to($user->email)->send(new PostPublished($this->post));
                    }
                }
            });
    }
}