<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\CriadorDeSerie;
use App\Services\RemovedorDeSerie;
use App\Models\Serie;

class RemovedorDeSerieTest extends TestCase
{
    use RefreshDatabase;
    /** @var Serie */
    private $serie;
    protected function setUp(): void
    {
        parent::setUp();
        $criadorDeSerie = new CriadorDeSerie();
        $this->serie = $criadorDeSerie->criarSerie(
            nomeSerie: 'Nome da série',
            qtdTemporadas: 1,
            epPorTemporada: 1
        );
    }
    public function testRemoverUmaSerie()
    {
        $this->assertDatabaseHas('series', ['id' => $this->serie->id]);
        $removedorDeSerie = new RemovedorDeSerie();
        $nomeSerie = $removedorDeSerie->removerSerie($this->serie->id);
        $this->assertIsString($nomeSerie);
        $this->assertEquals('Nome da série', $this->serie->nome);
        $this->assertDatabaseMissing('series', ['id' => $this->serie->id]);
    }
}