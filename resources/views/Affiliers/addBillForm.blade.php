@extends('layout.base', ['title' => 'Assurance - Nouvelle Facture'])
@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1> Enregistrement des Prestations (Facture)</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Advanced Form</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <form role="form" method="POST" action="{{ route('Factures.store')}}">
    {{ csrf_field() }}
    
    <div class="tab">
     <div class="container-fluid">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Information Génerale de la Prestation</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                  <div class="form-group" style="display: none;">
                      <label></label>
                      <input class="form-control" name="Affilier" value="{{ $Aff }}"/>
                  </div>
                                         
                  <div class="form-group">
                      <label>Béficiaire *</label>
                      <select class="form-control select2" name="AyantDroits" id="AyantDroits">
                        @foreach($AyantDroits as $AyantDroit)
                          <option value="{{ $AyantDroit->id }}">
                            {{ $AyantDroit->Nom}} {{ $AyantDroit->Prenom}}
                          </option>
                        @endforeach
                      </select>
                        {!! $errors->first('AyantDroits', '<span class="error">:message</span>') !!}
                  </div>
                                    
                @if(session()->get('Profil') == 'User')
                  <div class="form-group">
                      <label>Partenaire *</label>
                      <select class="form-control select2" name="Partenaire">
                        @foreach($Partenaires as $P)
                          <option value="{{ $P->id}}">{{ $P->Partenaire}}</option>
                        @endforeach
                      </select>
                      {!! $errors->first('Partenaire', '<span class="error">:message</span>') !!}
                    </div>

                  <div class="form-group">
                      <label>Date Transmission *</label>
                      <input type="date" class="form-control" name="DateTrans" />
                      {!! $errors->first('DateTrans', '<span class="error">:message</span>') !!}
                  </div>
                @endif    
                                        
                <div class="form-group">
                    <label>Date Traitement *</label>
                    <input type="date" class="form-control" name="DateT" />
                    {!! $errors->first('DateT', '<span class="error">:message</span>') !!}
                </div>
              </div>

              <div class="col-md-6">
                <label>Type de Traitement* : </label> 
                  <div class="form-inline">   
                  @foreach($Services as $Service)
                  {{ $Service->service}} <input type="radio" value="{{$Service->id}}" class="form-control" name="TraitementT" required="required"/>   
                  @endforeach    
                  </div>
              </div>
           </div>  
        </div>
       </div>
     </div>
   </div>

   <div class="tab">
     <div class="container-fluid">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Details des Prestations</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                  <div class="form-group" style="display: none;">
                    <label>Facture*</label>
                    <input class="form-control" name="Facture" value="1" />
                    {!! $errors->first('Facture', '<span class="error">:message</span>') !!}
                  </div>

                <div class="form-group">
                  <label>Service *</label>
                  <select class="form-control select2" name="Libelle">
                    @foreach($Services as $Service)
                      <option value="{{ $Service->id }}">{{$Service->service}}</option>
                        @endforeach
                      </select>
                      {!! $errors->first('Libelle', '<span class="error">:message</span>') !!}
                </div>


                 <div class="form-group">
                     <label>Libellé *</label>
                     <select class="form-control select2" name="Propriete" id="Produit">
                         <option></option>
                     </select>
                     {!! $errors->first('Propriete', '<span class="error">:message</span>') !!}
                 </div>

                <label></label><br>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <button type="reset" class="btn btn-default">Annuler</button>

              </div>

              <div class="col-md-6">
               <div class="form-group">
                  <label>Quantité</label>
                  <input type="number" class="form-control" placeholder="Quantité" name="Quantite" value="{{ old('Quantite') }}" min="1" />
                  {!! $errors->first('Quantite', '<span class="error">:message</span>') !!}
               </div>

                @if(2==2 AND 0==0)
                <div class="form-inline">
                  <label>Marquer Sejour</label>
                    <input type="radio" required="" class="form-control"  name="Sejour" value="1"/>
                      <label>Annuler Sejour</label>
                         <input type="radio" required="" class="form-control"  name="Sejour" value="0"/>
                         {!! $errors->first('Sejour', '<span class="error">:message</span>') !!}
                </div>
                @else
                <div class="form-inline" style="display: none;">
                  <label>Marquer Sejour</label>
                  <input type="radio" checked="" class="form-control"  name="Sejour" value="0"/>
                  {!! $errors->first('Sejour', '<span class="error">:message</span>') !!}
                </div>
                @endif
              </div>
           </div>  

          </form>                   
    </div>
  </div>
</div>
                     <!-- End Form Elements -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">Services Accessible</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-striped">
                  <thead>
                                        <tr>
                                            <th>Service</th>
                                            <th>Couverture</th>
                                            <th>Partenaire</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     
                                       <tr>
                                           <td></td>
                                            <td></td>
                                             <td></td>
                                        </tr>
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
        </section>
      </div>
@endsection 

<script type="text/javascript">
   function getBeneficiaire(va){
     var id_affilier= $(va).val();

      $.get('{{ route('getProduiBenfic') }}',
          {id_affilier:id_affilier},
          function(data){
            $('#AyantDroits').html(data);
          });
   }
</script>