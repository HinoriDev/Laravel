<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeriesFormRequest;
use Illuminate\Http\Request; 
use App\Models\Serie;
use App\Services\CriadorDeSerie;
use App\Models\Episodio;
use App\Models\Temporada;
use App\Services\RemovedorDeSerie;
use Illuminate\Support\Facades\Mail;
use App\Mail\NovaSerie;
use App\Models\User;



class SeriesController extends Controller 
{
    public function listarSeries(Request $request) 
    {
        $series = Serie::query()
            ->orderBy(column:'nome')
            ->get();
        $mensagem = $request->session()->get(key:'mensagem');

        return view('series.index', compact('series', 'mensagem'));
    }

    public function create(){
        return view(view:'series.create');
    }

public function store(SeriesFormRequest $request, CriadorDeSerie $criadorDeSerie)
{
    $capa = null;
    if($request->hasfile(key:'capa'))
        {
         $capa = $request->file('capa')->store('serie','public');
        }

    $serie = $criadorDeSerie->criarSerie(
        $request->nome, 
        $request->qtd_temporadas, 
        $request->ep_por_temporada,
        $capa
    );
    $eventoNovaSerie = new \App\Events\NovaSerie(
        $request->nome,
        $request->qtd_temporadas,
        $request->ep_por_temporada
    );
    event($eventoNovaSerie);

    $request->session()->flash('mensagem', "Serie {$serie->id} e suas temporadas e episódios criadas com sucesso {$serie->nome}");

    return redirect()->route('listar_series');
}
public function destroy(Request $request, RemovedorDeSerie $removedorDeSerie)
{ 
    $nomeSerie = $removedorDeSerie ->removerSerie($request->id);
    $request->session()->flash('mensagem', "Série $nomeSerie removida com sucesso");

    return redirect()->route(route:'listar_series');
}

public function editaNome(int $id, Request $request)
{
    $novoNome = $request->nome;
    $serie = Serie::find($id);
    $serie->nome = $novoNome;
    $serie->save();
}
}