
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>Facture - Affilier</title>
        <link rel="icon" type="image/x-icon" href="images/LOGO ELICOM BURUNDI.jpg"/>

         <style type="text/css">
            td, th{
             border:1px solid black;
             text-align: center;
            }
            table{
                width: 100%;
                border-collapse: collapse;
            }

            .container{
            position: relative;
           }
           .numeroproformat{
              text-align: center; 
              font-weight: bold;
              top: 0;
           }
           
             #LOGO{
                width:100%;
                height:120%;
                margin-top: -40px;
                margin-left:0px;
                display: block;
            }
            .header-wrapper{
            text-align: center;
            margin: 30px 0 45px 0;
        }
        #LOGO1{
                width:100%;
                height:120%;
            }
        .footer-wrapper{
            position: absolute;
            bottom: 0;
            text-align: center;
        }    
        </style>
    </head>
    <body class="no-skin">
      <div class="header-wrapper"><img src="{{ session()->get('Headerfile') }}" id="LOGO"></div>
         
        <div style="font-size:10px; font-weight: bold; font-family: arial; width:50%;">
          <p>Raison Social: <span>{{session()->get('Nom_Societe')}}</span></p>
          <p>NIF: <span>{{session()->get('Nif')}}</span></p>
          <p>Email: <span>{{session()->get('email')}}</span></p>
          <p>Tél: <span>{{session()->get('Telephone')}}</span></p>
          <p>Adresse: <span>{{session()->get('Adresse')}}</span></p>
          <p>Banque: <span>{{session()->get('BqnomUn')}}({{session()->get('BqnumUn')}}), {{session()->get('BqnomDeux')}}({{session()->get('BqnumDeux')}})</span></p>
        </div>   
      <h3 style="text-align: center;">COMPTABILITE / RESULTAT DE LA PERIODE</h3>
      <div style="font-weight:bold;">
        EXERCICE : {{$PERIODE->Debut}} - {{$PERIODE->Fin}}</div>
      <hr>
        
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

          <div>
          </div>
          <div class="footer-wrapper"><img src="{{url(session()->get('Footerfile'))}}" id="LOGO1"></div>
    </body>
</html>

