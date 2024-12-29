<div>
    <div class="row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            @section('cabecalho')
                Novo Quiz
            @endsection
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('principal') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('quiz.index') }}">Quizzes</a>
                        </li>
                        <li class="breadcrumb-item active"> <a href="#">Novo Quiz</a>
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
                    <h4 class="card-title" id="basic-layout-form-center">Criar novo quiz</h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <form class="form" wire:submit.prevent='store'>
                            <div class="form-group ">
                                <label for="descricao">Descrição</label>
                                <input type="text" id="descricao" wire:model.live='title' class="form-control"
                                    placeholder="" name="">
                                @error('title')
                                    <p class="error">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="projectinput5">Tipo do Quiz</label>
                                <select id="projectinput5" name="type" wire:model.live="type"
                                    class="form-control">
                                    <option value="" selected>Selecione ...</option>
                                    <option value="Avaliação">Avaliação</option>
                                    <option value="Revisão">Revisão</option>
                                </select>
                                @error('type')
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
