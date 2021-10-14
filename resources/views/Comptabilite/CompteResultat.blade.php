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
                                <div class="col-8">
                                    <form method="POST" action=" {{route('ResultatPdf')}}">  
                                          {{ csrf_field() }}
                                          <div class="row">
                    
                                   <div class="col-6">
                                                  <div class="form-group">
                                                    <select class="form-control select2" data-control="hue" name="Exercice" required="">
                                                      @foreach($Exercices as $Exercice)
                                                       <option value="{{ $Exercice->id }}">{{ $Exercice->Debut }} - {{ $Exercice->Fin }}</option>
                                                      @endforeach 
                                                    </select>
                                                 </div> 
                                              </div>
                                              <div class="col-5">
                                                  <button type="submit" class="btn btn-success" name="Rapport">Imprimer</button>
                                              </div>
                                          </div>
                                           </form>  
                                        </div>
                                  </div><hr>

                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                               <th colspan="2">COMPTES</th>
                                               <th>MONTANT</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <!-- AFFICHAGE DE PRODUIT FINANCIER  -->
                                          @foreach($ComptesResultats as $Comp)
                                            @if($Comp->Class==7 && $Comp->Appartenance=='financier') 
                                              <tr style="background-color:white;">
                                                <td colspan="2">{{$Comp->NumeroCompte}} {{$Comp->Intitule}}</td>
                                              
                                                <td><?php echo number_format($Comp->MD - $Comp->MC,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')?></td>
                                              </tr>
                                            @endif
                                           @endforeach
                                          <tr style="background-color: lightskyblue; font-weight: bold;">
                                            <td colspan="2">
                                                PRODUITS FINANCIERS
                                            </td>
                                            <td>
                                              <?php echo number_format($SOLDEPF,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')?>
                                            </td>
                                          </tr>
                                          <!-- FIN  AFFICHAGE DE PRODUIT FINANCIER -->



                                          <!-- AFFICHAGE DE CHARGES FINANCIER -->
                                           @foreach($ComptesResultats as $Comp)
                                            @if($Comp->Class==6 && $Comp->Appartenance=='financier') 
                                              <tr style="background-color:white;">
                                                <td colspan="2">{{$Comp->NumeroCompte}} {{$Comp->Intitule}}</td>
                                              
                                                <td><?php echo number_format($Comp->MD - $Comp->MC,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')?></td>
                                              </tr>
                                            @endif
                                           @endforeach
                                           
                                           <tr style="background-color: lightskyblue; font-weight: bold;">
                                            <td colspan="2">
                                                CHARGES FINANCIERS
                                            </td>
                                            <td>
                                              <?php echo number_format($SOLDECF,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')?>
                                            </td>
                                          </tr>
                                          <!-- FIN AFFICHAGE DE PRODUITS D'EXPLOITATION -->

                                          <!-- RESULTAT D'EXPLOITATION -->
                                           <tr style="background-color: black; color: white;font-weight: bolder;">
                                            <td colspan="2">
                                                RESULTAT FINANCIER
                                            </td>
                                            <td colspan="2">
                                              <?php echo number_format($SOLDEPF-$SOLDECF,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')?>
                                            </td>
                                          </tr>
                                         <!-- FIN RESULTAT FINANCIER -->

                                         

                                      <!-- AFFICHAGE DE PRODUIT EXPLOITATION  -->
                                          @foreach($ComptesResultats as $Comp)
                                            @if($Comp->Class==7 && $Comp->Appartenance=='exploitation') 
                                              <tr style="background-color:white;">
                                                <td colspan="2">{{$Comp->NumeroCompte}} {{$Comp->Intitule}}</td>
                                              
                                                <td><?php echo number_format($Comp->MD - $Comp->MC,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')?></td>
                                              </tr>
                                            @endif
                                           @endforeach
                                          <tr style="background-color: lightskyblue; font-weight: bold;">
                                            <td colspan="2">
                                                PRODUITS D'EXPLOITATION
                                            </td>
                                            <td>
                                              <?php echo number_format($SOLDEPE,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')?>
                                            </td>
                                          </tr>
                                          <!-- FIN  AFFICHAGE DE PRODUIT EXPLOITATION -->



                                          <!-- AFFICHAGE DE CHARGES EXPLOITATION -->
                                           @foreach($ComptesResultats as $Comp)
                                            @if($Comp->Class==6 && $Comp->Appartenance=='exploitation') 
                                              <tr style="background-color:white;">
                                                <td colspan="2">{{$Comp->NumeroCompte}} {{$Comp->Intitule}}</td>
                                              
                                                <td><?php echo number_format($Comp->MD - $Comp->MC,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')?></td>
                                              </tr>
                                            @endif
                                           @endforeach
                                           
                                           <tr style="background-color: lightskyblue; font-weight: bold;">
                                            <td colspan="2">
                                                CHARGES D'EXPLOITATION
                                            </td>
                                            <td>
                                              <?php echo number_format($SOLDECE,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')?>
                                            </td>
                                          </tr>
                                          <!-- FIN AFFICHAGE DE PRODUITS D'EXPLOITATION -->

                                          <!-- RESULTAT D'EXPLOITATION -->
                                           <tr style="background-color: black; color: white;font-weight: bolder;">
                                            <td colspan="2">
                                                RESULTAT EXPLOITATION
                                            </td>
                                            <td>
                                              <?php echo number_format($SOLDEPE-$SOLDECE,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')?>
                                            </td>
                                          </tr>
                                         <!-- FIN RESULTAT EXPLOITATION -->



                                            <!-- AFFICHAGE DE PRODUIT EXCEPTIONNEL  -->
                                          @foreach($ComptesResultats as $Comp)
                                            @if($Comp->Class==7 && $Comp->Appartenance=='exceptionnel') 
                                              <tr style="background-color:white;">
                                                <td colspan="2">{{$Comp->NumeroCompte}} {{$Comp->Intitule}}</td>
                                              
                                                <td><?php echo number_format($Comp->MD - $Comp->MC,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')?></td>
                                              </tr>
                                            @endif
                                           @endforeach
                                          <tr style="background-color: lightskyblue; font-weight: bold;">
                                            <td colspan="2">
                                                PRODUITS EXCEPTIONNEL
                                            </td>
                                            <td>
                                              <?php echo number_format($SOLDEPEX,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')?>
                                            </td>
                                          </tr>
                                          <!-- FIN  AFFICHAGE DE PRODUIT EXCEPTIONNEL -->



                                          <!-- AFFICHAGE DE CHARGES EXCEPTIONNEL -->
                                           @foreach($ComptesResultats as $Comp)
                                            @if($Comp->Class==6 && $Comp->Appartenance=='exceptionnel') 
                                              <tr style="background-color:white;">
                                                <td colspan="2">{{$Comp->NumeroCompte}} {{$Comp->Intitule}}</td>
                                              
                                                <td><?php echo number_format($Comp->MD - $Comp->MC,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')?></td>
                                              </tr>
                                            @endif
                                           @endforeach
                                           
                                           <tr style="background-color: lightskyblue; font-weight: bold;">
                                            <td colspan="2">
                                                CHARGES D'EXCEPTIONNEL
                                            </td>
                                            <td>
                                              <?php echo number_format($SOLDECEX,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')?>
                                            </td>
                                          </tr>
                                          <!-- FIN AFFICHAGE DE PRODUITS EXCEPTIONNEL -->

                                          <!-- RESULTAT EXCEPTIONNEL -->
                                           <tr style="background-color: black; color: white;font-weight: bolder;">
                                            <td colspan="2">
                                                RESULTAT EXCEPTIONNEL
                                            </td>
                                            <td>
                                              <?php echo number_format($SOLDEPEX-$SOLDECEX,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')?>
                                            </td>
                                          </tr>
                                         <!-- FIN RESULTAT EXCEPTIONNEL -->


                                          <!-- RESULTAT DE LA PERIODE -->
                                           <tr style="background-color: black; color: white;font-weight: bolder;">
                                            <td colspan="2">
                                                RESULTAT DE LA PERIODE
                                            </td>
                                            <td>
                                              <?php echo number_format($RESULTAT,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')?>
                                            </td>
                                          </tr>
                                         <!-- RESULTAT DE LA PERIODE -->
                                        </tbody>
                                    </table>
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