 <div>
<!-- Modal -->
          <div class="modal fade" wire:init="openModal" id="MultiCompanyAlert" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="staticBackdropLabel">Multi-Company Asset Edit </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  You are about to edit multiple assets that do not all belong to the same company. <br>Are you sure you want to do this?
                </div>
                <div class="modal-footer">
                  <form wire:submit.prevent="submitcategory">
                    <input type="button"  wire:click="cancelEdit()"  class="btn btn-secondary" value="Go Back" data-dismiss="modal"></input>
                    <input type="button"  wire:click="continueEdit()" class="btn btn-primary" value="Continue" data-dismiss="modal"></input>
                  </form>
                </div>
              </div>
            </div>
          </div>
</div>
 @section('moar_scripts')
   @if($multiCompany)
     <script>
       $(document).ready(function () {
         window.livewire.emit('show');
       });

       $(document).ready(function () {
         window.livewire.on('show', () => {
          $('#MultiCompanyAlert').modal('show');
       })});
     </script>
   @endif
 @stop