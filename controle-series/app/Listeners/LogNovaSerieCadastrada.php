<?php

namespace App\Listeners;

use App\Events\NovaSerie;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log; 

class LogNovaSerieCadastrada implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }


    public function handle(NovaSerie $event): void
    {
        $nomeSerie = $event->nomeSerie;
        $qtdTemporadas = $event->qtdTemporadas;
        $qtdEpisodios = $event->qtdEpisodios;


        Log::info("Série nova cadastrada: " . $nomeSerie);
    }
}