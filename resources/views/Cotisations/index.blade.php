@extends('layout.base', ['title' => 'Assurance - Liste des Cotisation'])
@section('content')
 <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
            <h3>Liste des Cotisations récentes</h3>
        </div>
      </div><!-- /.container-fluid -->
    </section><hr />
 <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col-md-3"> Liste des Cotisations récentes</div>
                  <div class="col-md-6"></div>
                  <div class="col-md-3">
                      <a href="{{ route('Cotisations.create') }}" style="text-decoration: none;color: white">
                             <div class="btn btn-info pull-right"  style="margin-top: -5px">
                            <i class="fa fa-plus"></i> Ajouter une Cotisation
                            </a>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-striped">
                  <thead>
                    <tr>
                                            <th>CODE</th>
                                            <th>ADHERANT</th>
                                            <th>MOIS</th>
                                            <th>ANNEE</th>
                                            <th>MONTANT</th>
                                            <th>DATE PAYEMENT</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       {!! $tableListe !!}
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
             <!-- /. PAGE INNER  -->
@endsection 
