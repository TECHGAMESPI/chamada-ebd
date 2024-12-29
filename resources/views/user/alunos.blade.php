<x-app-layout>

    @section('cabecalho')
        Alunos
    @endsection


    <table class="table">
        <thead>
            <tr>
                <th scope="col">Matricula</th>
                <th scope="col">Nome</th>
                <th scope="col">Nascimento</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($alunos as $aluno)
                <tr>
                    <th scope="row">{{ $aluno->id }}</th>
                    <td>{{ $aluno->name }}</td>
                    <td>{{ date('d/m/Y', strtotime($aluno->data_nascimento)) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>
