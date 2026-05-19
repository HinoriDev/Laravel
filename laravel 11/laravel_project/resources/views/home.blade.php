<x-main-layout >
    <p class="text-center text-secondary mb-5">Projeto simples de Laravel 11 com o intuíto de ser usado para testar a colocação em PRODUÇÃO</p>

    <div class="d-flex gap-5 justify-content-center mb-5">

        <a href="{{ route('clients.all') }}" class="btn btn-secondary px-5">CLIENTES (MySQL)</a>
        <a href="{{ route('create.file') }}" class="btn btn-secondary px-5">CRIAR FICHEIRO</a>
        <a href="{{ route('list.files') }}" class="btn btn-secondary px-5">LISTAR FICHEIROS</a>
        <a href="{{ route('delete.files') }}" class="btn btn-secondary px-5">ELIMINAR TODOS OS FICHEIROS</a>

    </div>

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

</x-main-layout>
