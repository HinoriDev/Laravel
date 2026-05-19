<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;

class ExcluirCapaSerie implements ShouldQueue
{
    use Queueable;

    public $serie;  

    /**
     * Create a new job instance.
     */
    public function __construct($serie)
    {
        $this->serie = $serie;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $serie = $this->serie;
        if($serie->capa)
            {
            Storage::disk('public')->delete($serie->capa);
            }
    }
}
