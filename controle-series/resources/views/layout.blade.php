<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Séries</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-2 d-flex justify-content-between">
        <a href="{{ route('listar_series') }}" class="navbar-brand">Home</a>
        @auth
        <a href="/sair" class="text-danger">Sair</a>
        @endauth
        
        @guest
        <a href="/entrar">Entrar</a>
        @endguest
    </nav>
    <div class='container'>
<div class="jumbotron">
    <h1>@yield('cabecalho')</h1>
</div>
@yield('conteudo')
    </div>
</body>
</html>