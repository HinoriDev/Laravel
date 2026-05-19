<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Temporada;
use App\Models\Episodio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class TemporadaTest extends TestCase
{
    /** @var Temporada */
    private $temporada;

    public function setUp(): void
    {
        parent::setUp();
        $temporada = new Temporada();
        $episodio1 = new Episodio();
        $episodio1->assistido = true;
        $episodio2 = new Episodio();
        $episodio2->assistido = false;
        $episodio3 = new Episodio();
        $episodio3->assistido = true;
        $temporada->episodios->add($episodio1);
        $temporada->episodios->add($episodio2);
        $temporada->episodios->add($episodio3);
        
        $this->temporada = $temporada;
    }

    public function testeBuscaPorEpisodiosAssistidos()
    {
        $episodiosAssistidos = $this->temporada->getEpisodiosAssistidos();
        $this->assertCount(2, $episodiosAssistidos);
        foreach ($episodiosAssistidos as $episodio) {
            $this->assertTrue($episodio->assistido);
        }
    }

    public function testeBuscaTodosOsEpisodios()
    {
        $episodios = $this->temporada->episodios;
        $this->assertCount(3, $episodios);
    }
}

