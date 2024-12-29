<x-app-layout>

    @section('cabecalho')
        Associar Professor
    @endsection

    @include('components.flash-message')
    <div class="table-responsive">
        <table class="table" id="datatablesSimple">
            <thead>
                <tr class="">
                    <th scope="col">Professor</th>
                    <th scope="col">Turma</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($professores as $professor)
                    <tr>
                        <form method="post">
                            @csrf
                            <input type="hidden" name="professor" value="{{ $professor->id }}">
                            <td>{{ $professor->name }}</td>
                            <td>
                                <select class="form-control" name="turma" aria-label="Default select example"
                                    required>
                                    <option selected value="">Selecione</option>
                                    @foreach ($turmas as $turma)
                                        <option value="{{ $turma->id }}">{{ $turma->nome_turma }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-primary">
                                    Associar
                                </button>
                            </td>
                        </form>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
