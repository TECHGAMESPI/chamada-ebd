<x-app-layout>

    @section('cabecalho')
        Usuários
    @endsection

    @include('components.flash-message')
    <div class="table-responsive">
        <table class="table" id="datatablesSimple">
            <thead>
                <tr>
                    <th scope="col">Matricula</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Nascimento</th>
                    <th scope="col">Perfil</th>
                    <th scope="col">Igreja</th>
                    @if (Auth::user()->perfil_id == App\Models\Perfil::ADMINISTRADOR ||
                            Auth::user()->perfil_id == App\Models\Perfil::SUPERINTENDENTE)
                        <th scope="col">Ações</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)
                    <tr>
                        <th scope="row">{{ $usuario->id }}</th>
                        <td>{{ $usuario->name }}</td>
                        <td>{{ date('d/m/Y', strtotime($usuario->data_nascimento)) }}</td>
                        <td>{{ $perfil->find($usuario->perfil_id)->perfil }} </td>
                        <td>{{ App\Models\User::getIgrejaName($usuario->id) }}</td>
                        @if (Auth::user()->perfil_id == App\Models\Perfil::ADMINISTRADOR ||
                                Auth::user()->perfil_id == App\Models\Perfil::SUPERINTENDENTE)
                            <td>
                                <p class="text-center pointer" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-cog"></i>
                                </p>

                                <div class="dropdown-menu">
                                    <span class="dropdown-item">
                                        <a class="btn" href="{{ route('user.edit', ['id' => $usuario->id]) }}"><i
                                                class="fas fa-edit"></i> Editar</a>
                                    </span>

                                    <span class="dropdown-item"">
                                        <form action="{{ route('delete.user', ['id' => $usuario->id]) }}" method="post"
                                            onsubmit="return confirm('Tem certeza? Todos os registros serão apagados e não poderão ser recuperados.')">
                                            @csrf
                                            @method('DELETE')
                                            {{-- <input type="hidden" name="turma_id" value="{{ $turma->id }}"> --}}
                                            <button class="btn" alt="Excluir"><i class="fa fa-eraser"
                                                    aria-hidden="true"></i> Excluir</button>
                                        </form>
                                    </span>
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
