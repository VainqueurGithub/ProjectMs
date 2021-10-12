 <div class="form-group">
                <label>Affiliers *</label>
                   
                    <select class="form-control select2" name="Affilier">
                         <option value="{{$Affilier->id}}">{{$Affilier->Code}} / {{$Affilier->Nom}} {{$Affilier->Prenom}}</option>
                         @foreach($Affiliers as $Affilier)
                           <option value="{{$Affilier->id}}">{{$Affilier->Code}} / {{$Affilier->Nom}} {{$Affilier->Prenom}}</option>
                         @endforeach
                    </select>
                    {!! $errors->first('Affilier', '<span class="error">:message</span>') !!}
           </div>

        <div class="form-group">
         <label>Mois *</label>
           <select class="form-control select2" name="Mois">
            @if($Cotisation->Mois==1)
               <option value="{{$Cotisation->Mois}}">Janvier</option>
            @elseif($Cotisation->Mois==2)
               <option value="{{$Cotisation->Mois}}">Février</option>
            @elseif($Cotisation->Mois==3)
               <option value="{{$Cotisation->Mois}}">Mars</option>
            @elseif($Cotisation->Mois==4)
               <option value="{{$Cotisation->Mois}}">Avril</option>
            @elseif($Cotisation->Mois==5)
               <option value="{{$Cotisation->Mois}}">Mai</option>
            @elseif($Cotisation->Mois==6)
               <option value="{{$Cotisation->Mois}}">Juin</option>
            @elseif($Cotisation->Mois==7)
               <option value="{{$Cotisation->Mois}}">Juillet</option>
            @elseif($Cotisation->Mois==8)
               <option value="{{$Cotisation->Mois}}">Aout</option>
            @elseif($Cotisation->Mois==9)
               <option value="{{$Cotisation->Mois}}">Septembre</option>
            @elseif($Cotisation->Mois==10)
               <option value="{{$Cotisation->Mois}}">Octobre</option>
            @elseif($Cotisation->Mois==11)
               <option value="{{$Cotisation->Mois}}">Novembre</option>
            @elseif($Cotisation->Mois==12)
               <option value="{{$Cotisation->Mois}}">Décembre</option>
            @endif
                <option value="1">Janvier</option>
                <option value="2">Février</option>
                <option value="3">Mars</option>
                <option value="4">Avril</option>
                <option value="5">Mai</option>
                <option value="6">Juin</option>
                <option value="7">Juillet</option>
                <option value="8">Aout</option>
                <option value="9">Septembre</option>
                <option value="10">Octobre</option>
                <option value="11">Novembre</option>
                <option value="12">Décembre</option>
           </select>
          {!! $errors->first('Mois', '<span class="error">:message</span>') !!}
        </div>

        <div class="form-group">
         <label>Annee *</label>
           <input type="number" min="2000" class="form-control" name="Annee" value="{{ $Cotisation->Annee }}" />
          {!! $errors->first('Annee', '<span class="error">:message</span>') !!}
        </div>

        <div class="form-group">
          <label>Montant *</label>
           <input type="number" min="1" class="form-control" name="Montant" value="{{ old('Montant') ?: $Cotisation->Montant }}" />
           {!! $errors->first('Montant', '<span class="error">:message</span>') !!}
        </div>

         <div class="form-group">
         <label>Date de payement *</label>
           <input type="date" class="form-control" name="Datepayement" value="{{ old('Datepayement')  ?: $Cotisation->Datepayement }}}}" />
          {!! $errors->first('Datepayement', '<span class="error">:message</span>') !!}
        </div>

                                        
              <label></label><br>
              <button type="submit" class="btn btn-primary">{{$ButtonSubmitTexe}}</button>