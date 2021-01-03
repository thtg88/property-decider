<?php

namespace App\Jobs;

use App\Actions\ProcessProperty\Utils;
use App\Events\PropertyStored;
use App\Models\Property;
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

    public function __construct(
        protected Property $property,
        protected string $url,
    ) {}

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

        $this->property->update([
            'status_id' => config('app.statuses.processing_id'),
        ]);

        // fetch URL
        try {
            $response = Http::timeout(30)->get($this->url);
        } catch (ConnectionException $e) {
            $this->property->update([
                'description' => $e->getMessage(),
                'status_id' => config('app.statuses.failed_id'),
            ]);
            return;
        }

        if ($response->failed()) {
            $this->property->update([
                'description' => 'Could not fetch the listing. '.
                    'The page responded with a status '.
                    $response->status(),
                'status_id' => config('app.statuses.failed_id'),
            ]);
            return;
        }

        foreach (Utils::PROVIDER_ACTIONS as $action_clasname) {
            if (! $action_clasname::respondsTo($this->url)) {
                continue;
            }

            $action = new $action_clasname($this->property, $response->body());

            $action();

            $this->property->update([
                'status_id' => config('app.statuses.completed_id'),
            ]);

            // Notify group of new property
            event(new PropertyStored($this->property));

            return;
        }

        $this->property->update([
            'description' => 'The URL provided is not supported.',
            'status_id' => config('app.statuses.failed_id'),
        ]);
    }
}
