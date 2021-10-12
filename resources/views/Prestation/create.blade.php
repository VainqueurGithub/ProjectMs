@extends('layout.base', ['title' => 'Assurance - Nouvelle Facture'])
@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4> Enregistrement des Prestations (Facture)</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Prestation</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <form role="form" method="POST" action="{{ route('Factures.store')}}">

     <div class="container-fluid" style="display: none;" id="InfoG">
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
                          @if($AyantDroit->status==1)
                              <option value="{{ $AyantDroit->id }}" disabled="">
                                {{ $AyantDroit->Nom}} {{ $AyantDroit->Prenom}} <a href="#" class="badge badge-danger">sortie</a>
                              </option>
                          @else
                              <option value="{{ $AyantDroit->id }}">
                                  {{ $AyantDroit->Nom}} {{ $AyantDroit->Prenom}}
                              </option>
                          @endif
                        @endforeach
                      </select>
                        {!! $errors->first('AyantDroits', '<span class="error">:message</span>') !!}
                  </div>
                                    
                @if(session()->get('Profil') == 'User')
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
           </div>
              <button type="submit" id="sub_btn" class="btn btn-primary"><i class="fas fa-check"></i> Valider</button>
              <button type="reset" class="btn btn-default">Annuler</button>
              <button class="btn btn-default" id="return">Retourner</button>  
        </div>
       </div>
     </div>
    </form>

     <div class="container-fluid" id="PrestInfo">
        <div class="card card-default">
          <div class="card-header">
            <button style="border: none;cursor: pointer;" target="PromoteFirefoxWindowName" class="btn btn-primary" onclick="openFFPromotionCartDetails(); return false;">
              {{$totalQuant}} Prestations disponible dans votre panier
            </button>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
          <form role="form" method="POST" action="{{ route('panier.store')}}">
            <div class="row">
              <div class="col-md-6">
                  <div class="form-group" style="display: none;">
                    <label>Facture*</label>
                    <input class="form-control" id="Aff" name="Affilier" value="{{$Aff}}" />
                    <input class="form-control" id="Service" name="Service" value="{{$Prestation->id ?: $Service}}" />
                    {!! $errors->first('Facture', '<span class="error">:message</span>') !!}
                  </div>

                 <div class="form-group">
                     <label>Libellé *</label>
                     <select class="form-control select2" name="Propriete">
                      @foreach($Medicaments as $Medicament)
                         <option value="{{$Medicament->id}}">{{$Medicament->code}}/{{$Medicament->prix}}</option>
                      @endforeach   
                     </select>
                     {!! $errors->first('Propriete', '<span class="error">:message</span>') !!}
                 </div>

                   <div class="form-group">
                  <label>Quantité</label>
                  <input type="number" class="form-control" placeholder="Quantité" name="Quantite" value="{{ old('Quantite') }}" min="1" />
                  {!! $errors->first('Quantite', '<span class="error">:message</span>') !!}
               </div>

                <label></label><br>
                <button type="submit" id="sub_btn" class="btn btn-primary">Ajouter</button>
                <button type="reset" class="btn btn-default">Annuler</button>
                @if($totalQuant!=0)
                <button class="btn btn-default" id="Sent">Envoyer à SAAT</button>
                @endif
              </div>

              <div class="col-md-6">
                 @if($Prestation->Traitement==2 AND $sejourExist==false)
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
@endsection 

@section('content2')
<script type="text/javascript">
  var WindowObjectReference = null; // variable globale
  $(document).ready(function(){
      $("#Sent").click(function(e){
          document.getElementById("InfoG").style.display = 'block';
          document.getElementById("PrestInfo").style.display = 'none';
          e.preventDefault();
      });

       $("#return").click(function(e){
          document.getElementById("InfoG").style.display = 'none';
          document.getElementById("PrestInfo").style.display = 'block';
          e.preventDefault();
      });
  });

  function openFFPromotionCartDetails(){
  var Aff = $('#Aff').val();
  var Service = $('#Service').val();
  var url1 = "{{ route('panier.index')}}";
  if (WindowObjectReference == null || WindowObjectReference.closed) {
    WindowObjectReference = window.open(url1,
           "PromoteFirefoxWindowName", "width=900,height=550,resizable,scrollbars=yes,status=1");
  }
  else {
    WindowObjectReference.focus();
  };
}
</script>
@endsection