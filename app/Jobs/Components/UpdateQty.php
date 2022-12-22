<?php

namespace App\Jobs\Components;

use App\Models\Component;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateQty implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Component $component
     */
    public Component $component;

    /**
     * Create a new job instance.
     *
     * @param Component $component
     */
    public function __construct(Component $component)
    {
        $this->component = $component;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->component->loadMissing('serials');

        // If the component has serials, we need to update the qty to match the number of serials.
        $this->component->qty = $this->component->serials->count();

        if ($this->component->isDirty('qty')) {
            $this->component->save();
        }
    }
}
