<div>
    <style>
        .pointer {
            cursor: pointer;
        }
    </style>
    <div class="content-header row">
        <div class="mb-2 content-header-left col-md-6 col-12 breadcrumb-new">
            @section('cabecalho')
                {{ $quiz->title }}
            @endsection

            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('principal') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item "><a href="{{ route('quiz.index') }}">Quizzes</a>
                        </li>
                        <li class="breadcrumb-item active"><a href="#">{{ $quiz->title }}</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h3>Detalhes do Quiz</h3>
            @can('actionsQuiz', $quiz)
                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                        aria-expanded="false">
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('quiz.scheduling.create', ['quiz' => $quiz]) }}">Novo
                            Agendamento</a>
                        <a class="dropdown-item" href="{{ route('quiz.edit', ['quiz' => $quiz]) }}">Editar</a>
                        <form action="{{ route('quiz.delete', $quiz) }}" method="POST"
                            onsubmit="return confirm('Você tem certeza? Essa ação não poderá ser desfeita')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item">Excluir</button>
                        </form>
                    </div>
                </div>
            @endcan
        </div>
        <div class="card-body">
            <p><b>Titulo:</b> {{ $quiz->title }}</p>
            <p><b>Tipo:</b> {{ $quiz->type }}</p>
            <p><b>Total de Questões:</b> {{ $quiz->questions->count() }}</p>
            <p><b>Status:</b>
                @if ($quiz->is_draft)
                    <span class="badge badge-warning">Rascunho</span>
                @else
                    <span class="badge badge-success">Ativo</span>
                @endif
                @can('actionsQuiz', $quiz)
                    <span class="pointer" wire:click="changeStatus">
                        <i class="ml-1 fas fa-exchange-alt"></i>
                    </span>
                @endcan
            </p>
            @error('is_draft')
                <p class="error">{{ $message }}</p>
            @enderror
            @if ($quiz->questions->count() > 0 && !$quiz->is_draft && $quiz->type == "Revisão")
                <a href="{{ route('quiz.revision', $quiz) }}" class="btn btn-primary">Responder agora!</a>
            @endif
            @if(isPresent(auth()->user()) > 0 && is_null(responseQuiz(auth()->user(), $quiz)))
                @if ($quiz->questions->count() > 0 && !$quiz->is_draft && $quiz->type == "Avaliação")
                    <a href="{{ route('quiz.revision', $quiz) }}" class="btn btn-primary">Responder prova!</a>
                @endif
            @endif


        </div>
    </div>
    @can('actionsQuiz', $quiz)
        <section class="mb-2 d-flex justify-content-between">
            <h2>Questões</h2>
            <a href="{{ route('question.create', $quiz) }}" class="btn btn-primary"><i class="fas fa-plus"></i> </a>
        </section>
        @forelse ($quiz->questions as $key => $question)
            <div class="card">
                <div class="card-header d-flex justify-content-between align-content-center">
                    <h4><a href="{{ route('question.show', ['quiz' => $quiz, 'question' => $question->id]) }}">Questão
                            {{ $key + 1 }} </a></h4>

                </div>
            </div>
        @empty
            <p>Não existem questões cadastradas.</p>
        @endforelse
    @endcan
</div>
