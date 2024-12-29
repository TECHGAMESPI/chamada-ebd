<div>

    <div class="d-flex justify-content-between align-items-center">

        @section('cabecalho')
            Igrejas
        @endsection

        @section('botao')
            <a href="{{ route('igrejas.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Nova igreja
            </a>
        @endsection
    </div>
    <div class="row breadcrumbs-top d-inline-block">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('principal') }}">Home</a>
                </li>
                <li class="breadcrumb-item active"><a href="#">Igrejas</a>
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

    <div class="card table-responsive">
        <table class="card-body table">
            <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">EBD</th>
                    <th scope="col" class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($igrejas as $igreja)
                    <tr>
                        <td><a href="{{ route('igrejas.show', $igreja->id) }}">{{ $igreja->nome }}</a></td>
                        <td>{{ $igreja->dia_ebd }} de {{ $igreja->horario }}</td>
                        <td>

                            <p class="text-center pointer" data-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-cog"></i>
                            </p>

                            <div class="dropdown-menu">
                                <a class="dropdown-item"
                                    href="{{ route('igrejas.edit', ['id' => $igreja->id]) }}">Editar</a>
                                <a class="dropdown-item" href="#"
                                    onclick="return confirm('Você tem certeza? Essa ação não poderá ser desfeita') ||  event.stopImmediatePropagation()"
                                    wire:click='destroy({{ $igreja->id }})'>Excluir</a>
                                <a class="dropdown-item"
                                    href="{{ route('igrejas.show', ['id' => $igreja->id]) }}">Visualizar</a>

                            </div>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">
        {{ $igrejas->links() }}
    </div>
</div>
