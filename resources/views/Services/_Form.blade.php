<div class="form-group">
         <label>Service</label>
           <input class="form-control" name="Service" value="{{ old('Service') ?: $Service->service }}"" />
          {!! $errors->first('Service', '<span class="error">:message</span>') !!}
        </div>

        <div class="form-group">
         <label>Couverture</label>
         <select class="form-control select2" name="Couverture">
            <option value="{{$Service->Traitement}}">{{$Traitement}}</option>
             <option value="1">Soins Ambulatoire (Consultation uniquement)</option>
             <option value="2">Hospitalisation sans Maternité</option>
             <option value="3">Hospitalisation avec Maternité</option>
             <option value="4">Soins Ambulatoire Medicament</option>
             <option value="5">Soins Ambulatoire Lunette</option>
             <option value="6">Soins Ambulatoire Dents</option>
             <option value="7">Soins Ambulatoire Laboratoire</option>
             <option value="8">Soins Ambulatoire Kinesitherapie</option>
             <option value="9">Soins Ambulatoire Reanimation</option>
             <option value="10">Soins Ambulatoire Imagerie Medicale</option>
             
         </select>
          {!! $errors->first('Couverture', '<span class="error">:message</span>') !!}
        </div>
       <label></label><br>
        <button type="submit" class="btn btn-primary">{{ $ButtonSubmitTexe }}</button>  