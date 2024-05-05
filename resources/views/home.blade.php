@extends('layouts/main_layout')
@section('content')

{{-- instrução IF simples --}}
@if($value == 100)
    <h1>Primeira parte do código</h1>
@endif

{{-- instrução IF ELSE --}}
@if($value != 100)
    <h1>Primeira parte do código</h1>
@else
    <h1>Segunda parte do código</h1>
@endif

{{-- instrução IF ELSEIF ELSE ENDIF --}}
@if($value < 10)
    <p>Primeiro</p>
    <div>
        <div>
            <div>
                
            </div>
        </div>
    </div>
@elseif($value < 20)
    <p>Segundo</p>
@elseif($value > 50)
    <p>Terceiro</p>
@elseif($value == 100)
    <p>Quarto</p>
@else
    <p>Outro caso</p>
@endif

@endsection