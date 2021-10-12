
        <div class="form-group">
         <label>Libellé *</label>
           <input type="text" class="form-control" name="Libelle" placeholder="Indiquez le Libelle Medicament ou Service" value="{{ old('Libelle')?: $medicament->propriete }}" />
          {!! $errors->first('Libelle', '<span class="error">:message</span>') !!}
        </div>

         <div class="form-group">
         <label>Autres Propriété</label>
           <textarea class="form-control" name="Propriete">{{old('Propriete')?: $medicament->libelle}}</textarea>
          {!! $errors->first('Propriete', '<span class="error">:message</span>') !!}
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