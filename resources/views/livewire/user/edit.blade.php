<div>
    @section('cabecalho')
        Editar Usuário
    @endsection

    <div class="row breadcrumbs-top d-inline-block mb-2">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('principal') }}">Home</a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('usuarios') }}">Usuários</a>
                </li>
                <li class="breadcrumb-item active"><a href="#">Editar Usuário</a>
                </li>
            </ol>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent='update()'>
                <div class="row">
                    @if ($photo)
                        <div class="col-md-3">
                            <img src="{{ $photo->temporaryUrl() }}" width="200px" height="200px"
                                class="img-fluid img-thumbnail" style="max-width: 200px;">
                            <p><strong>Aquivo selecionado: </strong> {{ $photo->getClientOriginalName() }} </p>
                            @error('photo')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                    @else
                        <div class="col-md-3">
                            <img src="{{ asset($path_photo) }}" class="img-fluid img-thumbnail"
                                style="max-width: 200px;">
                            <div class="input-group mt-2">
                                <label for="uploadFoto" class="btn btn-outline-secondary">Alterar
                                    foto</label>
                                <input type="file" wire:model='photo' hidden class="form-control" id="uploadFoto"
                                    aria-label="Upload">

                            </div>
                        </div>
                    @endif

                    <div class="col-md">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <input type="text" name="name" id="name" value="" wire:model='name'
                                        class="form-control">
                                </div>
                                @error('name')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email">Usuário</label>
                                    <input type="email" name="email" id="email" value=""
                                        wire:model='email' class="form-control">
                                </div>
                                @error('email')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="perfil">Perfil</label>
                            <select class="form-control" wire:model="profile" aria-label="Default select example"
                                required>
                                <option selected value="">Selecione</option>

                                @foreach ($profiles as $perfil)
                                    <option value="{{ $perfil->id }}">
                                        {{ $perfil->perfil }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('profile')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="estado_civil">Estado Civil</label>
                            <select class="form-control" name="estado_civil" wire:model='maritalStatus'>
                                <option value="Solteiro(a)">Solteiro(a)</option>
                                <option value="Casado(a)">Casado(a)</option>
                                <option value="Viuvo(a)">Viuvo(a)</option>
                            </select>
                        </div>
                    </div>
                    @error('maritalStatus')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="data_nascimento">Data de Nascimento</label>
                            <input type="date" name="data_nascimento" id="data_nascimento" value=""
                                wire:model='date' class="form-control">
                        </div>
                        @error('date')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="telefone">Telefone (Watsapp)</label>
                            <input type="tel" name="telefone" id="telefone" class="form-control" value=""
                                wire:model='phone'>
                        </div>
                        @error('pHone')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="email-google">Email Google</label>
                            <input type="email" name="email" id="email-google" value=""
                                wire:model='googleEmail' class="form-control">
                        </div>
                        @error('googleEmail')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md d-flex justify-content-between ">
                        <button type="submit" class="btn btn-primary mt-3">
                            Atualizar
                        </button>
                        @if (Auth::user()->perfil_id == App\Models\Perfil::SUPERINTENDENTE ||
                                Auth::user()->perfil_id == App\Models\Perfil::ADMINISTRADOR)
                            <a href='#' type="submit" wire:click.prevent="resetPassword()"
                                class="btn btn-primary mt-3">
                                Resetar senha
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
