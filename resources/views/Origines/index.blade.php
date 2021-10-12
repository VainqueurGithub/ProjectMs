@extends('layout.base', ['title' => 'Assurance - Origines'])
@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
               <div class="row">
                  <div class="col-md-12">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                          <thead>
                            <tr>
                                <th>
                                  Code ou Piece similaire Lors de l'importation

                                  <a href="{{route('cleanFile')}}" style="text-decoration: none;color: white">
                                  <div class="btn btn-info pull-right"  style="margin-top: -5px">
                                    Effacer
                                  </a>
                                </th>
                            </tr>
                          </thead>
                          <tbody>

                            @foreach ($fichier as $fich)
                            <tr class="odd gradeX">
                              <td>{{ $fich }}</td> 
                            </tr> 
                            @endforeach   
                            </tbody>
                        </table>
                            </div>
                  </div>
               </div>


          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">DataTables</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section><hr />
 <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste des Affiliers</h3>
                <div class="row">
                  <div class="col-md-9"></div>
                  <div class="col-md-3">
                     <div class="btn btn-info pull-right" data-toggle="modal" data-target="#modal-sm"  style="margin-top: -5px">
                      <i class="fa fa-plus"></i> Ajouter une Origine
                    
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-striped">
                  <thead>
                  <tr>
                                          <th>Ref</th>
                                          <th>Origine</th>
                                          <th>Date Enregitrement</th>
                                          <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                      @foreach ($Origines as $O)

                                         <tr class="odd gradeX">
                                            <td>{{ $O->id }}</td>
                                            <td>{{ $O->Origine }}</td>
                                            <td>{{ $O->created_at }} 
                                                        
                              <td>
                                <a href="{{ route('Origines.edit', $O) }}"><i class="fas fa-edit"></i></a>

                                <form action="{{ route('Origines.destroy', $O) }}" method="POST" style="display: inline-block;" onsubmit='return confirm("Etez -vous sur de cette Operation ?")'>
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                    
                                <button style="border: none;" class="btn btn-danger btn-sm" onclick='return confirm("Etez -vous sur d\'effectuer cette Operation ?")'><i class="fas fa-trash"></i>
                                </button>
                               </form>

                              
                                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-default" value="{{$O->id}}" onclick="getOrigineId(this)"> Plus d'actions </button>

                                <a href="{{ route('PdfListeAffilie', $O->id)}}"><i class="fas fa-print"></i></a>
                              </td>
                                    </tr> 
                                    @endforeach   
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




  <div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">CHOISIR L'OPTION</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" action="{{route('perfomAction')}}" enctype="multipart/form-data" onsubmit='return confirm("Etez - vous sur de cette Operation ?")'>
                {{ csrf_field() }}
                  <div class="card-body">
                    <div class="row">

                      <div class="col-md-6">
                        <label>Action a Faire</label>
                          <div class="form-inline">
                            Importer les Affiliés  <input type="radio" name="action" class="form-control" value="0" checked="checked" onclick="showuploadedform();"> 
                          </div>
                          
                          <div class="form-inline">
                            Importer les Ayants Droits  <input type="radio" name="action" class="form-control" value="3" onclick="showuploadedform();"> 
                          </div>

                          <div class="form-inline">
                            Supprimer Les Affiliés <input type="radio" name="action" class="form-control" value="1" onclick="hideuploadedform();">
                          </div>
                          <div class="form-inline">
                            Supprimer Les Affiliés et Leur Origine  <input type="radio" name="action" class="form-control" value="2" onclick="hideuploadedform();">
                          </div>    
                          {!! $errors->first('action', '<span class="error">:message</span>') !!}
                          
                          <div class="form-inline">
                            Cotisation en masse  <input type="radio" name="action" class="form-control" value="4" onclick="showformcotisation();">
                          </div>    
                          {!! $errors->first('action', '<span class="error">:message</span>') !!}
                          
                      </div>


                      <div class="col-md-6" style="display: none;">
                        <div class="form-group">
                          <label>ID *</label>
                            <input type="text" name="Origine" class="form-control" value="{{old('Origine')}}" id="Origine">
                          {!! $errors->first('Origine', '<span class="error">:message</span>') !!}
                        </div>
                      </div>


                      <div style="" class="col-md-6" id="uploadForm">
                        <div class="form-group">
                          <label>Fichier Excel *</label>
                            <input type="file" name="fichier" class="form-control">
                          {!! $errors->first('fichier', '<span class="error">:message</span>') !!}
                        </div>
                      </div>
                      
                      <div class="col-md-6" id="formcotisation" style='display:none'>
 <div class="form-group">
         <label>Mois *</label>
           <input type="number" min="1" max="12" class="form-control" name="Mois" value="old('Mois')" />
          {!! $errors->first('Mois', '<span class="error">:message</span>') !!}
        </div>

        <div class="form-group">
         <label>Annee *</label>
           <input type="number" min="2000" class="form-control" name="Annee" value="old('Annee')" />
          {!! $errors->first('Annee', '<span class="error">:message</span>') !!}
        </div>

        <div class="form-group">
          <label>Montant *</label>
           <input type="number" min="1" class="form-control" name="Montant" value="old('Montant')" />
           {!! $errors->first('Montant', '<span class="error">:message</span>') !!}
        </div>

         <div class="form-group">
         <label>Date de payement *</label>
           <input type="date" class="form-control" name="Datepayement" value="old('Datepayement')" />
          {!! $errors->first('Datepayement', '<span class="error">:message</span>') !!}
        </div>
                      </div>
                     
                     
                   
                      <div class="col-md-6">
                        <div class="card-footer">
                          <button type="submit" class="btn btn-success swalDefaultSuccess" onclick='return confirm("Etez -vous sur d\'effectuer cette Operation ?")'><i class="fas fa-save"></i> Valider L'action</button>
                        </div>
                      </div>

                    </div>
                  </div>

              </form>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>


      <div class="modal fade" id="modal-sm">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Nouvelle Origine</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
               <form role="form" method="POST" action="{{ route('Origines.store')}}">
        {{ csrf_field() }}

            @include('Origines._Form', ['ButtonSubmitTexe'=>'Enregister'])
            <button type="reset" class="btn btn-default">Annuler</button>

        </form>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

@endsection 

<script type="text/javascript">
  function getOrigineId(va){
    var origine = $(va).val();

    $.get('{{route('getOrigineId')}}',
    {origine:origine},
    function(data){
      var donnee = data.split("#");
      $("#Origine").val(donnee[0]);
    });
  }


  function showuploadedform()
  {
    document.getElementById("uploadForm").style.display = 'block';
    document.getElementById("formcotisation").style.display = 'none';
  }

  function hideuploadedform()
  {
    document.getElementById("uploadForm").style.display = 'none';
    document.getElementById("formcotisation").style.display = 'none';
  }
  
  function showformcotisation()
  {
    document.getElementById("formcotisation").style.display = 'block';
    document.getElementById("uploadForm").style.display = 'none';
  }
</script>