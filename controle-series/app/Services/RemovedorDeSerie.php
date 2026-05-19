<?php

namespace App\Services;

use App\Models\{Serie, Temporada, Episodio};
use Illuminate\Session\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Events\SerieApagada;
use App\Jobs\ExcluirCaoaSerie;
use App\Jobs\ExcluirCapaSerie;
use App\Listeners\ExcluirCapaSerie as ListenersExcluirCapaSerie;

class RemovedorDeSerie
{
public function removerSerie(int $serieId): string
{
    $nomeSerie = '';

    DB::transaction(function () use ($serieId, &$nomeSerie) {
        $serie = Serie::find($serieId);
        $nomeSerie = $serie->nome;

        $serieObj = (object) [
            'id' => $serie->id,
            'capa' => $serie->capa
        ];

        $evento = new SerieApagada($serie);
        event($evento);

        $this->removerTemporadas($serie);
        $serie->delete();

        if ($serieObj->capa) {
            ExcluirCapaSerie::dispatch($serieObj);
        }
    });

    return $nomeSerie;
}
    private function removerTemporadas(Serie $serie): void
    {   
        $serie->temporadas->each(function (Temporada $temporada) {
            $this->removerEpisodios($temporada);
            $temporada->delete();
        });

    }

    private function removerEpisodios(Temporada $temporada): void
    {
        $temporada->episodios->each(function (Episodio $episodio) {
            $episodio->delete();
        });
      
    }
}