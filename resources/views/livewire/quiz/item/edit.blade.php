<div>
    <div class="row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            @section('cabecalho')
                Editar Item
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
                        <li class="breadcrumb-item">
                            <a
                                href="{{ route('question.show', ['question' => $question, 'quiz' => $quiz]) }}">Questão</a>
                        </li>
                        <li class="breadcrumb-item active"> <a href="#">Editar Item</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" id="basic-layout-form-center">Criar novo item</h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                </div>
                <div class="card-content collapse show">

                    <div class="card-body">
                        <form class="form"
                            action="{{ route('item.update', ['quiz' => $quiz, 'question' => $question, 'item' => $item]) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="is_correct">Alternativa correta?</label>
                                <select id="is_correct" wire:model="is_correct" name="is_correct" class="form-control">
                                    <option value="" selected="" disabled="">Selecione ...</option>
                                    <option value=1>Sim</option>
                                    <option value=0>Não</option>
                                </select>
                                @error('type')
                                    <p class="error">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <textarea rows="5" class="form-control" wire:model="body" name="body" id="mytextarea"></textarea>

                            @error('body')
                                <p class="error">
                                    {{ $message }}
                                </p>
                            @enderror

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">
                                    <i class="la la-check-square-o"></i> Atualizar
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
