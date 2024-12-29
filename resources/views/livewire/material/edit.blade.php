<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            @section('cabecalho')
                Editar material
            @endsection
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('principal') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('material.index') }}">Materiais</a>
                        </li>
                        <li class="breadcrumb-item active"> <a href="#">Editar material</a>
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
                    <h4 class="card-title" id="basic-layout-form-center">{{ $material->titulo }}</h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <form class="form" wire:submit.prevent='update'>
                            @include('livewire.material.includes.form')

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
