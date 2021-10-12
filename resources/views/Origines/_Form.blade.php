 <div class="form-group">
         <label>Origine *</label>
           <input class="form-control" name="Origine" value="{{ old('Origine') ?: $Origine->Origine }}"/> {!! $errors->first('Origine', '<span class="error">:message</span>') !!}
        </div>
                                        
        <label></label><br>
        <button type="submit" class="btn btn-primary">{{ $ButtonSubmitTexe }}</button>