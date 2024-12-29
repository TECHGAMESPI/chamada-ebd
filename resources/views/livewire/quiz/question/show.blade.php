<div>
    <div class="row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            @section('cabecalho')
                Questão do Quiz {{ $quiz->title }}
            @endsection
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('principal') }} ">Home</a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('quiz.index') }}">Quizzes</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('quiz.show', $quiz) }}">{{ $quiz->title }}</a>
                        </li>
                        <li class="breadcrumb-item active"> <a href="#">Questão</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title" id="basic-layout-form-center">Enunciado questão</h3>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                            aria-expanded="false">
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item"
                                href="{{ route('question.edit', ['question' => $question, 'quiz' => $quiz]) }}">Editar</a>

                            <form action="{{ route('question.delete', $question) }}" method="POST"
                                onsubmit="return confirm('Você tem certeza? Essa ação não poderá ser desfeita')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item">Excluir</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        {!! $question->body !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="d-flex justify-content-between mb-2">
        <h2>Itens</h2> <a href="{{ route('item.create', ['question' => $question, 'quiz' => $quiz]) }}"
            class="btn btn-primary"><i class="fas fa-plus"></i> </a>
    </section>

    @forelse ($question->items as $item)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            {!! $item->body !!}
                            @if ($item->is_correct)
                                <span class="badge badge-success">Correto</span>
                            @endif
                        </div>
                        <div class="btn-group">
                            <button class="btn" type="button" data-toggle="dropdown" aria-expanded="false">
                                <i class="la la-ellipsis-v tamanho-pontos"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item"
                                        href="{{ route('item.edit', ['item' => $item, 'question' => $item->question_id, 'quiz' => $quiz]) }}">Editar</a>
                                </li>
                                <li>
                                    <form
                                        action="{{ route('item.delete', ['item' => $item, 'question' => $item->question_id, 'quiz' => $quiz]) }}"
                                        method="POST"
                                        onsubmit="return confirm('Você tem certeza? Essa ação não poderá ser desfeita')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item">Excluir</button>
                                    </form>

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <p>Ainda não existem itens cadastrados</p>
    @endforelse

</div>
