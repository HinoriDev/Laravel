<?php

namespace App\Listeners;

use App\Events\SerieApagada;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;

class ExcluirCapaSerie
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SerieApagada $event)
    {
        $serie = $event->serie;
        if($serie->capa)
            {
            Storage::disk('public')->delete($serie->capa);
            }
    }
}
