<modal v-model="displayImportModal" effect="fade">
    <div slot="modal-header" class="modal-header">
        <h4 class="modal-title">Import File:</h4>
    </div>
    <div slot="modal-body" class="modal-body">
        <div class="dynamic-form-row">
            <div class="col-md-4 col-xs-12">
                <label for="import-type">Import Type:</label>
            </div>
            <div class="col-md-8 col-xs-12">
                <select2 :options="modal.importTypes" v-model="modal.importType">
                    <option disabled value="0"></option>
                </select2>
            </div>
        </div>
        <div class="dynamic-form-row">
            <div class="col-md-4 col-xs-12">
                <label for="import-update">Update Existing Values?:</label>
            </div>
            <div class="col-md-8 col-xs-12">
                <input type="checkbox" name="import-update" v-model="modal.update">
            </div>
        </div>
    </div>

    <div class="modal-footer" slot="modal-footer">
        <div class="alert alert-success col-md-5 col-md-offset-1" style="text-align:left" v-if="modal.statusText">@{{ this.modal.statusText }}</div>
        <button type="button" class="btn btn-default" @click="displayImportModal = false">Cancel</button>
        <button type="submit" class="btn btn-primary" @click="postSave">Process</button>
    </div>
</modal>