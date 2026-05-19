<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Services\CriadorDeSerie;
use App\Models\Serie;
use Illuminate\Foundation\Testing\WithFaker;


class CriadorDeSerieTest extends TestCase
{
      use RefreshDatabase;
      
    public function testeCriarSerie()
    {
        // Arrange (Preparação)
        $criadorDeSerie = new CriadorDeSerie();
        $nomeSerie = 'Nome de teste';
        $serieCriada = $criadorDeSerie->criarSerie(
            $nomeSerie, 
            qtdTemporadas: 1, 
            epPorTemporada: 1
        );

        // Assert (Verificação)
        $this->assertInstanceOf(Serie::class, $serieCriada);
        
        // Verifica se os dados realmente foram persistidos no banco
        $this->assertDatabaseHas('series', ['nome' => $nomeSerie]);
        
        $this->assertDatabaseHas('temporadas', [
            'serie_id' => $serieCriada->id, 
            'numero' => 1
        ]);
        
        $this->assertDatabaseHas('episodios', [
            'numero' => 1
        ]);
    }
}