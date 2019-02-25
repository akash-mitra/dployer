<?php

namespace App\Jobs;

use App\Droplet;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateNewDroplet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $droplet;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Droplet $droplet)
    {
        $this->droplet = $droplet;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        var_dump('Got ' . $this->droplet);
    }
}
