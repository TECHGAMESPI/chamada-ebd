<div>
    <div class="row">
        <div class="col d-flex justify-content-between">
            @section('cabecalho')
                Turmas
            @endsection
            @section('botao')
                @can('admin_superintendente')
                    <div class="btn-group">
                        <a href="{{ route('turma.create') }}" class="btn btn-info"> + </a>
                    @endcan
                @endsection
            </div>
        </div>

        <div class="row breadcrumbs-top d-inline-block mb-2">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('principal') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active"><a href="{{ route('turmas') }}">Turmas </a>
                    </li>
                </ol>
            </div>
        </div>

        <div class="row d-md-flex justify-content-between align-items-center">

            <div class="col-12 col-sm-6 mt-2 mt-md-0">
                <input class="form-control" type="text" placeholder="Filtre pelo nome" wire:model.live='search'>
            </div>
            <div class="col-12 col-md-6 text-right">
                <label for='perpage' class="ps-3">Registros por página</label>
                <select id='perpage' wire:model.live="perpage" class="form-select my-3">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                </select>
            </div>

        </div>

        <div class="card ">
            <div class="card-header">
                <h4 class="card-title">Turmas</h4>
            </div>
            <div class="card-content">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr class="text-center">
                                <th class="border-top-0" scope="col">Nome</th>
                                @can('admin_superintendente')
                                    <th class="border-top-0" scope="col">Status</th>
                                    <th class="border-top-0" scope="col">Ações</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($turmas as $turma)
                                <tr>
                                    <td class="text-truncate text-center">
                                        {{ $turma->nome_turma }}
                                    </td>
                                    @can('admin_superintendente')
                                        <td class="text-truncate text-center"">
                                            @if ($turma->is_active)
                                                <span style="cursor: pointer;" class="badge bg-success"
                                                    wire:click="changeStatus({{ $turma }})">Ativo</span>
                                            @else
                                                <span style="cursor: pointer;" class="badge bg-danger"
                                                    wire:click="changeStatus({{ $turma }})">Inativo</span>
                                            @endif
                                        </td>

                                        <td>
                                            <span class="d-flex justify-content-center">
                                                <a href="/user/turma/{{ $turma->id }}/editar" class="btn btn-primary"
                                                    alt="Editar"><i class="fas fa-edit"></i></a>
                                                <form action="{{ route('excluir-turma') }}" method="post"
                                                    onsubmit="return confirm('Tem certeza? Os dados serão apagados permanentemente.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="turma_id" value="{{ $turma->id }}">
                                                    <button class="btn btn-danger" alt="Excluir"><i class="fa fa-eraser"
                                                            aria-hidden="true"></i></button>
                                                </form>
                                            </span>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                            @if (count($turmas) == 0)
                                <tr>
                                    <td class="text-center" colspan="3">
                                        <h2>Não existem turmas cadastradas!</h2>
                                    </td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @if (count($turmas) > 0)
            <div class="d-flex justify-content-center">
                {{ $turmas->links() }}
            </div>
        @endif
    </div>
</div>
