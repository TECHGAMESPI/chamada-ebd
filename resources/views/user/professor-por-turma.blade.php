<x-app-layout>

    @section('cabecalho')
        Professor por Turma
    @endsection

    @include('components.flash-message')
    <div class="table-responsive">
        <table class="table" id="datatablesSimple">
            <thead>
                <tr class="">
                    <th scope="col">Professor</th>
                    <th scope="col">Turma</th>
                    @if (Auth::user()->perfil_id == App\Models\Perfil::ADMINISTRADOR ||
                            Auth::user()->perfil_id == App\Models\Perfil::SUPERINTENDENTE)
                        <th scope="col">Ações</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($professores as $professor)
                    <tr>
                        <td>{{ $professor->user->name }}</td>
                        <td>{{ $professor->turma->nome_turma }}</td>
                        @if (Auth::user()->perfil_id == App\Models\Perfil::ADMINISTRADOR ||
                                Auth::user()->perfil_id == App\Models\Perfil::SUPERINTENDENTE)
                            <td>
                                <form action="{{ route('excluir-professor') }}" method="post"
                                    onsubmit="return confirm('Tem certeza?')">
                                    @csrf
                                    <input type="hidden" name="turma_id" value="{{ $professor->turma_id }}">
                                    <input type="hidden" name="professor_id" value="{{ $professor->professor_id }}">
                                    <button class="btn btn-danger" alt="Excluir"><i class="fa fa-eraser"
                                            aria-hidden="true"></i></button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
