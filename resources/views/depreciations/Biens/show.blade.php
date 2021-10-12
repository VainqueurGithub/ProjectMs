@extends('layout.base', ['title' => 'Assurance - Immobilier'])

@section('content')
  <div class="content-wrapper">
 <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste des Immobiliers</h3>
                <div class="row">
                  <div class="col-md-9"></div>
                  <div class="col-md-3">
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-striped">
                  <thead>
                  <tr>
                                            <th>#</th>
                                            <th>Bien</th>
                                            <th>Date Début</th>
                                            <th>Date Fin</th>
                                            <th>Montant de L'amortisement</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                      {!! $TableListe !!}
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