@extends('layout.base')
@section('content')  
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title"></h4>
                        <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Library</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
          
            <div class="container-fluid">
                <div class="container-fluid">
                
                        <div class="card">
                            <div class="card-body">
                        <form method="POST" action="{{ route('CompteJournal.update', $CompteJournal->id)}}">
                            <div class="modal-body">
            
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <div class="row">
                                        <div class="col-md-12">
                                        <label class="control-label">Compte *</label>
                                             <select class="form-control" name="Compte">
                                                <option value="{{$Compte->id}}">{{ $Compte->NumeroCompte}} - {{$Compte->Intitule}}</option>
                                                @foreach($Comptes as $Compte)
                                                 <option value="{{ $Compte->id }}"> {{ $Compte->NumeroCompte}} - {{ $Compte->Intitule}}</option>
                                                @endforeach 
                                             </select>
                                            {!! $errors->first('Compte', '<span class="error">:message</span>') !!}

                                            <label class="control-label">Journal *</label>
                                             <select class="form-control" name="Journal">
                                                <option value="{{$CodeJournal->id}}">{{ $CodeJournal->Code}} - {{$CodeJournal->Journal}}</option>
                                                @foreach($CodeJournaux as $CodeJ)
                                                 <option value="{{ $CodeJ->id }}"> {{ $CodeJ->Code}} - {{ $CodeJ->Journal}}</option>
                                                @endforeach 
                                             </select>
                                            {!! $errors->first('Journal', '<span class="error">:message</span>') !!}
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary waves-effect waves-light save-category">Modifier</button>
                                <button type="reset" class="btn btn-secondary waves-effect" data-dismiss="modal">Annuler</button>
                            </div>
                           </form>
                               </div>
                               </div>
                               
                        </div>
                        </div>

                    </div>
                   
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
           @endsection