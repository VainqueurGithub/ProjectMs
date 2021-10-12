                             @extends('layout.base')
@section('content')
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="card">
              <div class="card-body"> 
                                    <table id="zero_config" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>N° des comptes</th>
                                                <th>Date Operation</th>
                                                <th>Transferer Au</th>
                                                <th>Montants</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($Soldes as $Solde)
                                              <tr>
                                                <td>{{$Solde->NumeroCompte}}{{$Solde->Isc}}</td>
                                                <td>{{$Solde->dateOperation}}</td>
                                                <td>{{$Solde->repporterAu}}</td>
                                                <td><?php echo number_format($Solde->montant,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')?></td>
                                                <td>
                                                    <form action="{{route('SoldeJour.destroy', $Solde->id)}}" method='POST' style='display: inline-block;' onsubmit="return confirm('Etez-vous sur de cette Operation ?')">
                                                {{ csrf_field()}}
                                                {{method_field('DELETE')}}
                    
                                                <button onclick="return confirm('Etez -vous sur de cette Operation ?')"><i class='fas fa-trash'></i>
                                                </button>
                                               </form>
                                                </td>
                                              </tr>
                                            @endforeach
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