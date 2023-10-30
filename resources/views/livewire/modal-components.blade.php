 <div>
   @if($this->multiCompany)<!-- Modal -->

          <div class="modal fade" wire:model="MultiCompanyAlert" id="MultiCompanyAlert" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="staticBackdropLabel">Multi-Company Asset Edit </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  You are about to edit multiple assets that do not all belong to the same company.
                </div>
                <div class="modal-footer">
                  <button type="button" wire:click.prevent="multiCompanyAcknowledge({{'cancel'}})"  class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <button type="button" wire:click.prevent="multiCompanyAcknowledge({{'accept'}})" class="btn btn-primary" data-dismiss="modal">Understood</button>
                </div>
              </div>
            </div>
          </div>
     @endif
</div>