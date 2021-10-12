@extends('layout.base', ['title' => 'Assurance - Edition Partenaire'])
@section('content')

 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>CHANGER L'IDENTITE DU MS</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">ms.identite</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

      <!-- Main content -->
    <section class="content">
      <!-- Form Elements -->
    <div class="card card-default">
    </div>    
      <form role="form" method="POST" action="{{ route('ModifierAdresse', $Consomation)}}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
          <div class="form-group">
            <label>Adresse</label>
            <textarea class="form-control" name="Adresse" cols="10" rows="10">
            {{ $Consomation->Adresse}}
            </textarea>
            {!! $errors->first('Adresse', '<span class="error">:message</span>') !!}
          </div>
          <button type="submit" name="Payement" class="btn btn-primary"><i class="fas fa-edit"></i> Modifier</button>
      </form>
   </div>
     </section> 
@endsection 
