@extends('layout.base', ['title' => 'Tableau De Bord'])
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
                     <form method="POST" action="{{route('registre_adhesion_generate')}}" target="blank">
                        {{ csrf_field() }}
                        <div class="row" style="width:80%;">
                            <div class="col-md-5">
                              <div class="form-group">
                                 <label>Du</label>
                                 <input type="date" name="debut" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-5">
                              <div class="form-group">
                                 <label>Au</label>
                                 <input type="date" name="fin" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                <label>generer</label>
                                <button type="submit" class="btn btn-primary">Imprimer</button>
                                </div> 
                            </div>
                        </div>
                     </form> 
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">REGISTRE D’ADHESIONS</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-striped">
                  <thead>
                     <tr style="text-align: center;">
                                                <th rowspan="3">Date</th>
                                                <th colspan="3">Adhérents</th>
                                                <th colspan="3">Personnes à charge</th>
                                                <th colspan="3"> Total bénéficiaires</th>
                                  </tr>

                                            <tr>
                                                <th>Entrées</th>
                                                <th>Sorties</th>
                                                <th>total</th>
                                                 <th>Entrées</th>
                                                <th>Sorties</th>
                                                <th>total</th>
                                                 <th>Entrées</th>
                                                <th>Sorties</th>
                                                <th>total</th>
                                            </tr>
                                    </thead>
                                    <tbody style="text-align: center;">
                                     {!!$tableListe!!}
                                    </tbody>
                                    <tfoot style="text-align: center;">
                                         {!!$table1!!}
                                    </tfoot>
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

      <script type="text/javascript">
         var WindowObjectReference = null; // variable globale
function openFFPromotionPopup(va) {
     var id = $(va).val();
     var tab = id.split("*");
     var periode = tab[0];
     var type_mvt = tab[1];
     var type_beneficiaire = tab[2];
    var url1 = "{{ route('details_mvt', ['periode'=>":periode", 'type_beneficiaire'=>":type_beneficiaire", 'type_mvt'=>":type_mvt"])}}";
    url1 = url1.replace(':periode', periode);
    url1 = url1.replace(':type_mvt', type_mvt);
    url1 = url1.replace(':type_beneficiaire', type_beneficiaire);

  if (WindowObjectReference == null || WindowObjectReference.closed) {
    WindowObjectReference = window.open(url1,
           "PromoteFirefoxWindowName", "width=940,height=500,resizable,scrollbars=yes,status=1");
  }
  else {
    WindowObjectReference.focus();
  };
}
      </script>