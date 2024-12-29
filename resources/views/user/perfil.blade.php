<x-app-layout>

    @section('cabecalho')
        Perfil
    @endsection

    @include('components.flash-message')
    <form method="post">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" id="name" value="{{ Auth::user()->id }}" required class="form-control">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ asset(auth()->user()->path_photo) }}" style="max-width: 200px;">
                </div>
                <div class="col-md">
                    <div class="form-group">
                        <label for="email">Nome</label>
                        <input type="text" name="name" id="name" value="{{ Auth::user()->name }}" required
                            class="form-control">
                    </div>
                </div>

                <div class="col-md">
                    <div class="form-group">
                        <label for="email">Usuário</label>
                        <input type="email" name="email" id="email" value="{{ Auth::user()->email }}" required
                            class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="perfil">Perfil</label>
                        <input type="text" name="perfil" id="perfil" value="{{ $perfil }}" readonly
                            required class="form-control">
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                        <label for="estado_civil">Estado Civil</label>
                        <select class="form-control" name="estado_civil" aria-label="Default select example" required>
                            <option selected value="{{ Auth::user()->estado_civil }}">{{ Auth::user()->estado_civil }}
                            </option>
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
                            value="{{ Auth::user()->data_nascimento }}"required class="form-control">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="telefone">Telefone (Watsapp)</label>
                        <input type="tel" name="telefone" id="telefone" class="form-control"
                            value="{{ Auth::user()->telefone }}">
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
