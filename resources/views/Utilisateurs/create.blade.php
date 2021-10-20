@extends('layout.base')


@section('content')

<div class="row">

    <div class="col-lg-12 margin-tb">

        <div class="pull-left">

            <h2>Create New User</h2>

        </div>

        <div class="pull-right">

            <a class="btn btn-primary" href="{{ route('Utilisateurs.index') }}"> Back</a>

        </div>

    </div>

</div>


@if (count($errors) > 0)

  <div class="alert alert-danger">

    <strong>Whoops!</strong> There were some problems with your input.<br><br>

    <ul>

       @foreach ($errors->all() as $error)

         <li>{{ $error }}</li>

       @endforeach

    </ul>

  </div>

@endif



<form method="POST" action="{{route('Utilisateurs.store')}}">

 <div class="row">
   <div class="col-md-3"></div>
   <div class="col-md-6">
      <div class="form-group">
        <label>Nom *</label>
        <input class="form-control" name="name" value="{{ old('name')}}"/>
        {!! $errors->first('name', '<span class="error">:message</span>') !!}
      </div>

      <div class="form-group">
        <label>Prenom *</label>
        <input class="form-control" name="Prenom" value="{{ old('Prenom')}}" />
        {!! $errors->first('Prenom', '<span class="error">:message</span>') !!}
      </div>

      <div class="form-group">
        <label>Email *</label>
        <input type="email"  class="form-control" name="email" value="{{ old('email')}}" />
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
@endsection






