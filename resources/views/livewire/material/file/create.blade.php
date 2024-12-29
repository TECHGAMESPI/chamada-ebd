<div>
    <style>
        #file {
            display: none;
        }
    </style>
    <form action="POST" wire:submit.prevent='store'>
        <div class="form-body">

            <div class="form-group">
                <label for="title">Título do Arquivo</label>
                <input type="text" id="title" wire:model='title' class="form-control">
                @error('title')
                    <p class="error">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="form-group">
                <label for="file" class="btn btn-info">Selecione o Arquivo</label>
                <input type="file" id="file" wire:model='file' class="form-control">
                @error('file')
                    <p class="error">
                        {{ $message }}
                    </p>
                @enderror
                @if ($file)
                    <strong>Arquivo selecionado:</strong> {{ $file->getClientOriginalName() }}
                @endif
            </div>

        </div>
        <div class="form-footer">
            <button class="btn btn-primary">Salvar</button>
        </div>
    </form>
</div>
