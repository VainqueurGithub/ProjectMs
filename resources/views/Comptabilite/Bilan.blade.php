@extends('layout.base')
@section('content')                        
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
            <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                              <div class="row">

                                         <div class="col-8">
                                    <form method="POST" action=" {{route('BilanPdf')}}">  
                                          {{ csrf_field() }}
                                          <div class="row">

                                             <div class="col-6">
                                                  <div class="form-group">
                                                    <select class="form-control select2" data-control="hue" name="Exercice" required="">
                                                      @foreach($Exercices as $Exercice)
                                                       <option value="{{ $Exercice->id }}">{{ $Exercice->Debut }} - {{ $Exercice->Fin }}</option>
                                                      @endforeach 
                                                    </select>
                                                 </div> 
                                              </div>

                                              <div class="col-5">
                                                  <button type="submit" class="btn btn-success" name="Rapport">Generer Bilan</button>
                                              </div>
                                           
                                          </div>
                                           </form>  
                                        </div>
                                  </div><hr>
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr style="text-align: center;">
                                                <th>Comptes</th>
                                                <th>Montant</th>
                                            </tr>
                                        </thead>
                                       
                                            {!! $tableListe !!}
                                       
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
               </div>
      </div><!-- /.container-fluid -->
    </section>
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
var WindowObjectReference = null; // variable globale
function openFFPromotionPopup(va) {
     var id = $(va).val();
     var tab = id.split("*");
     var periode = tab[0];
     var compte = tab[1];
     var url = "{{ route('details_bilan', ['periode'=>":periode", 'compte'=>":compte"])}}";
     url = url.replace(':periode', periode);
     url = url.replace(':compte', compte);
  if (WindowObjectReference == null || WindowObjectReference.closed) {
    WindowObjectReference = window.open(url,
           "PromoteFirefoxWindowName", "toolbar=no,scrollbars=no,location=no,statusbar=no,width=940,height=500,resizable,scrollbars=yes,status=1,menubar=no");
  }
  else {
    WindowObjectReference.focus();
  };
}

</script>                                         