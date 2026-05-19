<?php

namespace App\Listeners;

use App\Events\NovaSerie as NovaSerieEvent; 
use App\Mail\NovaSerie as NovaSerieMail;  
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;       
use App\Models\User;

class EnviarEmailNovaSerieCadastrada implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    public function handle(NovaSerieEvent $event): void // Usa o apelido do evento aqui
    {
        $nomeSerie = $event->nomeSerie;
        $qtdTemporadas = $event->qtdTemporadas;
        $qtdEpisodios = $event->qtdEpisodios;
        
        $users = User::all();
        
        foreach ($users as $indice => $user) 
        {
            $multiplicador = $indice + 1;
            
            $email = new NovaSerieMail(
                $nomeSerie,
                $qtdTemporadas,
                $qtdEpisodios
            );
            
            $email->subject = 'Nova série adicionada!';
            $quando = now()->addSeconds($multiplicador * 10);
            
            Mail::to($user)->later(
                $quando,
                $email
            );
        }
    }
}