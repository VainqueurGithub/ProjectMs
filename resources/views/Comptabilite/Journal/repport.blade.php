@extends('layout.base')
@section('content')                        
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
            <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                 <div class="row">
                                
                                      <!--div class="col-2"><a target="blank;" href="{{ route('JournalPdf') }}"> <button class="btn btn-info"><i class="fas fa-print"></i> Imprimer Le Journal </button></a></div-->
                                        

                                         <div class="col-12">
                                    <form method="POST" action=" {{route('JournalPdf')}}">  
                                          {{ csrf_field() }}
                                          <div class="row">

                                            <div class="col-4">
                                                 <div class="form-group">
                                                    <label>Compte Principal</label>
                                                    <select class="form-control select2" name="Acount">
                                                       <option></option>
                                                      @foreach($ComptePrincipals as $ComptePrincipal)
                                                       <option value="{{$ComptePrincipal->id}}">{{$ComptePrincipal->NumeroCompte}} -- {{$ComptePrincipal->Intitule}}</option>
                                                       @endforeach
                                                   </select>
                                                 </div>
                                              </div>

                                           <!--  <div class="col-2">
                                                  <div class="form-group">
                                                    <label>Compte</label>
                                                    <select class="form-control" data-control="hue" name="Acount">
                                                      <option></option>
                                                      @foreach($CompteSubdivisionnaires as $ComSubdnaire)
                                                      <option value="{{ $ComSubdnaire->id }}"> {{ $ComSubdnaire->NumeroCompte}} -- {{ $ComSubdnaire->Intitule}}</option>
                                                       @endforeach
                                                    </select>
                                                 </div> 
                                              </div>
 -->
                                             
                                              <div class="col-4">
                                                 <div class="form-group">
                                                    <label>Compte Subdiv.</label>
                                                    <select class="form-control select2" name="SubAcount">
                                                      <option></option>
                                                       @foreach($CompteSubdivisionnaires as $ComSubdnaire)
                                                        <option value="{{ $ComSubdnaire->id }}"> {{ $ComSubdnaire->NumeroCompte}} -- {{ $ComSubdnaire->Intitule}}</option>
                                                       @endforeach
                                                   </select>
                                                 </div>
                                              </div>

                                              <div class="col-4">
                                                 <div class="form-group">
                                                    <label>Sous Compte</label>
                                                    <select class="form-control select2" name="SAcount">
                                                      <option></option>
                                                      @foreach($SComptes as $SCompte)
                                                       <option value="{{$SCompte->id}}">
                                                         {{$SCompte->NumeroCompte}} -- {{$SCompte->Intitule}}
                                                       </option>
                                                      @endforeach
                                                   </select>
                                                 </div>
                                              </div>

                                              <div class="col-2">
                                                 <div class="form-group">
                                                    <label>Code Journal </label>
                                                    <select class="form-control select2" name="Journal">
                                                      <option></option>
                                                      @foreach($CodeJournaux as $CodeJournau)
                                                       <option value="{{$CodeJournau->id}}">{{$CodeJournau->Code}} -- {{$CodeJournau->Intitule}}</option>
                                                      @endforeach 
                                                   </select>
                                                 </div>
                                              </div>


                                              <div class="col-2">
                                                  <div class="form-group">
                                                     <label>Debut</label>
                                                   <input type="date" id="hue-demo" class="form-control" required="required" data-control="hue" name="Debut">
                                                 </div> 
                                              </div>

                                              <div class="col-2">
                                                  <div class="form-group">
                                                     <label>Fin</label>
                                                   <input type="date" required="required" id="hue-demo" class="form-control" data-control="hue" name="Fin">
                                                 </div> 
                                              </div>
                                               <div class="col-2">
                                                  <div class="form-group">
                                                   <button style="margin-top: 30px;" type="submit" name="Rapport" class="form-control btn btn-success">Générer Rapport</button>
                                                 </div> 
                                              </div>
                                          </div>
                                           </form>  
                                        </div>
                                        </div>
                                        </div>
                                        </div>
            </div>
       </div>
      </div><!-- /.container-fluid -->
    </section>
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
                                                                         