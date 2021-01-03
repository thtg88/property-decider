<?php

namespace App\Events;

use App\Models\Property;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PropertyStored
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Property $property
     * @return void
     */
    public function __construct(protected Property $property)
    {}

    public function getProperty(): Property
    {
        return $this->property;
    }
}
