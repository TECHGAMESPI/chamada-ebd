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
                        <li class="breadcrumb-item active"><a href="#">{{ $quiz->title }}</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    @error('countQuestions')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    @foreach ($questions as $i => $question)
        <div class="card" wire:key="{{ $question->id }}">
            <div class="card-header">
                <div class="d-sm-flex justify-content-between">
                    <h3>Questão {{ $questions->toArray()['current_page'] }}</h3>
                    @if ($questions->toArray()['last_page'] == $questions->toArray()['current_page'])
                        @if ($this->countQuestions())
                            @if($quiz->type == "Avaliação")
                                <a href="{{ route('quiz.response.evaluation', $quiz) }}" class="btn btn-primary">Finalizar</a>
                            @else
                                <a href="{{ route('quiz.response', $quiz) }}" class="btn btn-primary">Resultado</a>
                            @endif

                        @else
                            <p class="error">Existem questões a serem respondidas</p>
                        @endif
                    @endif
                </div>
                {!! $question->body !!}
            </div>
            <div class="card-body">
                <p><strong>Alternativas:</strong></p>
                @forelse ($question->items as $key => $item)
                    <div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="item" id="item{{ $key }}"
                                wire:click="answer({{ $question->id }},{{ $item->id }})"
                                @if ($this->answered($question->id, $item->id)) checked @endif>
                            <label class="form-check-label d-flex" for="item{{ $key }}">
                                <strong class="mr-1">{{ alternatives($key) }}</strong> {!! $item->body !!}
                            </label>
                        </div>
                    </div>
                @empty
                    <p>Não existem itens cadastradas.</p>
                @endforelse
            </div>
        </div>
    @endforeach
    <div class="d-sm-none d-flex justify-content-center">
        {{ $questions->links('vendor.livewire.simple-bootstrap') }}
    </div>
    <div class="d-none d-sm-block">
        <div class="d-flex justify-content-center">
            {{ $questions->links() }}
        </div>
    </div>

</div>
