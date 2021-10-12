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
                  <div class="col-md-8"></div>
                  <div class="col-4"><a href="javascript:void(0)" data-toggle="modal" data-target="#add-new-event" class="btn m-t-20 btn-info btn-block waves-effect waves-light">
                                <i class="ti-plus"></i> Nouveau Compte Journal
                            </a></div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">                                           
                                    <table id="example1" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Journal</th>
                                                <th>Compte</th>
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
                        <form method="POST" accept="{{ route('CompteJournal.store')}}">
                            <div class="modal-body">
                               
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-6">
                                             <label class="control-label">Compte *</label>
                                             <select class="form-control select2" name="Compte">
                                                <option></option>
                                                @foreach($ComptePrincipal as $CP)
                                                 <option value="{{ $CP->id }}"> {{ $CP->NumeroCompte}} - {{ $CP->Intitule}}</option>
                                                @endforeach 
                                             </select>
                                            {!! $errors->first('Compte', '<span class="error">:message</span>') !!}
                                        </div>
                                        <div class="col-md-6">
                                         
                                         <label class="control-label">Journal *</label>
                                             <select class="form-control select2" name="Journal">
                                                <option></option>
                                                @foreach($CodeJournaux as $CJ)
                                                 <option value="{{ $CJ->id }}"> {{ $CJ->Code}} - {{ $CJ->Journal}}</option>
                                                @endforeach 
                                             </select>
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