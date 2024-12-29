<!-- Modal -->
<div class="modal fade text-left" id="link-externo" tabindex="-1" role="dialog" aria-labelledby="modalLinkExterno"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalLinkExterno">Link Externo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @livewire('material.link-externo.create', ['material' => $material])
            </div>
            <div class="modal-footer">
                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Fechar</button>

            </div>
        </div>
    </div>
</div>
