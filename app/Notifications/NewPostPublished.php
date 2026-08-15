<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\Middleware\RateLimited;

class NewPostPublished extends Notification // Remove "implements ShouldQueue" temporarily
{
    // Comment out Queueable for testing
    // use Queueable;

    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
        
        // Comment these out for testing
        // $this->onConnection('redis');
        // $this->onQueue('notifications');
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $postUrl = route('posts.show', $this->post->slug);
        
        return (new MailMessage)
            ->subject('New Post Published: ' . $this->post->title)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('A new post has been published on our website.')
            ->line('**Title:** ' . $this->post->title)
            ->line('**Category:** ' . ($this->post->category->name ?? 'Uncategorized'))
            ->line('**Reading Time:** ' . $this->post->reading_time . ' min')
            ->action('Read Full Post', $postUrl)
            ->line('Thank you for being a valued member of our community!')
            ->salutation('Regards, ' . config('app.name'));
    }

    // Comment out middleware for testing
    // public function middleware(): array
    // {
    //     return [
    //         new RateLimited('notifications'),
    //     ];
    // }

    // public function tags(): array
    // {
    //     return [
    //         'notification',
    //         'new-post',
    //         'post:' . $this->post->id,
    //         'post-title:' . $this->post->title
    //     ];
    // }

    // public function retryUntil(): \DateTime
    // {
    //     return now()->addMinutes(5);
    // }

    // public function failed(\Throwable $exception): void
    // {
    //     \Log::error('NewPostPublished notification failed', [
    //         'post_id' => $this->post->id,
    //         'error' => $exception->getMessage(),
    //         'trace' => $exception->getTraceAsString()
    //     ]);
    // }
}