@extends('layouts.template')

@section('cabecalho')
    Registrar Aluno
@endsection
@section('conteudo')
    @include('components.flash-message')
    <form method="post">
        @csrf
        <input type="hidden" name="perfil_id" value="2">
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
                 <label for="email">Acesso (nome_aluno@aluno)</label>
                 <input type="email" name="email" id="email" required class="form-control">
             </div>
         </div>
     </div>

     <div class="row">
         <div class="col-md">
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

         <div class="col-md">
             <div class="form-group">
                 <label for="estado_civil">Turma</label>
                 <select class="form-control" name="turma_id" aria-label="Default select example" required>
                     <option selected value="">Selecione</option>
                     @foreach($turmas as $turma)
                     <option value="{{ $turma->turma_id }}">{{$repositorioTurmas->find($turma->turma_id)->nome_turma}}</option>
                     @endforeach
                 </select>
             </div>
         </div>

         <div class="col-md">
             <div class="form-group">
                 <label for="data_nascimento">Data de Nascimento</label>
                 <input type="date" name="data_nascimento" id="data_nascimento" required class="form-control">
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
                 <input type="password" name="password_confirmation" id="password_confirmation" required min="1" class="form-control">
             </div>
         </div>
     </div>

     <div class="row">
         <div class="col">
             <button type="submit" class="btn btn-primary mt-3">
                 Registrar
             </button>
         </div>
     </div>
   </div><!-- FIM DO CONTAINER -->
 </form>
@endsection


