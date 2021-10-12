@extends('layout.base')
@section('content')  
   <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">Classes comptable</h3>
                <div class="row">
                  <div class="col-md-9"></div>
                   <div class="col-3"><a href="javascript:void(0)" data-toggle="modal" data-target="#add-new-event" class="btn m-t-20 btn-info btn-block waves-effect waves-light">
                                <i class="ti-plus"></i> Nouveau Journal
                            </a></div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">                      

                                    <table id="example1" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Code</th>
                                                <th>Journal</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          @foreach($CodeJournaux as $CodeJ) 
                                               <tr>
                                                 <td>{{ $CodeJ->id}}</td>
                                                 <td><button style="border: none; cursor: pointer;" value="{{$CodeJ->id}}" target="PromoteFirefoxWindowName" onclick="openFFPromotionPopup(this); return false;">{{ $CodeJ->Code}}</button></td>
                                                 <td>{{ $CodeJ->Journal }}</td>
                                                 <td>
                                                  
                                                   <a href="{{ route('CodeJournaux.edit', $CodeJ->id)}}"><i class='fas fa-edit'></i></a>

                                                <form action="{{route('CodeJournaux.destroy', $CodeJ->id)}}" method='POST' style='display: inline-block;' onsubmit="return confirm('Etez-vous sur de cette Operation ?')">
                                                    {{csrf_field()}}
                                                    {{method_field('DELETE')}}
                                                    <button onclick="return confirm('Etez -vous sur de cette Operation ?')"><i class='fas fa-trash'></i>
                                                    </button>
                                                </form>

                                                <button class="btn btn-danger" target="PromoteFirefoxWindowName" onclick="openFFPromotionPopupSettedAccount(this); return false;" value="{{$CodeJ->id}}"><i class="fas fa-eye"></i> comptes</button>

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
                                <h4 class="modal-title"><strong>Creer un nouveau Journal</strong></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                        <form method="POST" accept="{{ route('CodeJournaux.store')}}">
                            <div class="modal-body">
                               
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="control-label">Code *</label>
                                            <input class="form-control form-white" placeholder="Code" type="text" name="Code" />
                                            {!! $errors->first('Code', '<span class="error">:message</span>') !!}
                                        </div>
                                        <div class="col-md-6">
                                         
                                         <label class="control-label">Journal *</label>
                                            <input class="form-control form-white" placeholder="Journal" type="text" name="Journal" />
                                            {!! $errors->first('Journal', '<span class="error">:message</span>') !!}
                                        
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
  var WindowObjectReference = null; // variable globale
 
function openFFPromotionPopup(va) {
     var id = $(va).val();
     var url = "{{ route('CodeJournaux.show', ":id") }}";
     url = url.replace(':id', id);
  if (WindowObjectReference == null || WindowObjectReference.closed) {
    WindowObjectReference = window.open(url,
           "PromoteFirefoxWindowName", "width=420,height=230,resizable,scrollbars=yes,status=1");
  }
  else {
    WindowObjectReference.focus();
  };
}

function openFFPromotionPopupSettedAccount(va) {
     var id = $(va).val();
     var url = "{{ route('SettedAccountAsJournal', ":id") }}";
     url = url.replace(':id', id);
  if (WindowObjectReference == null || WindowObjectReference.closed) {
    WindowObjectReference = window.open(url,
           "PromoteFirefoxWindowName", "width=420,height=230,resizable,scrollbars=yes,status=1");
  }
  else {
    WindowObjectReference.focus();
  };
}  
</script>                        