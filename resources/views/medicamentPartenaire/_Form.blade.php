
        <div class="form-group">
         <label>Code Medicament ou Service </label>
           <input type="text" class="form-control" name="Code" placeholder="Indiquez le Code Medicament ou Service" value="{{ old('Code')?: $medicament->code }}" />
          {!! $errors->first('Code', '<span class="error">:message</span>') !!}
        </div>

        <div class="form-group">
         <label>Désignation *</label>
           <input type="text" class="form-control" name="Designation" placeholder="Indiquez la Designation Medicament ou Service" value="{{ old('Designation')?: $medicament->designation }}" />
          {!! $errors->first('Designation', '<span class="error">:message</span>') !!}
        </div>

        <div class="form-group" style="display: none;">
         <label>Libellé *</label>
           <input type="text" class="form-control" name="Libelle"  value="{{ $id }}" />
          {!! $errors->first('Libelle', '<span class="error">:message</span>') !!}
        </div>

        <div class="form-group">
         <label>Prix *</label>
           <input type="text" class="form-control" name="Prix" placeholder="Indiquez le Prix Medicament ou Service" value="{{ old('Prix')?: $medicament->prix }}" />
          {!! $errors->first('Prix', '<span class="error">:message</span>') !!}
        </div>

        <div class="form-group">
          <label>Partenaire *</label>
           <select class="form-control" name="Partenaire">
               <option value="{{ $Partenaire->id }}"> {{ $Partenaire->Code }} / {{ $Partenaire->Partenaire }}</option>
               @foreach($Partenaires as $Partenaire)
                 <option value="{{ $Partenaire->id }}">{{$Partenaire->Code}} / {{$Partenaire->Partenaire}}</option>
               @endforeach
           </select>
           {!! $errors->first('Partenaire', '<span class="error">:message</span>') !!}
        </div>
       
          <label></label><br>
              <button type="submit" class="btn btn-primary">{{ $ButtonSubmitTexe }}</button>
               <button type="reset" class="btn btn-default">Annuler</button>
                                        
             
         <!-- /. PAGE WRAPPER  -->

<script type="text/javascript">
    function research(va){
     var affilie= $(va).val();
     // var id_categorie= $("#Categorie").val();
      $.get('{{ route('researchAffilierCotisation') }}',
          {affilie:affilie},
          function(data){
            $("#prodReas").css('display','block');
            $('#Produit').html(data);
          });
   }
</script>