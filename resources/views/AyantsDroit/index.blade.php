@extends('layout.base', ['title' => 'Assurance - Ayant Droit'])
@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
            <h3>Liste des Personne Prise en Charge</h3>
        </div>
      </div><!-- /.container-fluid -->
    </section><hr />
 <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste des Personne Prise en Charge</h3>
                <div class="row">
                  <div class="col-md-7"></div>
                  <div class="col-md-5">
                    <a href="{{ route('AyantsDroit.create') }}" style="text-decoration: none;color: white">
                    <div class="btn btn-info pull-right"  style="margin-top: -5px">
                    <i class="fa fa-plus"></i> Ajouter une Personne en Charge
                    </a>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-striped">
                  <thead>
                  <tr>
                                            <th>Ref</th>
                                            <th>Affilier</th>
                                            <th>Nom</th>
                                            <th>Prenom</th>
                                            <th>Lien</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($AyantDroits as $AyantDroit)

                                            <tr class='odd gradeX'>
                                                <td>{{$AyantDroit->id}}</td>
                                                <td>{{$AyantDroit->Code}}</td>
                                                <td>{{$AyantDroit->Nom}}</td>
                                                <td>{{$AyantDroit->Prenom}}</td>
                                                <td>{{$AyantDroit->Lien}}</td>
                                                <td>
                                                   <a href="{{route('AyantsDroit.edit',$AyantDroit->id)}}"><i class='fas fa-edit'></i></a>

                                                    <form action="{{route('AyantsDroit.destroy',$AyantDroit->id)}}" method='POST' style='display: inline-block;' onsubmit='return confirm("Etez -vous sur de cette Operation ?")'>
                                                   
                                                    {{csrf_field()}}
                                                    {{method_field('DELETE')}}
                                                    <button><i class="fas fa-trash"></i>
                                                    </button>
                                                    </form>
                                                  
                                                   <button style="border: none;" value="{{$AyantDroit->id}}" onclick="thisAyantDroit(this)" data-toggle="modal" data-target="#registre_mvt_affilier">
                                                   <i class='fa fa-plus'></i>
                                                  </button>
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


  <!-- MODAL POUR LES MOUVEMENT DE L'AFFILIER DEBUT-->
  <div class="modal fade" id="registre_mvt_affilier">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">MOUVEMENT PERSONNE EN CHARGE</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form action="{{route('mouvement_affilier.store')}}" method="POST">  
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                      <div class="form-group" style="display: none;">
                       <input type="text" class="form-control" name="beneficiaire" id="idAff">
                       <input type="text" class="form-control" name="beneficiaire_type" value="2">
                      </div> 
                     <div class="form-group">
                       <select class="form-control" name="mvt_affilier" id="statu">
                           
                       </select>
                     </div>  
                     <div class="form-group">
                       <input type="date" name="datemvt" class="form-control">
                     </div>
                     <div class="form-group">
                       <textarea name="motif" class="form-control"></textarea>
                     </div>

                     <button type="submit" class="btn btn-primary">Enregistrer</button>
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
<!-- MODAL POUR LES MOUVEMENT DE L'AFFILIER FIN-->

@endsection 
<script type="text/javascript">
  function thisAyantDroit(va){
    var aff = $(va).val();
    var type_ben = 2;
    $('#idAff').val(aff);
    var route = "{{ route('beneficiairestatus', ['aff'=>":aff", 'type_ben'=>":type_ben"])}}";
     route = route.replace(':aff', aff);
     route = route.replace(':type_ben', type_ben);
     $.get(route,
          function(data){
            $('#statu').html(data);
    });
  }
</script>