<x-app-layout>
    @section('cabecalho')
        Editar Usuário
    @endsection

    @include('components.flash-message')
    <form method="post">
        @csrf
        @method('PUT')
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Nome</label>
                        <input type="text" name="name" id="name" value="{{ $usuario->name }}" required
                            class="form-control">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Usuário</label>
                        <input type="email" name="email" value="{{ $usuario->email }}" id="email" required
                            class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="perfil">Perfil</label>
                        <select class="form-control" name="perfil_id" aria-label="Default select example" required>
                            <option selected value="">Selecione</option>

                            {{-- <option selected value="{{ $perfilAtual->id }}">{{ $perfilAtual->perfil }}</option> --}}
                            @foreach ($perfis as $perfil)
                                @if (!Auth::user()->perfil_id == App\Models\Perfil::ADMINISTRADOR && $perfil->id == App\Models\Perfil::ADMINISTRADOR)
                                    @continue
                                @endif
                                <option @if ($perfilAtual->id == $perfil->id) selected @endif value="{{ $perfil->id }}">
                                    {{ $perfil->perfil }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="estado_civil">Estado Civil</label>
                        <select class="form-control" name="estado_civil" aria-label="Default select example" required>
                            <option selected value="{{ $usuario->estado_civil }}">{{ $usuario->estado_civil }}</option>
                            <option value="Solteiro(a)">Solteiro(a)</option>
                            <option value="Casado(a)">Casado(a)</option>
                            <option value="Viuvo(a)">Viuvo(a)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="data_nascimento">Data de Nascimento</label>
                        <input type="date" name="data_nascimento" id="data_nascimento"
                            value="{{ $usuario->data_nascimento }}" required class="form-control">
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="telefone">Telefone (Watsapp)</label>
                        <input type="tel" name="telefone" id="telefone" class="form-control"
                            value="{{ $telefone }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md">
                    <button type="submit" class="btn btn-primary mt-3">
                        Atualizar
                    </button>
                </div>
            </div>
        </div> <!-- Final do container -->
    </form>
</x-app-layout>
