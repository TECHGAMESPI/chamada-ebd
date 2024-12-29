@extends('layouts.template')

@section('cabecalho')
            Chamada - {{$nomeTurma}}
@endsection

@if(Auth::user()->perfil_id !== "2")
@section('botao')

    <div class="btn-group">
        <button type="button" class="btn btn-info  dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-exchange-alt"></i> Alterar
        </button>
        @if(Auth::user()->perfil_id === 1)
            <div class="dropdown-menu altera-curso">
                @foreach($turmas->all() as $turma)
                    <a class="dropdown-item" href="/user/chamada/{{$turma->id}}">{{ $turma->nome_turma}}</a>
                @endforeach
            </div>
        @else
            <div class="dropdown-menu altera-curso">
                @foreach($minhasTurmas as $minhaTurma)
                    <a class="dropdown-item" href="/user/chamada/{{$minhaTurma->turma_id}}">{{$turmas->find($minhaTurma->turma_id)->nome_turma}}</a>
                @endforeach
            </div>
        @endif
    </div>
@endsection
@endif

@section('conteudo')
    @include('components.flash-message')
    <livewire:chamada />

@endsection


