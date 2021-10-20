 <div class="row">
   <div class="col-md-3"></div>
   <div class="col-md-6">
      <div class="form-group">
        <label>Nom *</label>
        <input class="form-control" name="Nom" value="{{ old('Nom') ?: $Utilisateur->Nom }}"/>
        {!! $errors->first('Nom', '<span class="error">:message</span>') !!}
      </div>

      <div class="form-group">
        <label>Prenom *</label>
        <input class="form-control" name="Prenom" value="{{ old('Prenom') ?: $Utilisateur->Prenom}}" />
        {!! $errors->first('Prenom', '<span class="error">:message</span>') !!}
      </div>

      <div class="form-group">
        <label>Email *</label>
        <input type="Email"  class="form-control" name="Email" value="{{ old('Email') ?: $Utilisateur->Email }}" />
        {!! $errors->first('Email', '<span class="error">:message</span>') !!}
      </div>

      <div class="form-group">
        <label>Profil *</label>
        <select class="form-control select2" name="Profil">
            <option value="{{ $Utilisateur->Profil }}"> {{$Utilisateur->Profil}}</option>
            @foreach($roles as $role)
            <option value="{{$role->name}}">{{$role->name}}</option>
            @endforeach
        </select>
        {!! $errors->first('Profil', '<span class="error">:message</span>') !!}
      </div>

      <label></label><br>
      <button type="submit" class="btn btn-primary">{{$ButtonSubmitTexe}}</button>
    </div>
 </div>
 
 
                                        

                                        
                                      
                                      
                                      
                                       
                                      

                                        
                                     