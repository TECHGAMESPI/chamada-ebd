<div>
    <form wire:submit.prevent='store'>
        <div class="form-group">
            <label for="comment" class="h4">Comentários</label>
            <div class="d-flex">
                <div class="m-2">
                    <span class="avatar avatar-online"><img src="{{ asset(auth()->user()->path_photo) }}" alt="avatar"
                            width="35" height="35"><i></i>
                    </span>
                </div>
                <textarea id="comment" wire:model='text' rows="3" class="form-control border-primary" name="comentário ..."
                    placeholder="Comentário"></textarea>
            </div>
        </div>
        @error('text')
            <p class="error">{{ $message }}</p>
        @enderror
        <div class="mb-3 text-right">
            <button type="submit" class="btn btn-primary">
                <i class="la la-check-square-o"></i> Comentar
            </button>

        </div>

    </form>

</div>
