<div>
    <div class="row">
        <div class="mb-2 content-header-left col-md-6 col-12 breadcrumb-new">
            @section('cabecalho')
                Novo Agendamento
            @endsection
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('principal') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('quiz.index') }}">Quizzes</a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('quiz.show', $quiz) }}">{{ $quiz->title }}</a>
                        </li>
                        <li class="breadcrumb-item active"> <a href="#">Novo Agendamento</a>
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
                    <h4 class="card-title" id="basic-layout-form-center">Criar novo agendamento</h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <form class="form" wire:submit.prevent='store'>

                            <div class="form-group">
                                <label for="projectinput5">Turmas</label>
                                <select id="projectinput5" name="class" wire:model="class" class="form-control">
                                    <option value="" selected>Selecione ...</option>
                                    <option value="allClasses">Todas as turmas</option>
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->nome_turma }}</option>
                                    @endforeach
                                </select>
                                @error('class')
                                    <p class="error">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="start_date">Data e Horário Inicial</label>
                                <input type="datetime-local" id="start_date" class="form-control"
                                    wire:model='start_date' name="">
                                @error('start_date')
                                    <p class="error">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="end_date">Data e Horário Final</label>
                                <input type="datetime-local" id="end_date" class="form-control" wire:model='end_date'
                                    name="">
                                @error('end_date')
                                    <p class="error">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="form-actions">

                                <button type="submit" class="btn btn-primary">
                                    <i class="la la-check-square-o"></i> Salvar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
