<x-main-layout>
    <p class="display-6">Lista de ficheiros</p>
    <hr>

    @empty($files)
        <p class="text-secondary">Não existem ficheiros</p>
    @else
        <ul>
            @foreach ($files as $file)
                <li>
                    {{ $file }}
                </li>
            @endforeach
        </ul>

        <a href="{{ route('delete.files') }}" class="btn btn-danger">Eliminar todos os ficheiros</a>

    @endif
</x-main-layout>
