<div class="container-fluid">
  <div class="tab">
               <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Indentité de L'Adherant</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                    <label>Code *</label>
                    <input class="form-control" placeholder="Code de L'Affilier" name="Code" value="{{ old('Code') ?: $Affilier->Code }}"/>
                    {!! $errors->first('Code', '<span class="error">:message</span>') !!}
                </div>
                
               <div class="form-group">
                  <label>Nom *</label>
                  <input class="form-control" placeholder="Nom de L'Affilier" name="Nom" value="{{ old('Nom') ?: $Affilier->Nom }}"/>

                  {!! $errors->first('Nom', '<span class="error">:message</span>') !!}
                </div>

                <div class="form-group">
                    <label>Prenom</label>
                    <input class="form-control" id="Prenom" placeholder="Prenom de L'Affilier" name="Prenom" value="{{ old('Prenom') ?: $Affilier->Prenom }}"/>

                    {!! $errors->first('Prenom', '<span class="error">:message</span>') !!}
                </div>

                <div class="form-group">
                  <label>Année Naissance *</label>
                    <input type="number" min="1" class="form-control" name="DateNaiss" value="{{old('DateNaiss') ?: $Affilier->DateNaiss }}" />

                    {!! $errors->first('DateNaiss', '<span class="error">:message</span>') !!}
                </div>

                <div class="form-group">
                  <label>Profession *</label>
                   <input type="text" class="form-control float-right" name="Profession" value="{{old('Profession') ?: $Affilier->profession }}">
                    {!! $errors->first('Profession', '<span class="error">:message</span>') !!}
                </div>
              </div>
              <!-- /.col -->
              <div class="col-md-6">
               <div class="form-group">
                  <label>Date Entrée *</label>
                  <input type="date" class="form-control" name="DateEntree" value="{{old('DateEntree') ?: $Affilier->DateEntree }}"/>
                  {!! $errors->first('DateEntree', '<span class="error">:message</span>') !!}
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Origine *</label>
                  <select class="form-control select2" name="Origine">
                      <option value="{{ $Ori->id}}"> {{ $Ori->Origine}}</option>
                      @foreach($Origines as $O)
                      <option value="{{ $O->id}}">{{$O->Origine}}</option>
                      @endforeach
                  </select>
                  {!! $errors->first('Origine', '<span class="error">:message</span>') !!}
                </div>

                <div class="form-group">
                  <label>N° Piece *</label>
                    <input class="form-control" placeholder=" N° Piece Indentite" name="Piece" value="{{ old('Piece') ?: $Affilier->PieceIndentite }}"/>

                    {!! $errors->first('Piece', '<span class="error">:message</span>') !!}
                </div>

                 <div class="form-group">
                  <label>Genre *</label>
                   <select class="form-control select2" name="gender">
                     <option value="Homme">Homme</option>
                     <option value="Femme">Femme</option>
                   </select>
                    {!! $errors->first('gender', '<span class="error">:message</span>') !!}
                </div>

                 <div class="form-group">
                  <label>Periode d'observation *</label>

                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                    </div>
                    <input type="text" name="dateObservation" class="form-control float-right" id="reservation">
                  </div>
                  {!! $errors->first('dateObservation', '<span class="error">:message</span>') !!}
                </div>
              </div>
              <!-- /.col -->
            </div>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
           Tous les champs marqués (*) sont obligatoires
          </div>
        </div>
  </div>














            
            <div class="tab">
                      <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Contacts de L'Adherant</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
               <div class="form-group">
                  <label>Mobile</label>
                  <input class="form-control" name="Mobile" id="Mobile" placeholder="Mobile" value="{{ old('Mobile') ?: $Affilier->Mobile }}"/>

                  {!! $errors->first('Mobile', '<span class="error">:message</span>') !!}
                </div>
                
               <div class="form-group">
                  <label>Telephone</label>
                  <input class="form-control" placeholder="Telephone" id="Telephone" name="Telephone" value="{{ old('Telephone') ?: $Affilier->Telephone }}"/>

                  {!! $errors->first('Telephone', '<span class="error">:message</span>') !!}
              </div>

              <div class="form-group">
                  <label>Email</label>
                  <input class="form-control" placeholder="Adresse mail" id="Email" name="Email" value="{{ old('Email') ?: $Affilier->Email }}"/>

                  {!! $errors->first('Email', '<span class="error">:message</span>') !!}
              </div>
            </div>
              <!-- /.col -->
              <div class="col-md-6">
              <div class="form-group">
                <label>Adresse</label>
                <input class="form-control" placeholder="Adresse" id="Adresse" name="Adresse" value="{{ old('Adresse') ?: $Affilier->Adresse }}"/>

                {!! $errors->first('Adresse', '<span class="error">:message</span>') !!}
              </div>

               <div class="form-group">
                  <label>Fax</label>
                  <input class="form-control" placeholder="Fax" id="Fax" name="Fax" value="{{ old('Fax') ?: $Affilier->Fax }}"/>

                  {!! $errors->first('Fax', '<span class="error">:message</span>') !!}
              </div>

              </div>
            </div>
          </div>
         <div class="card-footer">
           Tous les champs marqués (*) sont obligatoires
          </div>
        </div>
      </div>


            
            <div class="tab">
                    <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Limités et Couvertures des Prestations</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
               <div class="form-group">
                <label>Limite Laboratoire</label>
                <input type="text" class="form-control" name="Laboratoire" value="{{old('Laboratoire') ?: $Affilier->labo }}"/>

                {!! $errors->first('Laboratoire', '<span class="error">:message</span>') !!}
                </div>

                <div class="form-group">
                  <label>Limite Kinésitherapie</label>
                  <input type="text" class="form-control" name="Kinesitherapie" value="{{old('Kinesitherapie') ?: $Affilier->kinesie }}"/>

                  {!! $errors->first('Kinésitherapie', '<span class="error">:message</span>') !!}
                </div>

                <div class="form-group">
                  <label>Limite Reanimation</label>
                  <input type="text" class="form-control" name="Reanimation" value="{{old('Reanimation') ?:$Affilier->reanimation }}"/>

                  {!! $errors->first('Reanimation', '<span class="error">:message</span>') !!}
                </div>

                <div class="form-group">
                  <label>Limite Imagerie Medicale</label>
                  <input type="text" class="form-control" name="Imagerie" value="{{old('Imagerie') ?: $Affilier->imagerie }}"/>

                  {!! $errors->first('Imagerie', '<span class="error">:message</span>') !!}
                </div>

                <div class="form-group">
                  <label>Couverture Maternité(%)</label>
                  <input type="number" class="form-control" max="100" min="0" placeholder="Pourcentage Maternité" name="MaterniteP" value="{{ old('MaterniteP') ?: $Affilier->ElseUniteMaternite }}"/>

                  {!! $errors->first('MaterniteP', '<span class="error">:message</span>') !!}
                </div>

                <div class="form-group">
                    <label>Limite Pharmacie</label>
                    <input type="number" class="form-control" min="0" placeholder="Pharmacie" name="Pharmacie" value="{{ old('Pharmacie') ?: $Affilier->Pharmacie }}"/>

                    {!! $errors->first('Pharmacie', '<span class="error">:message</span>') !!}
                </div>

                <div class="form-group">
                  <label>Limites dents</label>
                  <input type="number" class="form-control" min="0" placeholder="Limites dents" name="dents" value="{{ old('dents') ?: $Affilier->dents }}" />

                  {!! $errors->first('dents', '<span class="error">:message</span>') !!}
                </div>    

                <div class="form-group">
                  <label>Cotisation *</label>
                  <input type="number" class="form-control" placeholder="Cotisation" name="Cotisation" value="{{ old('Cotisation') ?: $Affilier->CotisationM }}" />

                  {!! $errors->first('Cotisation', '<span class="error">:message</span>') !!}
                </div> 
            </div>
              <!-- /.col -->
              <div class="col-md-6">
               <div class="form-group">
                  <label>Limite Soins Ambulatoire (%)</label>
                  <input type="number" class="form-control" placeholder="Soins Ambulatoire" min="0" max="100" name="SA" value="{{ old('SA') ?: $Affilier->SoinsAmbilatoire }}"/>

                  {!! $errors->first('SA', '<span class="error">:message</span>') !!}
                </div>
                                        
                <div class="form-group">
                    <label>Hop.Plaf.Chambre (%)</label>
                    <input type="number" class="form-control" min="0" max="100" placeholder="Hopital Plafond Chambre" name="HPC" value="{{ old('HPC') ?: $Affilier->PlafondChambre }}"/>

                    {!! $errors->first('HPC', '<span class="error">:message</span>') !!}
                </div>

                <div class="form-group">
                    <label>HPC/nuit</label>
                    <input class="form-control" type="number" min="0" placeholder="Hopital Plafond Chambre/Nuit" name="HPCN" value="{{ old('HPCN') ?: $Affilier->PCNuit }}"/>

                    {!! $errors->first('HPCN', '<span class="error">:message</span>') !!}
                </div>

                <div class="form-group">
                    <label>Limite Hosp.Generale</label>
                    <input type="text" class="form-control" min="0" placeholder="Hospitalisation" name="Hospitalisation" value="{{ old('Hospitalisation') ?: $Affilier->Hospitalisation }}"/>

                    {!! $errors->first('Hospitalisation', '<span class="error">:message</span>') !!}
                </div>

                <div class="form-group">
                    <label>Limite Maternité</label>
                    <input type="number" class="form-control" min="0" placeholder="Maternité" name="Maternite" value="{{ old('Maternite') ?: $Affilier->UniteMaternite }}"/>

                    {!! $errors->first('Maternite', '<span class="error">:message</span>') !!}
                </div>

                <div class="form-group">
                  <label>Limites Medicaments</label>
                  <input type="number" class="form-control" min="0" placeholder="Limites Medicaments" name="Medicament" value="{{ old('Medicament') ?: $Affilier->Medicament }}" />

                  {!! $errors->first('Medicament', '<span class="error">:message</span>') !!}
                </div>

                <div class="form-group">
                  <label>Limites Lunettes (Verre + Monture)</label>
                  <input type="number" class="form-control" min="0" placeholder="Limites Lunettes" name="Lunette" value="{{ old('Lunette') ?: $Affilier->Lunette }}" />

                  {!! $errors->first('Lunette', '<span class="error">:message</span>') !!}
                </div> 
               
                <div class="form-group">
                  <label>Droit Adhésion</label>
                  <input type="number" class="form-control" placeholder="Montant d'adhésion" name="DroitAdhesion" value="{{ old('DroitAdhesion') ?: $Affilier->droit_adhesion }}" />

                  {!! $errors->first('Lunette', '<span class="error">:message</span>') !!}
                </div> 
              </div>
            </div>
          </div>
          <div class="card-footer">
           Tous les champs marqués (*) sont obligatoires
          </div>
        </div>
      </div>
            
  
            <div style="overflow:auto;">
              <div style="float:right;">
                <button type="button" class="btn btn-default btn-sm" id="prevBtn" onclick="nextPrev(-1)">Retour</button>
                <button type="button" class="btn btn-default btn-sm" id="nextBtn" onclick="nextPrev(1)">Suivant</button>
              </div>
            </div>
            
            <!-- Circles which indicates the steps of the form: -->
            <div style="text-align:center;margin-top:-60px;">
              <span class="step">1</span>
              <span class="step">2</span>
              <span class="step">3</span>
            </div>
</div>            