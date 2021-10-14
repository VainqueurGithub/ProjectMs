
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
          
            .header-wrapper{
            text-align: center;
            margin: 30px 0 45px 0;
        }
        </style>
    </head>
    <body class="no-skin">
      <button><a href="{{route('Bilan')}}">Retour</a></button>
           <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr style="text-align: center;">
                                                <th rowspan="2">Date</th>
                                                <th rowspan="2">N° d'ordre</th>
                                                <th colspan="2">N° des comptes</th>
                                                <th rowspan="2">Intitulé</th>
                                                <th rowspan="2">Libellé</th>
                                                <th colspan="2">Montants</th>
                                            </tr>

                                            <tr>
                                                <th>D</th>
                                                <th>C</th>
                                                <th>Débit</th>
                                                <th>Crédit</th>
                                            </tr>

                                        </thead>
                                        <tbody>
                                             <tr style="background-color: silver;">
                                                <td></td>
                                              <!--   <td></td>
                                                <td></td>
                                                <td></td> -->
                                              @if($type_mvt==1)
                                                <td colspan="5">REPPORTAGE</td>
                                                <td>{{ $Reports}}</td>
                                                <td></td>
                                              @else
                                                <td colspan="5">REPPORTAGE</td>
                                                <td></td>
                                                <td>{{ $Reports}}</td>
                                              @endif
                                             </tr> 
                                            {!! $tableListe !!}
                                        </tbody>
                                        <tfoot>
                                             <tr style="background-color: silver;">
                                                <td></td>
                                              <!--   <td></td>
                                                <td></td>
                                                <td></td> -->
                                                <td colspan="5">TOTAL</td>
                                                <td>{{ $MD }}</td>
                                                <td>{{ $MC }}</td>
                                              
                                             </tr> 

                                             <tr style="background-color: silver;">
                                                <td></td>
                                              <!--   <td></td>
                                                <td></td>
                                                <td></td> -->
                                                <td colspan="5">TOTAL GENERAL</td>
                                                <td colspan="2">{{ $SOLDE }}</td>
                                             </tr> 
                                        </tfoot>
                                    </table>

          <div>
          </div>
    </body>
</html>

