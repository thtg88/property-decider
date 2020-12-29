<?php

namespace App\Jobs;

use App\Models\Property;
use DOMDocument;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class ProcessPropertyUrlJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var \App\Models\Property */
    protected $property;

    /** @var string */
    protected $url;

    /**
     * Create a new job instance.
     *
     * @param \App\Models\Property $property
     * @param string $url
     * @return void
     */
    public function __construct(Property $property, string $url)
    {
        $this->property = $property;
        $this->url = $url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // If URL differ, we assume it has changed before processing the job
        // and is being dealt with, and return
        if ($this->property->url !== $this->url) {
            return;
        }

        $this->property->update(['status_id' => config('app.statuses.processing')]);

        // fetch URL
        try {
            $response = Http::timeout(30)->get($this->url);
        } catch (ConnectionException $e) {
            $this->property->update(['status_id' => config('app.statuses.failed')]);
            return;
        }

        if ($response->failed()) {
            $this->property->update(['status_id' => config('app.statuses.failed')]);
            return;
        }

        $body = $response->body();

        $document = DOMDocument::loadHTML($body);

        // ui-pricing__main-price

        // TODO: process price
        $this->property->update(['price' => -1]);

        // TODO: process amenities (with firstOrCreate)
        // dp-features-list__item

        // dp-description__text
        // dp-broadband-speed__text

        $this->property->update(['status_id' => config('app.statuses.completed')]);
    }
}
