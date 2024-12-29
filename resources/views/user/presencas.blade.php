<x-app-layout>

    @section('cabecalho')
        Minhas Presenças
    @endsection

    @include('components.flash-message')
    <div class="table-responsive">
        <table class="table" id="datatablesSimple">
            <thead>
                <tr class="">
                    <th scope="col">Data</th>
                    <th scope="col">Turma</th>
                    <th scope="col">Tipo Presença</th>
                    <th scope="col">Professor</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($chamadas as $chamada)
                    <tr>
                        <td>{{ $chamada->data }}</td>
                        <td>{{ $chamada->turma }}</td>
                        <td>{{ $chamada->tipo_presenca }}</td>
                        <td>{{ $chamada->professor }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
