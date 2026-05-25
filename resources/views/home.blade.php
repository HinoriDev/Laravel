@extends('layouts/main_layout')
@section('content')

@production
<p>Estou em ambiente de produção</p>
@else
<p>{{$value}}</p>
@endproduction

@env(['local', 'development'])
<p>Estou no ambiente {{env('APP_ENVI')}}</p>
@endenv

{{--formulário--}}
<form action="{{route("submit")}}" method="post">
    @csrf
    <div>
    <input type="text" name="name">
        @error('name')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    </div>

    <div>
<input type="text" name="country">
        @error('country')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    </div>
    
    <button type="submit">enviar</button>

</form>

@endsection