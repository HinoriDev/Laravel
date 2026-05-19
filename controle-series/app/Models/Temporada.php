<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Builder\Function_;
use PhpParser\Node\Expr\FuncCall;

class Temporada extends Model
{
    protected $fillable = ['numero'];
    public $timestamps = false;
    public function episodios(){
        return $this->hasMany(related: Episodio::class);
    }

    public function serie() {
        return $this->belongsTo(related: Serie::class);
    }

    public function getEpisodiosAssistidos(): Collection 
    {
        return $this->episodios->filter(function (Episodio $episodio) {
            return $episodio->assistido;
        });
    }
}
