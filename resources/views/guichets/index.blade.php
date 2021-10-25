@extends('layout.base', ['title' => 'Assurance - Guichets'])

@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <form method="POST" action=" {{route('guichet.store')}}" name="P_form">  
            {{ csrf_field() }}
              <div class="row">
                <div class="col-9">
                  <div class="row">
                    <input type="text" name="sc_compte1" id="sc_compte1" style="display: none;">
                    <input type="text" name="Csubdiv1" id="Csubdiv1" style="display: none;">

                    <div class="col-5">
                      <div class="form-group">
                        <label>Guichet.</label>
                        <select class="form-control select2" name="guichet" target="PromoteFirefoxWindowName" onchange="openSComptesPopUp(this); return false;">
                          <option></option>
                          @foreach($CompteSubdivisionnaires as $CompteSubdivisionnaire)
                          <option value="{{ $CompteSubdivisionnaire->id }}"> {{ $CompteSubdivisionnaire->NumeroCompte}} -- {{ $CompteSubdivisionnaire->Intitule}}</option>
                          @endforeach
                        </select>
                      </div>
                      {!! $errors->first('CD', '<span class="error">:message</span>') !!}
                    </div>


                    <div class="col-4" id="sccomte_int1" style="display: none;">
                      <div class="form-group">
                        <label>Sous Compte.</label>
                          <div class="form-inline">
                            <input type="text" name="sccomte_int1" class="form-control" style="border: none;width:80%;" readonly=""><span target="PromoteFirefoxWindowName" onclick="hideSousComptes(); return false;" style="cursor: pointer;"><i class="fas fa-trash"></i></span>
                          </div>
                        </div>
                    </div>

                    <div class="col-5">
                      <div class="form-group">
                        <label>Guichetier  *</label>
                        <select class="form-control select2" name="user">
                          <option></option>
                          @foreach($Users as $User)
                          <option value="{{ $User->id }}"> {{ $User->name}}</option>
                          @endforeach
                        </select>
                      </div>
                      {!! $errors->first('user', '<span class="error">:message</span>') !!}
                    </div>

                    <div class="col-2">
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





      </div><!-- /.container-fluid -->
    </section><hr />
 <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste des Guichets</h3>
                <div class="row">
                  <div class="col-md-9"></div>
                  <div class="col-md-3">
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-striped">
                  <thead>
                  <tr>
                    <th>Compte Parent</th>
                    <th>Compte enfant</th>
                    <th>Guichetier</th>
                    <th>Action</th>
                  </tr>
                 </thead>
                 <tbody>
                                    
                @foreach ($guichets as $guichet)
                                        
                  <tr class="odd gradeX">
                    <td>{{ $guichet->csubd }}</td>
                    <td>{{ $guichet->scompte }}</td>
                    <td>{{ $guichet->name }}</td>
                    <td>
                      <button data-toggle="modal" data-target="#modal-default"  value="{{$guichet->id}}" style="border: none; cursor: pointer;">
                        <i class="fa fa-edit"></i>
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