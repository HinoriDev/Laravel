<x-main-layout>
    <table class="table table-bordered table-striped">

        <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </thead>

        <tbody class="table-dark">
            @foreach($clients as $client)
                <tr>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->email }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $clients->links() }}


</x-main-layout>
