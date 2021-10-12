@extends('layout.base', ['title' => 'Assurance - Ayant Droit'])
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Personne en charge</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Personne en charge</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    
    <!-- Main content -->
    <section class="content">
      <!-- Form Elements -->
    <div class="card card-default">
        <div class="card-header">
          <div class="row">
              <div class="col-md-3"> Ajout d'une personne en charge</div>
              <div class="col-md-7"></div>
              <div class="col-md-2">
                   <a href="{{ route('AyantsDroit.index') }}" style="text-decoration: none;color: white">
                <div class="btn btn-info pull-right"  style="margin-top: -5px">
                 <i class="fa fa-book"></i> Liste des Personne en Charge
                </a>
              </div>
          </div>  
      </div>    
                        <form role="form" method="POST" action="{{ route('AyantsDroit.store')}}">
                            {{ csrf_field() }}
                           @include('AyantsDroit._Form', ['ButtonSubmitTexe'=>'Enregistrer'])
                             <button type="reset" class="btn btn-default">Annuler</button>
                            </div>
                        </form>
                      </div>
     </section>     
@endsection 

<script type="text/javascript">
  function AutreLien()
  {
    document.getElementById("Autres").style.display = 'flex';
    //document.getElementById("FormAjoutClient").style.display = 'none';
  }

  function AutreLienFermer()
  {
    document.getElementById("Autres").style.display = 'none';
  }

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