<div>
    @section('cabecalho')
        Usuários
    @endsection

    <div class="row breadcrumbs-top d-inline-block">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('principal') }}">Home</a>
                </li>
                <li class="breadcrumb-item active"><a href="#">Usuários</a>
                </li>
            </ol>
        </div>
    </div>
    <section class="row d-md-flex justify-content-between align-items-center">

        <div class="col-12 col-sm-6 mt-2 mt-md-0">
            <input class="form-control" type="text" placeholder="Filtre" wire:model.live='search'>
        </div>
        <div class="col-12 col-md-6 text-right">
            <label for='perpage' class="ps-3">Registros por página</label>
            <select id='perpage' wire:model.live="perpage" class="form-select my-3">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="20">20</option>
            </select>
        </div>
    </section>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Nascimento</th>
                            <th scope="col">Perfil</th>
                            <th scope="col">Igreja</th>
                            @can('admin_superintendente')
                                <th scope="col">Status</th>
                                <th scope="col">Ações</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $usuario)
                            <tr>
                                <td>{{ $usuario->name }}</td>
                                <td>
                                    <span class="me-5">
                                        {{ date('d/m/Y', strtotime($usuario->data_nascimento)) }}
                                    </span>

                                    <span class="badge badge-primary">
                                        {{ calculateAge($usuario->data_nascimento) }}
                                    </span>
                                </td>
                                <td>{{ $usuario->perfil }} </td>
                                <td>{{ $this->getChurchName($usuario) }}</td>
                                @can('admin_superintendente')
                                    <td>
                                        @if ($usuario->is_active)
                                            <span style="cursor: pointer;" class="badge badge-success"
                                                wire:click="changeStatus({{ $usuario->user_id }})">ativo</span>
                                        @else
                                            <span style="cursor: pointer;" class="badge badge-danger"
                                                wire:click="changeStatus({{ $usuario->user_id }})">inativo</span>
                                        @endif
                                    </td>

                                    <td>
                                        <p class="text-center pointer" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-cog"></i>
                                        </p>

                                        <div class="dropdown-menu">
                                            <span class="dropdown-item">
                                                <a class="btn"
                                                    href="{{ route('user.edit', ['id' => $usuario->user_id]) }}"><i
                                                        class="fas fa-edit"></i> Editar</a>
                                            </span>

                                            <span class="dropdown-item"">
                                                <form action="{{ route('delete.user', ['id' => $usuario->user_id]) }}"
                                                    method="post"
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
                                @endcan
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row d-flex justify-content-center">
        {{ $usuarios->links() }}
    </div>
</div>
