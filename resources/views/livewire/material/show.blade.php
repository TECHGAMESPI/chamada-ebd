<div>
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">

            @section('cabecalho')
                {{ $material->titulo }}
            @endsection

            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('principal') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item "><a href="{{ route('material.index') }}">Materiais</a>
                        </li>
                        <li class="breadcrumb-item active"><a href="#">{{ $material->titulo }}</a>
                        </li>

                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Detalhes do material</h3>
            @can('action_material', $material)
                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-plus"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#arquivo">Arquivo</a>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#link-externo">Link </a>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#you-tube">YouTube</a>
                    </div>
                </div>
            @endcan
        </div>
        <div class="card-body">
            <p><b>Autor:</b> {{ $material->user->name }}</p>
            <p><b>Titulo:</b> {{ $material->titulo }}</p>
            <p><b>Descricao:</b> {{ $material->descricao }}</p>
            <p><b>Data de publicação:</b> {{ date('d/m/Y H:i:s', strtotime($material->publicar_em)) }}</p>
        </div>

    </div>
    <section>

        @foreach ($material->arquivos as $arquivo)
            <div class="card">
                <div class="card-header d-flex justify-content-between align-content-center">
                    <h4>{{ $arquivo->titulo }}</h4>
                    @can('action_material', $material)
                        <a href="#" class="btn btn-danger"
                            onclick="return confirm('Você tem certeza? Essa ação não poderá ser desfeita') ||  event.stopImmediatePropagation()"
                            wire:click.prevent="deleteFile({{ $arquivo->id }})">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    @endcan
                </div>
                <div class="card-body">
                    <strong>Arquivo:</strong> <a target="_blank"
                        href="{{ asset('storage/' . $arquivo->caminho_arquivo) }}">{{ $arquivo->titulo }}</a>

                </div>
            </div>
        @endforeach

        @foreach ($material->links_externos as $link_externo)
            <div class="card-header d-flex justify-content-between align-content-center">
                <h4>{{ $link_externo->titulo }}</h4>
                @can('action_material', $material)
                    <a href="#" class="btn btn-danger"
                        onclick="return confirm('Você tem certeza? Essa ação não poderá ser desfeita') ||  event.stopImmediatePropagation()"
                        wire:click.prevent="deleteLink({{ $link_externo->id }})">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                @endcan
            </div>
            <div class="card">
                <div class="card-body">
                    <strong>Link Externo:</strong> <a target="_blank"
                        href="{{ $link_externo->url }}">{{ $link_externo->titulo }}</a>

                </div>
            </div>
        @endforeach

        @foreach ($material->you_tubes as $you_tube)
            <div class="card">
                <div class="card-header d-flex justify-content-between align-content-center">
                    <h4>{{ $you_tube->titulo }}</h4>
                    @can('action_material', $material)
                        <a href="#" class="btn btn-danger"
                            onclick="return confirm('Você tem certeza? Essa ação não poderá ser desfeita') ||  event.stopImmediatePropagation()"
                            wire:click.prevent="deleteYouTube({{ $you_tube->id }})">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    @endcan
                </div>

                <div class="card-body d-flex flex-column">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item"
                            src="https://www.youtube.com/embed/{{ $you_tube->code_video ?? null }}"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen></iframe>
                    </div>

                    <div class="mt-3">
                        <strong>Assistir fora do MinhaEBD:</strong> <a target="_blank"
                            href="{{ $you_tube->url }}">{{ $you_tube->titulo }}</a>
                    </div>
                </div>
            </div>
        @endforeach


    </section>
    <div class="row">
        <div class="col-12 col-md-8">
            @livewire('comment.create', ['material' => $material])
            <div class="card">
                <div class="card-body">
                    @forelse ($material->comentarios as $comentario)
                        <p>
                            {{ $comentario->user->name }} disse ...
                        </p>
                        <p class="lead">
                            {{ $comentario->text }}
                        </p>
                        <small>{{ $comentario->created_at->diffForHumans() }}</small>
                        <hr>
                    @empty
                        <p>Ainda não existem comentários ...</p>
                    @endforelse

                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            @livewire('material.votes', ['material' => $material])
        </div>
    </div>

    @include('livewire.material.includes.modals.arquivo')
    @include('livewire.material.includes.modals.you-tube')
    @include('livewire.material.includes.modals.link-externo')
</div>
