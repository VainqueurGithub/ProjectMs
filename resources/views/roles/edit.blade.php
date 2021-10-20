 @extends('layout.base')
 @section('content')
  <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="card" style="padding: 10px;">
              <div class="card-header">
                <h3 class="card-title">Roles</h3>
                <div class="row">
                  <div class="col-md-9"></div>
                  <div class="col-md-3">
                    <a href="{{route('roles.index')}}" class="btn m-t-20 btn-info btn-block waves-effect waves-light">
                        <i class="ti-plus"></i> Liste des roles
                    </a>
                  </div>
                </div>
              </div>

            {!! Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id]]) !!}
            <div class="row" style="">
                <div class="col-2"></div>
                <div class="col-md-8">
                    <div class="form-group">
                      <label>Nom *</label>
                      {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                    </div>
       
                    <strong>Permission:</strong>
                     </div>
                  </div>

                  <div class="row">
                            @foreach ($permission as $key => $value)
                            <div class="col-md-4">
                                {{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'form-check-input')) }}{{$value->name}}
                            </div>
                            @endforeach
                    
                  </div>
                        
                    <label></label><br>
                     <button type="submit" class="btn btn-primary">Modifier</button>
               
           {!! Form::close() !!}
            </div>
                    </div>

                </div>
            </div>
        </section>
@endsection