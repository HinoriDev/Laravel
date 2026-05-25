@extends('layouts/main_layout')
@section('content')

{{-- empty --}}
@empty($value)
<p>Não existe</p>
@else
<p>Existe</p>
@endempty
{{-- isset --}}
@isset($value)
<p>Existe a variável</p>
@else   
<p>Não existe a variável</p>
@endisset
{{-- unless --}}
@unless($value != 100)
<p>Ok!!!!</p>

@endunless

@endsection