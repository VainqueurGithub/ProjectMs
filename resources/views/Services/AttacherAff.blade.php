@extends('layout.base', ['title' => 'Assurance - Nouveau Service'])
@section('content')
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
        <h2 style="color: blue;font-weight: bold;text-align: center;">Nouveau Service</h2>
        </div>
                </div>
                 <!-- /. ROW  -->
                 <hr />
               <div class="row">
                <div class="col-md-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Ajout d'un Service
                             <a href="{{ route('Services.index') }}" style="text-decoration: none;color: white">
                             <div class="btn btn-info pull-right"  style="margin-top: -5px">
                            <i class="fa fa-book"></i> Nos Services
                            </a>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <form role="form" method="POST" action="{{ route('AttacherAffStore')}}">
                                      {{ csrf_field() }}

        <div class="form-group" style="display: none;">
         <label></label>
           <input type="" name="Service" value="{{ $Service}}">
          {!! $errors->first('Service', '<span class="error">:message</span>') !!}
        </div>

        <div class="form-group">
         <label>Affilié</label>
         <select class="form-control" name="Affilier">
            <option> </option>
            @foreach($Affiliers as $Aff)
             <option value="{{$Aff->id}}">{{ $Aff->Code}}/ {{$Aff->Nom}} {{$Aff->Prenom}}</option>
            @endforeach 
         </select>
          {!! $errors->first('Affilier', '<span class="error">:message</span>') !!}
        </div>

        <div class="form-group">
         <label>Origine</label>
         <select class="form-control" name="Origine">
            <option> </option>
            @foreach($Origines as $Orig)
             <option value="{{$Orig->id}}">{{ $Orig->Origine}}</option>
            @endforeach 
         </select>
          {!! $errors->first('Couverture', '<span class="error">:message</span>') !!}
        </div>
                                        
        <label></label><br>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <button type="reset" class="btn btn-default">Annuler</button>

        </form>
    <br />                    
    </div>

                            </div>
                        </div>
                    </div>
                     <!-- End Form Elements -->
                </div>
            </div>


                     <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Liste des Services
                               <a href="{{ route('Services.index') }}" style="text-decoration: none;color: white">
                             <div class="btn btn-info pull-right"  style="margin-top: -5px">
                            <i class="fa fa-book"></i> Nos Services
                            </a>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                          <th>Code</th>
                                          <th>Nom</th>
                                            <th>Prenom</th>
                                          <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {!! $tableListe !!}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
               
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
@endsection 
