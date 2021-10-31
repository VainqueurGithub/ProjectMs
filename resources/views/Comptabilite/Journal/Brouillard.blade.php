@extends('layout.base')
@section('content')                        
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
        <section class="content">
      <div class="container-fluid">
                                  <div class="row">
                                         <div class="col-12">
                                    <form method="POST" action=" {{route('Journal.store')}}" name="P_form">  
                                          {{ csrf_field() }}
                                          <div class="row">

                                              <div class="col-12">
                                                <div class="row">
                                            
                                              <div class="col-3">
                                                 <div class="form-group">
                                                     <label>Date Ecr.</label>
                                                   <input type="date" id="hue" class="form-control" data-control="hue" name="DateOperation" value="{{ old('DateOperation')}}">
                                                    {!! $errors->first('DateOperation', '<span class="error">:message</span>') !!}
                                                 </div>
                                              </div>

                                              <div class="col-1">
                                                 <div class="form-group">
                                                    <label>N.Pièce</label>
                                                   <input type="text" id="hue" class="form-control" data-control="hue" name="Piece" value="{{ old('Piece')}}">
                                                    {!! $errors->first('Piece', '<span class="error">:message</span>') !!}
                                                 </div>
                                              </div>

                                              <div class="col-4">
                                                  <div class="form-group">
                                                    <label>Montant</label>
                                                   <input type="text" id="hue-demo" class="form-control" data-control="hue" name="MC" value="{{ old('MC')}}" style="display:;" id="MC">
                                                    {!! $errors->first('MC', '<span class="error">:message</span>') !!}
                                                 </div> 
                                              </div>

                                               <div class="col-3">
                                                  <div class="form-group">
                                                    <label>Libelle.</label>
                                                    <textarea id="hue-demo" class="form-control" data-control="hue" name="Libelle">{{ old('Libelle')}}</textarea>
                                                
                                                    {!! $errors->first('Libelle', '<span class="error">:message</span>') !!}
                                                 </div> 
                                              </div>

                                              <div class="col-1">
                                                  <div class="form-group">
                                                   <button style="margin-top: 30px;" type="submit" class="form-control btn btn-success">Valider</button>
                                                 </div> 
                                              </div>

                                                </div>
                                              </div>


                                             
                                          </div>
                                           </form>  
                                        </div>
                                  </div>
                                </div>
                              </section>


    <section class="content">
      <div class="container-fluid">
        <div class="row">
                                <div class="table-responsive">
                                   <div class="col-12">
                                    <table id="example1" class="table table-striped">
                                        <thead>
                                            <tr style="text-align: center;">
                                                <th rowspan="2">Date</th>
                                                <th rowspan="2">N° Piece</th>
                                                <th rowspan="2">Montant</th>
                                                <th rowspan="2">Libelle</th>
                                                <th rowspan="2">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                         
                                        </tbody>
                                        <tfoot>
          
                                        </tfoot>
                                    </table>
                                    </div>
                                </div>

                            </div>
                        </div>
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
function openSComptesPopUp(va) {
     var id = $(va).val();
     var url = "{{ route('Comptedivisionnaire.show', ":id") }}";
     url = url.replace(':id', id);
  if (WindowObjectReference == null || WindowObjectReference.closed) {
    WindowObjectReference = window.open(url,'rating', "width=500,height=250,left=540,top=400,resizable,scrollbars=yes,status=1,menubar=no");
  }
  else {
    WindowObjectReference.focus();
  };
}

function hideSousComptes() {
      var SousId = $('#Csubdiv1').val();
      document.P_form.sc_compte1.value = '';
      document.P_form.sccomte_int1.value = '';
      document.getElementById('sccomte_int1').style.display = 'none';
      var url = "{{ route('Comptedivisionnaire.show', ":SousId") }}";
      url = url.replace(':SousId', SousId);
      if (WindowObjectReference == null || WindowObjectReference.closed) {
        WindowObjectReference = window.open(url,'rating', "width=500,height=250,left=540,top=400,resizable,scrollbars=yes,status=1,menubar=no");
      }
      else {
        WindowObjectReference.focus();
      };
}
</script>                                                                          