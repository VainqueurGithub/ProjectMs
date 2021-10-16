@extends('layout.base')
@section('content')                        
<!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
           
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                  <div class="row">

                                         <div class="col-12">
                                          <form method="POST" action="{{route('permission.store')}}">  
                                          {{ csrf_field() }}
                                            <div class="row">
                                              <input type="text" value="{{$id}}" name="module" style="display: none;">
                                             
                                              <div class="col-5">
                                                  <div class="form-group">
                                                    <label>Link(route) *</label>
                                                   <input type="text" class="form-control" required="" name="Link">
                                                    {!! $errors->first('Link', '<span class="error">:message</span>') !!}
                                                 </div> 
                                              </div>

                                              <div class="col-5">
                                                  <div class="form-group">
                                                    <label>Action *</label>
                                                   <input type="text" class="form-control" required="" name="Action">
                                                    {!! $errors->first('Action', '<span class="error">:message</span>') !!}
                                                 </div> 
                                              </div>


                                              <div class="col-2">
                                                  <div class="form-group">
                                                   <button style="margin-top: 30px;" type="submit" class="form-control btn btn-success">Ajouter</button>
                                                 </div> 
                                              </div>
                                          </div>
                                      </form>
                                        </div>
                                  </div><hr>
                                 

                                  <div class="table-responsive">
                                   <div class="col-12">
                                    <table id="zero_config" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Link</th>
                                                <th>Action</th>
                                                <th>Statut</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($Permissions as $Permission)
                                              <tr>
                                                <td>{{$Permission->link}}</td>
                                                <td>{{$Permission->action}}</td>
                                                @if($Permission->etat==0)
                                                <td>Actif</td>
                                                @else
                                                <td>Inactif</td>
                                                @endif
                                                <td></td>
                                              </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
           

                     @endsection                      
@section('content2')
<script type="text/javascript">
  var WindowObjectReference = null; // variable globale
function openSComptesPopUp(va) {
     var id = $(va).val();
     var url = "{{ route('Comptedivisionnaire.show', ":id") }}";
     url = url.replace(':id', id);
  if (WindowObjectReference == null || WindowObjectReference.closed) {
    WindowObjectReference = window.open(url,
           'rating', "width=500,height=250,left=540,top=400,resizable,scrollbars=yes,status=1,menubar=no");
  }
  else {
    WindowObjectReference.focus();
  };
}

function hideSousComptes1() {
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
@endsection