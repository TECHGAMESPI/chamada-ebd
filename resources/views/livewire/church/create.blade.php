<div>
    @section('cabecalho')
        Nova Igreja
    @endsection
    <form wire:submit.prevent='store'>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Nome</label>
                    <input type="text" name="name" id="name" wire:model='name' class="form-control">
                </div>
                @error('name')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="minister">Pastor</label>
                    <input type="text" id="minister" wire:model='minister' class="form-control">
                </div>
                @error('minister')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-md">
                <div class="form-group">
                    <label for="address">Endereço</label>
                    <input type="text" name="address" id="address" wire:model='address' class="form-control">
                </div>
                @error('address')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="churchCategory">Categoria</label>
                    <select class="form-control" wire:model="churchCategory" aria-label="Default select example">
                        <option selected value="">Selecione</option>
                        <option selected value="Congregação">Congregação</option>
                        <option selected value="Igreja">Igreja</option>
                        <option selected value="Ponto de pregação">Ponto de pregação</option>

                    </select>
                    @error('churchCategory')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="day">Dia de Estudo</label>
                    <select class="form-control" wire:model="day">
                        <option selected value="">Selecione</option>
                        <option selected value="Domingo">Domingo</option>
                        <option selected value="Segunda-feira">Segunda-feira</option>
                        <option selected value="Terça-feira">Terça-feira</option>
                        <option selected value="Quarta-feira">Quarta-feira</option>
                        <option selected value="Quinta-feira">Quinta-feira</option>
                        <option selected value="Sexta-feira">Sexta-feira</option>
                        <option selected value="Sábado">Sábado</option>
                    </select>
                    @error('day')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="hour">Horário das aulas</label>
                    <input type="text" id="hour" wire:model='hour' class="form-control">
                </div>
                @error('name')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button type="submit" class="btn btn-primary mt-3">
                    Cadastrar
                </button>
            </div>
        </div>
    </form>
</div>
