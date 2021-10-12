
<!DOCTYPE html>
<html lang="en">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        
        <title>Ventillation - Groupe</title>
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
        </style>
    </head>
    <body class="no-skin">
        <div style="text-align: center;"><img src="{{ ('icons/Entete.png') }}" id="LOGO"></div><hr>
        <h3 style="text-align: center;">VENTILLATION PAR INDIVIDU /{{ $Individu->Nom }} {{ $Individu->Prenom }}</h3>
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>DATE</th>
              <th>ADHERANT</th>
              <th>AYANT DROIT</th>
              <th>ORIGINE</th>
              <th>DATE ENTREE</th>
              <th>COT. MENSUELLE</th>
              <th>T.COTISATION</th>
              <th>T.FACTURE</th>
              <th>PARTENAIRE</th>
              <th>ECART</th>
            </tr>
          </thead>
          <tbody>
          {!! $tableListe !!}
          </tbody>
          <tfoot>
          @foreach($Somme as $S)
            <tr>
              <th colspan="7" style="text-align: center;">SOLDE</th>
              
              <th style="text-align: center;">{{ $SumCot }}</th>
              <th style="text-align: center;">{{ $SumFact }}</th>
              <th style="text-align: center;"></th>
              <th style="text-align: center;">{{ $Ecart }}</th>
            </tr>
             @endforeach
            </tfoot>
        </table>
         <hr>
       <div style="text-align: center;font-size:10px;">{{ $Consomation->Adresse }}
     </div>          
    </body>
</html>

