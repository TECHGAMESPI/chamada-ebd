<x-app-layout>

    @section('cabecalho')
        Alterar Senha
    @endsection

    <div class="row breadcrumbs-top d-inline-block mb-2">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('principal') }}">Home</a>
                </li>
                <li class="breadcrumb-item active"><a href="#">Alterar Senha</a>
                </li>
            </ol>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <form method="post" action="{{ route('alterar-senha') }}">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Nova Senha</label>
                            <input type="password" name="password" id="password" required min="8"
                                class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Confirma Senha</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                min="8" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md">
                        <button type="submit" class="btn btn-primary">
                            Alterar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
