<div>
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
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
                        <li class="breadcrumb-item active"><a
                                href="{{ route('quiz.show', $quiz) }}">{{ $quiz->title }}</a>
                        </li>
                        <li class="breadcrumb-item active"><a href="{{ route('quiz.show.all', $quiz) }}">Todas as
                                Questões</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="d-flex justify-content-between align-items-center mb-2">
        <h2>Questões</h2>
        <a target="_blank" href="{{ route('quiz.pdf', $quiz) }}" class="btn btn-primary"><i
                class="far fa-file-pdf"></i></a>
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
