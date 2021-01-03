<?php

namespace App\Events;

use App\Models\Comment;
use App\Models\Property;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentStored
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Comment $comment
     * @return void
     */
    public function __construct(protected Comment $comment)
    {}

    public function getComment(): Comment
    {
        return $this->comment;
    }

    public function getProperty(): Property
    {
        return $this->comment->property;
    }
}
