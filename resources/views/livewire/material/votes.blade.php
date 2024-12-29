<div class="card">
    <style>
        .emoji {
            width: 28px;
            height: 28px;
            cursor: pointer;
        }

        .emoji:hover {

            transform: scale(1.5);
        }

        #meu-svg {
            filter: grayscale(100%);
        }

        #meu-svg:hover {
            filter: none;
        }
    </style>
    <div class="card-header">
        <p class="card-title text-center">Avalie esse material</p>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-around">
            <div>
                <img @if (is_null($vote) || !$vote->muito_ruim) id="meu-svg" @endif class="emoji"
                    src="{{ asset('img/emojis/muito-ruim.svg') }}" alt="muito ruim" wire:click='muitoRuim'>
                <span>{{ $votes ? $votes->muitoRuim($material->id) : 0 }}</span>
            </div>
            <div>
                <img @if (is_null($vote) || !$vote->ruim) id="meu-svg" @endif class="emoji"
                    src="{{ asset('img/emojis/ruim.svg') }}" alt="ruim" wire:click='ruim'>
                <span>{{ $votes ? $votes->ruim($material->id) : 0 }}</span>

            </div>
            <div>
                <img @if (is_null($vote) || !$vote->razoavel) id="meu-svg" @endif class="emoji"
                    src="{{ asset('img/emojis/razoavel.svg') }}" alt="razoavel" wire:click='razoavel'>
                <span>{{ $votes ? $votes->razoavel($material->id) : 0 }}</span>
            </div>
            <div>
                <img @if (is_null($vote) || !$vote->muito_bom) id="meu-svg" @endif class="emoji"
                    src="{{ asset('img/emojis/muito-bom.svg') }}" alt="muito bom" wire:click='muitoBom'>
                <span>{{ $votes ? $votes->muitoBom($material->id) : 0 }}</span>
            </div>

            <div>
                <img @if (is_null($vote) || !$vote->excelente) id="meu-svg" @endif class="emoji"
                    src="{{ asset('img/emojis/excelente.svg') }}" alt="excelente" wire:click='excelente'>
                <span>{{ $votes ? $votes->excelente($material->id) : 0 }}</span>
            </div>


        </div>

    </div>
    <script>
        var svgElement = document.getElementById('meu-svg');
        svgElement.addEventListener('mouseover', function() {
            svgElement.style.filter = 'none';
        });

        svgElement.addEventListener('mouseout', function() {
            svgElement.style.filter = 'grayscale(100%)';
        });
    </script>
</div>
