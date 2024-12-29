<div>
    <style>
        .pointer {
            cursor: pointer;
        }
    </style>
    <div class="content-header row">
        <div class="mb-2 content-header-left col-md-6 col-12 breadcrumb-new">
            @section('cabecalho')
                Agendamentos - {{ $quiz->title }}
            @endsection

            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('principal') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item "><a href="{{ route('quiz.index') }}">Quizzes</a>
                        </li>
                        <li class="breadcrumb-item active"><a href="{{route('quiz.show', $quiz)}}">{{ $quiz->title }}</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h3>Detalhes do Quiz</h3>
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
            </p>

        </div>
    </div>
    @can('actionsQuiz', $quiz)
        <section class="mb-2 d-flex justify-content-between">
            <h2>Agendamento(s)</h2>
            @if(!$quiz->is_draft)
                <a href="{{ route('quiz.scheduling.create', $quiz) }}" class="btn btn-primary"><i class="fas fa-plus"></i> </a>
            @endif

        </section>
        @forelse ($quiz->schedulings as $key => $scheduling)
            <div class="card">
                <div class="card-header d-flex justify-content-between align-content-center">
                    <div>
                        <p>Agendamento - {{$scheduling->quiz->title}} - {{$scheduling->turma->nome_turma}}</p>
                        <p><strong>Hora Inicial:</strong> {{date('d/m/Y H:i', strtotime($scheduling->start_date))}}</p>
                        <p><strong>Hora Final:</strong> {{date('d/m/Y H:i', strtotime($scheduling->end_date))}}</p>
                    </div>
                    <div>
                        <a href="" class="btn btn-primary"><i class="fas fa-edit"></i> </a>
                        <button class="btn btn-danger" onclick="return confirm('Você tem certeza?') || event.stopImmediatePropagation()" wire:click="delete({{ $scheduling->id }})"><i class="fas fa-trash"></i> </button>
                    </div>
                </div>
            </div>
        @empty
            <p>Não existem agendamentos cadastrados.</p>
        @endforelse
    @endcan
</div>
