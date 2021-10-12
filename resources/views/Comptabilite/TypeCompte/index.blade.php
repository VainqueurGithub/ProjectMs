@extends('layout.base')
@section('content')                        

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">Classes comptable</h3>
                <div class="row">
                  <div class="col-md-9"></div>
                  <div class="col-3">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#add-new-event" class="btn m-t-20 btn-info btn-block waves-effect waves-light">
                    <i class="ti-plus"></i> Nouveau Type Compte
                    </a>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-striped">
                  <thead>



                                            <tr>
                                                <th>#</th>
                                                <th>Classe</th>
                                                <th>Intitulé</th>
                                                <th>Type</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          @foreach($Types as $Type) 
                                               <tr>
                                                 <td>{{ $Type->id}}</td>
                                                 <td>{{ $Type->Class}}</td>
                                                 <td>{{ $Type->Types }}</td>
                                                 @if($Type->Type_Compte==1)
                                                 <td>Comptes du bilan</td>
                                                 @else
                                                 <td>Comptes de gestion</td>
                                                 @endif
                                                 <td>

                                                  <button data-toggle="modal" data-target="#add-older-event" value="{{$Type->id}}" onclick="getTypeCompte(this)">
                                                     <i class="fas fa-edit"></i>
                                                  </button>

                                                <form action="{{route('TypeCompte.destroy', $Type->id)}}" method='POST' style='display: inline-block;' onsubmit="return confirm('Etez-vous sur de cette Operation ?')">
                                                {{ csrf_field()}}
                                                {{method_field('DELETE')}}
                    
                                                <button onclick="return confirm('Etez -vous sur de cette Operation ?')"><i class='fas fa-trash'></i>
                                                </button>
                                               </form>
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
                     <!-- Modal Add Category -->
                <div class="modal fade none-border" id="add-new-event">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><strong>Creer une classe</strong></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                        <form method="POST" action="{{ route('TypeCompte.store')}}">
                            <div class="modal-body">
                               
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="control-label">Classe *</label>
                                            <input class="form-control form-white" placeholder="Classe compte" type="text" name="Classe" />
                                            {!! $errors->first('Classe', '<span class="error">:message</span>') !!}

                                            <label class="control-label">Intitulé *</label>
                                            <input class="form-control form-white" placeholder="Intitule de la classe" type="text" name="Intitule" />
                                            {!! $errors->first('Intitule', '<span class="error">:message</span>') !!}

                                            <label class="control-label">Type de Classe *</label>
                                            <div class="form-inline">
                                                Comptes du Bilan <input type="radio" name="Type" class="form-control" value="1" checked="checked">
                                            </div>
                                            <div class="form-inline">
                                                Comptes de gestion <input type="radio" name="Type" class="form-control" value="2">
                                            </div>
                                            {!! $errors->first('Type', '<span class="error">:message</span>') !!}
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary waves-effect waves-light save-category">Enregistrer</button>
                                <button type="reset" class="btn btn-secondary waves-effect" data-dismiss="modal">Annuler</button>
                            </div>
                           </form> 
                        </div>
                    </div>
                </div>


                <div class="modal fade none-border" id="add-older-event">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><strong>Modifier une classe une classe</strong></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                        <form method="POST" action="{{ route('Update_typeCompte')}}">
                            <div class="modal-body">
                               
                                   {{ csrf_field() }}
                                   {{ method_field('PUT') }}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="text" name="Identifiant" id="Identifiant" style="display: none;">
                                            <label class="control-label">Classe *</label>
                                            <input class="form-control form-white" placeholder="Classe compte" type="text" name="Classe" id="Classe" />
                                            {!! $errors->first('Classe', '<span class="error">:message</span>') !!}

                                            <label class="control-label">Intitulé *</label>
                                            <input class="form-control form-white" placeholder="Intitule de la classe" type="text" name="Intitule" id="Intitule" />
                                            {!! $errors->first('Intitule', '<span class="error">:message</span>') !!}

                                            <label class="control-label">Type de Classe *</label>
                                            <div id="RadionButt">
                                          
                                            </div>
                                            {!! $errors->first('Type', '<span class="error">:message</span>') !!}
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary waves-effect waves-light save-category">Enregistrer</button>
                                <button type="reset" class="btn btn-secondary waves-effect" data-dismiss="modal">Annuler</button>
                            </div>
                           </form> 
                        </div>
                    </div>
                </div>
                <!-- END MODAL -->
                </div>



                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->

                        @endsection

<script type="text/javascript">
  function getTypeCompte(va){
    var type= $(va).val();
  
    $.get('{{route('getTypeCompteId')}}',
    {type:type},
    function(data){
      var donnee = data.split("#");
      $("#Identifiant").val(donnee[0]);
      $("#Classe").val(donnee[1]);
      $("#Intitule").val(donnee[2]);
      $('#RadionButt').html(donnee[3]);
    });
  }
</script>                        