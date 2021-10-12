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
                        <form method="POST" action="{{ route('CompteJournal.store')}}">
                            <div class="modal-body">
            
                                    {{ csrf_field() }}
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input style="display: none;" class="form-control form-white" value="{{ $id }}" type="text" name="Journal" />
                                            {!! $errors->first('Numero', '<span class="error">:message</span>') !!}

            
                                            <label class="control-label">Compte Principal *</label>
                                             <select class="form-control" name="Compte">
                                                @foreach($ComptePrincipal as $CP)
                                                 <option value="{{ $CP->id }}"> {{ $CP->NumeroCompte}} - {{ $CP->Intitule}}</option>
                                                @endforeach 
                                             </select>
                                            {!! $errors->first('Compte', '<span class="error">:message</span>') !!}
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary waves-effect waves-light save-category">Ajouter</button>
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