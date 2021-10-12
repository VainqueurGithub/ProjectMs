@extends('layout.base')
@section('content')  
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
        <section class="content">
      <div class="container-fluid">
                                  <div class="row">
                                         <div class="col-12">
                        <form method="POST" action="{{ route('CodeJournaux.update', $CodeJournal->id)}}">
                            <div class="modal-body">
                               {{ csrf_field() }}
                              {{ method_field('PUT') }}

                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="control-label">Code *</label>
                                            <input class="form-control form-white" value="{{$CodeJournal->Code}}" type="text" name="Code" />
                                            {!! $errors->first('Code', '<span class="error">:message</span>') !!}

                                            <label class="control-label">Journal *</label>
                                            <input class="form-control form-white" value="{{$CodeJournal->Journal}}" type="text" name="Journal" />
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
                              </section>
           @endsection