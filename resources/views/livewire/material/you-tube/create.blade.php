<div>
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
                <label for="link">Url do vídeo</label>
                <input type="text" id="link" wire:model='link' class="form-control">
                @error('link')
                    <p class="error">
                        {{ $message }}
                    </p>
                @enderror
            </div>


        </div>
        <div class="form-footer">
            <button class="btn btn-primary">Salvar</button>
        </div>
    </form>
</div>
