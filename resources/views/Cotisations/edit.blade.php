@extends('layout.base', ['title' => 'Assurance - Edition Cotisation'])
@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Cotisation</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Cotisation</li>
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
              <div class="col-md-3"> Modification d'une Cotisation</div>
              <div class="col-md-6"></div>
              <div class="col-md-3">
                   <a href="{{ route('Cotisations.index') }}" style="text-decoration: none;color: white">
                <div class="btn btn-info pull-right"  style="margin-top: -5px">
                 <i class="fa fa-book"></i> Liste des Cotisation
                </a>
              </div>
          </div>  
      </div>    
                                    <form role="form" method="POST" action="{{ route('Cotisations.update', $Cotisation)}}">
                                      {{ csrf_field() }}
                                      {{ method_field('PUT') }}
    
                                @include('Cotisations._Form', ['ButtonSubmitTexe'=>'Modifier'])
        </form>
                                    <br />                    
    </div>
     </section>     
@endsection 

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