<x-app-layout>

    @section('cabecalho')
        Registrar Turma
    @endsection

    <div class="row breadcrumbs-top d-inline-block mb-2">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('principal') }}">Home</a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('turmas') }}">Turmas</a>
                </li>
                <li class="breadcrumb-item active"><a href="{{ route('chamada') }}">Registrar Turma </a>
                </li>
            </ol>
        </div>
    </div>
    <div class="card ">
        <div class="card-header">
            <h4 class="card-title">Nova Turma</h4>
        </div>
        <div class="card-content">
            <form method="post" action="{{ route('turma.store') }}">
                @csrf
                <div class="col">
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" name="nome_turma" id="nome" class="form-control">
                    </div>
                    @error('nome_turma')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-primary mt-1 mb-2">
                        Registrar
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
