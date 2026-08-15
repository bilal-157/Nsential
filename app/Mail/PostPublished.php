<?php

namespace App\Mail;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PostPublished extends Mailable
{
    use Queueable, SerializesModels;

    public Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function build()
    {
        return $this->subject('New post published: ' . $this->post->title)
            ->view('emails.post-published')
            ->with([
                'title' => $this->post->title,
                'excerpt' => $this->post->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($this->post->content), 150),
                'url' => route('posts.show', $this->post->slug),
            ]);
    }
}