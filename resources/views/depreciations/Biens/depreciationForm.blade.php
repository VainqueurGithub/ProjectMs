@extends('layout.base')
@section('content')                        
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
            <div class="row">
            
                <div class="col-12">
                                    <form method="POST" action=" {{route('depreciationForm')}}">  
                                          {{ csrf_field() }}
                                          <div class="row">

                                            <div class="col-4">
                                                 <div class="form-group">
                                                    <label>Type de Bien</label>
                                                    <select class="form-control select2" name="Type">
                                                       <option></option>
                                                      @foreach($Types as $Type)
                                                       <option value="{{$Type->id}}">{{$Type->Type}}</option>
                                                       @endforeach
                                                   </select>
                                                 </div>
                                              </div>


                                              <div class="col-6">
                                                  <div class="form-group">
                                                     <label>Exercice Comptable</label>
                                                     <select class="form-control select2" name="Exercice" required="required">
                                                        @foreach($ExerciceComptables as $ExerciceComptable)
                                                         <option value="{{$ExerciceComptable->id}}">{{$ExerciceComptable->Debut}} -- {{$ExerciceComptable->Fin}}</option>
                                                        @endforeach 
                                                     </select>
                                              </div>
                                          </div>

                                               <div class="col-2">
                                                  <div class="form-group">
                                                   <button style="margin-top: 30px;" type="submit" name="Rapport" class="form-control btn btn-success">Rechercher</button>
                                                 </div> 
                                              </div>
                                          </div>
                                           </form>  
                                        </div>




                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                 <div class="row">
                                   <div class="col-12">

                                    <div class="card-body">
                <table class="table table-striped">
                  <thead>
                  <tr>                
                                            <th>Nom</th>
                                            <th>Année</th>
                                            <th>Montant</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     @foreach($Depreciations as $Depreciation)
                                         <tr class="odd gradeX">
                                            <td>{{ $Depreciation->Nom }}</td>
                                            <td>{{ $Depreciation->Annee }}</td>
                                            <td>{{ $Depreciation->Montant }}</td>
                                         </tr> 
                                    @endforeach  
                                    </tbody>
                                    <tfoot style="font-weight: bolder;">
                                         <tr>
                                        <td colspan="2">TOTAL DOTATION</td>
                                        <td>{{$Total}}</td>
                                    </tr> 
                                    </tfoot>
                                </table>
                            </div>
 
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
                                                                         