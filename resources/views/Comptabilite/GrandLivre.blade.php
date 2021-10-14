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
                        <form method="POST" action="{{ route('AfficherGdLivre')}}">
                              {{ csrf_field() }}
                            <div class="row">
                              <div class="col-3"></div>
                                <div class="col-6">
                                    <div class="form-group">
                                       <label for="hue-demo">Type Grand Livre</label>
                                        <select class="form-control select2" name="TypeCompte" required="">
                                          <option></option>
                                          <option value="Tous">Tous</option>
                                            @foreach($Types as $Type)
                                               <option value="{{ $Type->id }}">{{ $Type->Types }}</option>
                                            @endforeach
                                        </select>
                                    </div> 


                                    <!--  <div class="form-group">
                                       <label for="hue-demo">Compte</label>
                                        <select class="form-control">
                                           <option>Tous</option>
                                           @foreach($Comptes as $Compte)
                                            <option value="{{ $Compte->id }}"> {{ $Compte->NumeroCompte }} ** {{ $Compte->Intitule }} </option>
                                           @endforeach 
                                         </select>
                                    </div>  -->

                                    <div class="form-group">
                                        <label for="position-bottom-left">Du </label>
                                        <input type="date" class="form-control" name="Debut" value="{{ session()->get('ExerciceComptableDebut')}}" required="">
                                    </div>

                                    <div class="form-group">
                                        <label for="position-bottom-left">Au </label>
                                        <input type="date" class="form-control" name="Fin" value="{{ session()->get('ExerciceComptableFin')}}" required="">
                                    </div>
                               
                                  <!--  <div class="form-group">
                                        <label for="position-bottom-left">à </label>
                                        <select id="position-bottom-left" class="form-control" data-position="bottom left" name="Scompte">
                                          <option>Tous</option>
                                          @foreach($SComptes as $SCompte)
                                            <option value="{{ $SCompte->id }}"> {{ $SCompte->NumeroCompte }} ** {{ $SCompte->Intitule }} </option>
                                          @endforeach 
                                        </select>

                                        {!! $errors->first('Responsable', '<span class="error">:message</span>') !!}
                                    </div> -->
                              </div>

                              <div class="col-3">
                                 <div class="border-top">
                                <div class="card-body">
                                    <button type="submit" name="Afficher" class="btn btn-success"><i class="fas fa-eye"></i> Afficher</button><br /><br />
                                    <button type="submit" name="Imprimer" class="btn btn-primary"><i class="fas fa-print"> </i>Imprimer</button> <br /><br />
                                </div>
                               </div>
                              </div>
                               
                               </div> 

                               

                                </form>
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