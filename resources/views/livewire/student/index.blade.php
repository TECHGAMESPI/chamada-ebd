<div>
    @section('cabecalho')
        Alunos por Turma
    @endsection
    <div class="row breadcrumbs-top d-inline-block">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('principal') }}">Home</a>
                </li>
                <li class="breadcrumb-item active"><a href="#">Alunos por turma</a>
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
                        <tr class="">
                            <th scope="col">Aluno</th>
                            <th scope="col">Turma</th>
                            @can('admin_superintendente')
                                <th scope="col">Ações</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($alunos as $aluno)
                            <tr>
                                <td>{{ $aluno->name }}</td>
                                <td>{{ $aluno->nome_turma }}</td>
                                @can('admin_superintendente')
                                    <td>
                                        <a href="#" class="btn btn-danger"
                                            onclick="return confirm('Tem certeza?') || event.stopImmediatePropagation()"
                                            wire:click.prevent='delete({{ $aluno->user_id }}, {{ $aluno->turma_id }})'>
                                            <i class="fa fa-eraser" aria-hidden="true"></i>
                                        </a>
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
        {{ $alunos->links() }}
    </div>

</div>
