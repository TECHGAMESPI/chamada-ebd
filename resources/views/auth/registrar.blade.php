@extends('layouts.template')

@section('cabecalho')
    Novo Usuário
@endsection

@section('conteudo')
    @include('components.flash-message')
    <form method="post">
        @csrf
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Nome</label>
                        <input type="text" name="name" id="name" required class="form-control">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" id="email" required class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <!-- VER A POSSIBILIDADE DE CRIAR UMA CLASSE DE PERFIL -->
                    <div class="form-group">
                        <label for="perfil">Perfil</label>
                        <select class="form-control" name="perfil_id" aria-label="Default select example" required>
                            <option selected value="">Selecione</option>
                            @foreach ($perfis as $perfil)
                                <option value="{{ $perfil->id }}">{{ $perfil->perfil }}</option>
                            @endforeach

                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="estado_civil">Estado Civil</label>
                        <select class="form-control" name="estado_civil" aria-label="Default select example" required>
                            <option selected value="">Selecione</option>
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
                        <input type="date" name="data_nascimento" id="data_nascimento" required class="form-control">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="turma">Turma</label>
                        <select class="form-control" name="turma_id" aria-label="Default select example" required>
                            <option selected value="">Selecione</option>
                            @foreach ($turmas as $key => $turma)
                                <option value="{{ $turma->id }}">{{ $turma->nome_turma }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Telefone (Watsapp)</label>
                        <input type="tel" name="telefone" id="telefone" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password">Senha</label>
                        <input type="password" name="password" id="password" required min="1" class="form-control">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password">Confirma Senha</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            min="1" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md">
                    <button type="submit" class="btn btn-primary mt-3">
                        Registrar
                    </button>
                </div>
            </div>
        </div> <!-- Final do container -->
    </form>
@endsection
