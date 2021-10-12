
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>Liste des Affilés</title>
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

            #LOGO{
               /* width: 15%;
                height: 15%;*/
            }
        </style>
    </head>
    <body class="no-skin">
        <div style="text-align: center;"><img src="{{ ('icons/Entete.png') }}" id="LOGO"></div><hr>
        <h3 style="text-align: center;text-decoration: underline;">LISTE DES AFFILIES ET LEURS NIVEAUX DE COUVERTURE AYANT L'ACCES A {{ $Part->Partenaire }}</h3>
        <table style="font-size: 10px;">
          <thead>
                                         <tr>
                                            <th>CODE.</th>
                                            <th>ADHERANT.</th>
                                            <th>AYANT DROIT.</th>
                                            <th>ORIGINE</th>
                                            <th>SOINS AMBULATOIRE</th>
                                            <th>HOPITAL PLAFOND CHAMBRE</th>
                                            <th>UNITE MATERNITE</th>
                                            <th>PHARMACIE</th>
                                            <th>DENTS</th>
                                            <th>VERRE + MONTURE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       {!! $tableListe !!}
                                       
                                    </tbody>
        </table><br />  
 
     <hr>
     <div style="text-align: center;">{{ $Consomation->Adresse }}
     </div>
    </body>
</html>

