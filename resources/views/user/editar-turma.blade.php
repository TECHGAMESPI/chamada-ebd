<x-app-layout>

    @section('cabecalho')
        Editar Turma
    @endsection

    <div class="row breadcrumbs-top d-inline-block mb-2">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('principal') }}">Home</a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('turmas') }}">Turmas</a>
                </li>
                <li class="breadcrumb-item active"><a href="{{ route('turma.edit', $turma) }}">Editar Turma </a>
                </li>
            </ol>
        </div>
    </div>
    <div class="card ">
        <div class="card-header">
            <h4 class="card-title">Editar Turma</h4>
        </div>
        <div class="card-content">
            <form method="post">
                @csrf
                @method('PUT')

                <div class="col">
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" name="nome_turma" value="{{ $turma->nome_turma }}" id="nome" required
                            class="form-control">
                        @error('nome_turma')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col">
                    <button type="submit" class="btn btn-primary mt-1 mb-2">
                        Atualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
