<div>
    <div class="row">
        <div class="col d-flex justify-content-between">
            @section('cabecalho')
                {{ $turma->nome_turma }}
            @endsection
            @section('botao')
                <div class="btn-group">
                    <button type="button" class="btn btn-info  dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-exchange-alt"></i>
                    </button>
                    @can('admin_superintendente')
                        <div class="dropdown-menu altera-curso">
                            @foreach ($turmas->all() as $turma)
                                <a class="dropdown-item" href="/user/chamada/{{ $turma->id }}">{{ $turma->nome_turma }}</a>
                            @endforeach
                        </div>
                    @elsecan('is_teacher')
                        <div class="dropdown-menu altera-curso">
                            @foreach ($minhasTurmas as $minhaTurma)
                                <a class="dropdown-item"
                                    href="/user/chamada/{{ $minhaTurma->id }}">{{ $minhaTurma->nome_turma }}</a>
                            @endforeach
                        </div>
                    @endcan

                </div>
            @endsection
        </div>
    </div>

    <div class="row breadcrumbs-top d-inline-block mb-2">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('principal') }}">Home</a>
                </li>
                <li class="breadcrumb-item active"><a href="{{ route('chamada') }}">Chamada </a>
                </li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-12 col-md-6">
            <label for="data-chamada">Data </label>
            <input class="form-control" type="date" value="" wire:model.live='data'>
            @error('data')
                <p>{{ $message }}</p>
            @enderror
        </div>
    </div>


    <div class="row d-md-flex justify-content-between align-items-center">

        <div class="col-12 col-sm-6 mt-2 mt-md-0">
            <input class="form-control" type="text" placeholder="Filtre pelo nome" wire:model.live='search'>
        </div>
        <div class="col-12 col-md-6 text-right">
            <label for='perpage' class="ps-3">Registros por página</label>
            <select id='perpage' wire:model.live="perpage" class="form-select my-3">
                <option value="15">15</option>
                <option value="20">20</option>
                <option value="30">30</option>
            </select>
        </div>

    </div>

    <x-flash-message></x-flash-message>

    <div class="card ">
        <div class="card-header">
            <h4 class="card-title">Alunos</h4>
            @error('chamada.unique')
                <p>{{ $message }}</p>
            @enderror
        </div>
        <div class="card-content">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr class="text-center">
                            <th class="border-top-0" scope="col">Aluno</th>
                            <th class="border-top-0" scope="col">Presença</th>
                            <th class="border-top-0" scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>



                        @foreach ($alunos as $i => $aluno)
                            <tr>
                                <td class="text-truncate text-center">
                                    <div class="col">
                                        <img class="rounded-circle" src="{{ asset($aluno->aluno->path_photo) }}"
                                            width="60" height="60">
                                    </div>
                                    <div class="col mt-1">
                                        {{ cutName($aluno->aluno->name) }}
                                    </div>
                                    <span class="badge badge-info">
                                        {{ calculateAge($aluno->aluno->data_nascimento) }}
                                    </span>
                                </td>
                                <td class="text-truncate">
                                    <div class="form-check">
                                        @if ($this->verificaPresenca($aluno->user_id))
                                            @if ($this->verificaPresenca($aluno->user_id)->falta_justificada == true)
                                                <div class="d-flex flex-column">
                                                    Falta Justificada regisrada
                                                </div>
                                            @else
                                                <div class="d-flex flex-column">
                                                    <div class="mb-2">
                                                        <input class="form-check-input" wire:click='registralivro'
                                                            checked name="" type="checkbox"
                                                            id="{{ $i }}" disabled>
                                                        <label class="form-check-label" for="{{ $i }}"
                                                            wire:click='registralivro'>
                                                            @if ($this->verificaPresenca($aluno->user_id)->livro == false)
                                                                Presença
                                                            @else
                                                                livro
                                                            @endif
                                                        </label>
                                                    </div>
                                                    <div class="mb-2">
                                                        <input class="form-check-input" name=""
                                                            @if ($this->verificaPresenca($aluno->user_id)->material == true) checked @endif
                                                            type="checkbox" disabled id="material_didatico" required>
                                                        <label class="form-check-label" for="material_didatico">
                                                            Bíblia
                                                        </label>
                                                    </div>
                                                </div>
                                            @endif
                                        @else
                                            <div class="d-flex flex-column">
                                                <div class="mb-2">
                                                    <input class="form-check-input" wire:change='registralivro'
                                                        name="livro" type="checkbox" id="{{ 'presenca' . $i }}">
                                                    <label class="form-check-label" for="{{ 'presenca' . $i }}">
                                                        livro
                                                    </label>
                                                </div>
                                                <div>
                                                    <input class="form-check-input" wire:change='registramaterial'
                                                        name="material" checked type="checkbox"
                                                        id="{{ 'material' . $i }}">
                                                    <label class="form-check-label" for="{{ 'material' . $i }}">
                                                        Bíblia
                                                    </label>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">

                                    @if (!$this->verificaPresenca($aluno->user_id))
                                        <div class="btn-group mr-1 mb-1">
                                            <button type="button" class="btn btn-primary"><i
                                                    class="fas fa-stopwatch"></i>
                                                Registrar </button>
                                            <button type="button" class="btn btn-primary dropdown-toggle"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                            </button>
                                            <div class="dropdown-menu" wire:key="{{ $aluno->user_id }}">

                                                <a class="dropdown-item" href="#"
                                                    wire:click.prevent="store({{ $aluno->user_id }} )">
                                                    Presença</a>
                                                <a class="dropdown-item" href="#"
                                                    wire:click.prevent="store({{ $aluno->user_id }}, {{ true }} )">Falta
                                                    Justificada</a>
                                            </div>
                                        </div>
                                    @elseif ($this->verificaPresenca($aluno->user_id))
                                        <a wire:click='destroy("{{ $aluno->user_id }}")'
                                            class="btn btn-danger btn-min-width mr-1 mb-1 text-white"
                                            alt="Excluir"><i class="fa fa-eraser" aria-hidden="true"></i> Deletar
                                            registro
                                        </a>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                        @if (count($alunos) == 0)
                            <tr>
                                <td class="text-center" colspan="3">

                                    <h2>Não existem alunos associados a essa turma!</h2>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @if (count($alunos) > 0)
        <div class="d-flex justify-content-center">
            {{ $alunos->links() }}
        </div>
    @endif

    <!-- Botão para abrir modal de visitantes -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#visitantesModal">
        Registrar Visitantes
    </button>

    <!-- Modal de Visitantes -->
    <div class="modal fade" id="visitantesModal" tabindex="-1" role="dialog" aria-labelledby="visitantesModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="visitantesModalLabel">Registrar Visitantes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="storeVisitantes">
                        <!-- Quantidade de visitantes -->
                        <div class="form-group">
                            <label>Quantidade de Visitantes</label>
                            <input type="number" class="form-control" wire:model="visitante_quantidade" min="1" required>
                        </div>

                        <!-- Quantidade de Bíblias -->
                        <div class="form-group">
                            <label>Quantidade de Bíblias</label>
                            <input type="number" class="form-control" wire:model="visitante_biblias" min="0" required>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Registrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
