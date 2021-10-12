@extends('layout.base', ['title' => 'Assurance - Factures'])

@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
            <h3>Liste des Factures</h3>
        </div>
      </div><!-- /.container-fluid -->
    </section><hr />
 <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste des Factures</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-striped">
                  <thead>
                  <tr>
                                            <th>N° Facture</th>
                                            <th>D.Traitement</th>
                                            <th>D.Transmission</th>
                                            <th>Affilier</th>
                                            <th>Béneficiaire</th>
                                            <th>Partenaire</th>
                                            <th>Montant</th>
                                            <th>D.Payement</th>
                                            <th>M.Payement</th>
                                            <th>Action</th>
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
