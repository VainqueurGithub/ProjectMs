@extends('layout.base', ['title' => 'Assurance - Nouveau Partenaire'])
@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <h5 style="text-align:justify;">Importation des services</h5>     
            <a href="{{route('ExportExcelMedicament', $Partenaire)}}" class="btn btn-primary">Export vers Excel</a>
          </div>
        </div>
                 <!-- /. ROW  --><hr />
               <div class="row">
                <div class="col-md-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                   <form method="POST" action="{{ route('PostImport') }}" enctype="multipart/form-data" class="form_horizontal">
                                      {{ csrf_field() }}
                                      {{ method_field('POST') }}
                                       <div class="form-group">
                                            <label>Atacher un fichier Excel au format csv *</label>
                                            <input type="file" class="form-control" name="services" id="file" />
                                    {!! $errors->first('services', '<span class="error">:message</span>') !!}
                                        </div>
                                        <div class="form-group">
                                          <input type="hidden" name="hidden_field" value="1"/>
                                          <input type="submit" id="import" name="import" value="Importer les fichiers Excel" class="btn btn-primary"/>
                                        </div>
                                        <input hidden="hidden" type="text" id="Partenaire" name="Partenaire" value="{{$Partenaire}}">
                                        <label></label><br>
                                    </form>
                                    <div class="form-group" id="process" style="display: none;">
                                        <div class="progress">
                                           <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                             <span class="process_data">0</span>
                                             - <span id="total_data">0</span>
                                           </div>
                                        </div>
                                    </div>
                                    <br />                    
                             </div>

                             <div class="col-md-6" style="font-size: 20px;">
                                  <h3>NOTE IMPORTANTE</h3>
                                   Lisez attentivement avant d'importer le fichier.
                                   <ol>
                                       <li>Seul les fichiers Excel doivent etre importés</li>
                                       <li>Vérifier que le fichier est composé de ces 4 colonnes et écrites de la meme maniere (medicament, prix, code, designation)</li>
                                       <li>Rassurer vous que toutes ces colonnes sont remplies</li>
                                   </ol>

                                   <div>
                                      
                                   </div>
                             </div>

                            </div>
                        </div>
                    </div>
                     <!-- End Form Elements -->
                </div>
                <div class="col-12">
              <div class="card">
              <div class="card-header">
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-striped">
                  <thead>
                  <tr>
                                            <th>#</th>
                                            <th>Ref. SAAT</th>
                                            <th>Ref.Partenaire</th>
                                            <th>Code</th>
                                            <th>Prix</th>
                                            <th></th>
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
@endsection 
