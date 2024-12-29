<div>
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            @section('cabecalho')
                {{ $quiz->title }}
            @endsection

            <h2>Você acertou {{ $score }} de {{ $quiz->questions->count() }}</h2>

            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('principal') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item "><a href="{{ route('quiz.index') }}">Quizzes</a>
                        </li>
                        <li class="breadcrumb-item active"><a
                                href="{{ route('quiz.show', $quiz) }}">{{ $quiz->title }}</a>
                        </li>

                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="d-flex justify-content-between align-items-center mb-2">
        <h2>Questões</h2>

    </section>
    @forelse ($quiz->questions as $key => $question)
        <div class="card">
            <div class="card-body">
                <h3>Questão {{ $key + 1 }}</h3>
                {!! $question->body !!}
                <p><strong>Alternativas:</strong></p>
                @forelse ($question->items as $key => $item)
                    <div class="d-flex">
                        <strong class="mr-1">{{ alternatives($key) }}</strong> {!! $item->body !!}
                        @if ($item->is_correct)
                            <i class="fas fa-check text-success ml-2"></i>
                        @endif

                        @if ($this->wrongAnswer($question->id, $item->id))
                            <i class="fas fa-times text-danger ml-2"></i>
                        @endif
                    </div>
                @empty
                    <p>Não existem itens cadastradas.</p>
                @endforelse
            </div>
        </div>
    @empty
        <p>Não existem questões cadastradas.</p>
    @endforelse
</div>
