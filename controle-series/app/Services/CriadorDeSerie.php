<?php

namespace App\Services;

use App\Models\Serie;
use App\Models\Temporada;
use Illuminate\Support\Facades\DB;

class CriadorDeSerie
{
    // CORREÇÃO: ?string $capa = null torna o parâmetro opcional se o controller não enviá-lo
    public function criarSerie(string $nomeSerie, int $qtdTemporadas, int $epPorTemporada, ?string $capa = null): Serie
    {   
        DB::beginTransaction(); 
        $serie = Serie::create(['nome' => $nomeSerie, 'capa' => $capa]);
        $this->criarTemporadas($qtdTemporadas, $epPorTemporada, $serie);
        DB::commit();

        return $serie;
    }

    private function criarTemporadas(int $qtdTemporadas, int $epPorTemporada, Serie $serie): void
    {
        for ($i = 1; $i <= $qtdTemporadas; $i++) {
            $temporada = $serie->temporadas()->create(['numero' => $i]);
            $this->criarEpisodios($epPorTemporada, $temporada);
        }
    }

    private function criarEpisodios(int $epPorTemporada, Temporada $temporada): void
    {
        for ($j = 1; $j <= $epPorTemporada; $j++) {
            $temporada->episodios()->create(['numero' => $j]);
        }
    }
}