@extends('layout.base', ['title' => 'Tableau De Bord'])
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">Historique</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>DEBUT</th>
                      <th>FIN</th>
                      <th>MONTANT</th>
                      <th>ACTION</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($Historiques as $Historique)
                      <tr class='odd gradeX'>
                        <td>{{$Historique->debut}}</td>
                        <td>{{$Historique->fin}}</td>
                        <td>{{$Historique->motant}}</td>
                        <td>
                          <button value="{{$Historique->id}}" data-toggle="modal" onclick="getHistoriqueId(this)" data-target="#modal-default1" style="text-decoration: none;color: white">
                            <div class="btn btn-info btn-sm" style="margin-top:-5px">
                            <i class="fa fa-plus"></i> Marquer Fin
                          </button>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

<!-- MODAL POUR LES MOUVEMENT DE L'AFFILIER DEBUT-->
  <div class="modal fade" id="modal-default1">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form action="{{route('changeAmountCotisation')}}" method="POST"> 
            {{ csrf_field() }} 
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                        <input type="text" name="Historique" id="historiue" style="display: none;">
                      <div class="form-group">
                        <input type="text" name="affilier" value="{{$affilier_id}}" style="display: none;">
                        <input type="numeric" class="form-control" name="Montant">
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
  function getHistoriqueId(va) {
     var aff = $(va).val();
    $('#historiue').val(aff);
  }
</script>