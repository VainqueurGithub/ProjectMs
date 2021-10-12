@extends('layout.base')
@section('content')                        
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <!-- Left col -->
          <div class="col-md-12">
            <div class="card">
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>Numero</th>
                      <th>Intitulé</th>
                    </tr>
                    </thead>
                    <tbody>
                      @if($IsNotEmpty=="yes")
                      @foreach($SousCompte as $SousCompt)
                    <tr>
                      <td><button style="border:none;background-color: white;" value="{{$SousCompt->id}},{{$SousCompt->NumeroCompte}},{{$SousCompt->Intitule}},{{$SousCompt->Compte_subd}}" onclick="closePopup(this)"><a href="">{{$SousCompt->NumeroCompte}}</a></button>
                      </td>
                      <td>{{$SousCompt->Intitule}}</td>
                    </tr>
                   @endforeach
                   @else
                      <tr>
                      <td>000#</td>
                      <td>Aucun sous compte</td>
                    </tr>
                   @endif
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->

        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

<script type="text/javascript">
  function closePopup(va) {
      var keywords = $(va).val().split(",");
      opener.document.P_form.sc_compte1.value = keywords[0];
      opener.document.P_form.sccomte_int1.value = keywords[1]+' -- '+keywords[2];
      opener.document.P_form.Csubdiv1.value = keywords[3];
      opener.document.getElementById("sccomte_int1").style.display = 'block';
      self.close();
  }
</script>
