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
                    <a href="{{route('Utilisateurs.index')}}" class="btn m-t-20 btn-info btn-block waves-effect waves-light">
                        <i class="ti-plus"></i> Liste Utilisateurs
                    </a>
                  </div>
                </div>
              </div>

{!! Form::model($user, ['method' => 'PATCH','route' => ['Utilisateurs.update', $user->id]]) !!}

<div class="row">
   <div class="col-2"></div>
   <div class="col-md-8">
      <div class="form-group">
        <strong>Nom:</strong>
        {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control form-white')) !!}
      </div>

      <div class="form-group">
        <label>Prenom *</label>
        {!! Form::text('name', null, array('placeholder' => 'Prenom','class' => 'form-control form-white')) !!}
      </div>

      <div class="form-group">
        <label>Email *</label>
        {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
      </div>

        <div class="form-group">
            <strong>Role:</strong>
            {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','multiple')) !!}
        </div>
      <button type="submit" class="btn btn-primary">Modifier</button><br>
    </div>
 </div>

{!! Form::close() !!}

  </div>
                    </div>

                </div>
            </div>
        </section>
                <!-- END MODAL -->
@endsection