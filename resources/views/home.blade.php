@extends('layouts/main_layout')
@section('content')

@session('status')
    <h3>A sessão tem o valor {{ session('name') }}</h3>
@endsession

@endsection