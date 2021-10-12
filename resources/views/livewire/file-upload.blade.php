<form wire:submit.prevent="saveFile" enctype="multipart/form-data">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <label class="control-label">Uploader le Bilan Initial *</label>
                <input class="form-control form-white" type="file" name="fichier" wire:model="fichier" />
                    @error('fichier') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary waves-effect waves-light save-category">Enregistrer</button>
        </div>
    </div>
</form>


