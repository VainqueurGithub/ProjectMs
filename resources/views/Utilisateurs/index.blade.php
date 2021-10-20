 @extends('layout.base')
 @section('content')
  <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">Utilisateurs</h3>
                <div class="row">
                  <div class="col-md-9"></div>
                  <div class="col-md-3">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#add-new-event" class="btn m-t-20 btn-info btn-block waves-effect waves-light">
                        <i class="ti-plus"></i> Nouvel Utilisateurs
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
                      <th>Nom</th>
                      <th>Email</th>
                      <th>Roles</th>
                      <th>Action</th>
                    </tr>
                 </thead> 
                 <tbody> 
                  @foreach ($Utilisateurs as $key => $user)
                    <tr>
                      <td>{{ $user->id }}</td>
                      <td>{{ $user->name }}</td>
                      <td>{{ $user->email }}</td>
                      <td>
                      @if(!empty($user->getRoleNames()))
                        @foreach($user->getRoleNames() as $v)
                           <label class="badge badge-success">{{ $v }}</label>
                        @endforeach
                      @endif
                      </td>
                      <td>
                         <button style="border: none;cursor: pointer;" target="PromoteFirefoxWindowName" onclick="openFFPromotionPopup(this); return false;" value="{{$user->id}}"><i class="fa fa-eye"></i></button>
                        <a href="{{route('Utilisateurs.edit', $user->id)}}"><i class='fa fa-edit'></i></a> 
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
              <h4 class="modal-title"><strong>Ajouter un nouvel utilisateur</strong></h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
              <form method="POST" action="{{route('Utilisateurs.store')}}">

<div class="row">
   <div class="col-2"></div>
   <div class="col-md-8">
      <div class="form-group">
        <label>Nom *</label>
        <input class="form-control form-white" name="name" value="{{ old('name')}}"/>
        {!! $errors->first('name', '<span class="error">:message</span>') !!}
      </div>

      <div class="form-group">
        <label>Prenom *</label>
        <input class="form-control form-white" name="Prenom" value="{{ old('Prenom')}}" />
        {!! $errors->first('Prenom', '<span class="error">:message</span>') !!}
      </div>

      <div class="form-group">
        <label>Email *</label>
        <input type="email"  class="form-control form-white" name="email" value="{{ old('email')}}" />
        {!! $errors->first('email', '<span class="error">:message</span>') !!}
      </div>

      <div class="form-group">
               <div class="form-group">

            <strong>Role:</strong>

            {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!}

        </div>
      </div>

      <label></label><br>
      <button type="submit" class="btn btn-primary">Enregistrer</button>
    </div>
 </div>
</form>
                        </div>
                    </div>
                </div>
                <!-- END MODAL -->
@endsection

<script type="text/javascript">
    var WindowObjectReference = null; // variable globale
function openFFPromotionPopup(va) {
     var id = $(va).val();
     var url = "{{ route('Utilisateurs.show', ":id") }}";
     url = url.replace(':id', id);
  if (WindowObjectReference == null || WindowObjectReference.closed) {
    WindowObjectReference = window.open(url,
           "PromoteFirefoxWindowName", "toolbar=no,scrollbars=no,location=no,statusbar=no,width=940,height=500,resizable,scrollbars=yes,status=1,menubar=no");
  }
  else {
    WindowObjectReference.focus();
  };
}
</script>