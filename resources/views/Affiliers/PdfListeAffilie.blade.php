
<!DOCTYPE html>
<html lang="en">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        
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
                /*width: 15%;
                height: 15%;*/
            }
        </style>
    </head>
    <body class="no-skin">
         <div style="text-align: center;"><img src="{{ ('icons/Entete.png') }}" id="LOGO"></div><hr>
        <h3 style="text-align: center;text-decoration: underline;">LISTE DES AFFILIES AYANT COMME ORIGINE {{ $Origine->Origine }}</h3>
        <table>
          <thead>
                                         <tr>
                                            <th>CODE.</th>
                                            <th>ADHERANT.</th>
                                            <th>AYANTS DROITS</th>
                                            <th>ADRESSE</th>
                                            <th>DATE NAISSANCE</th>
                                            <th>ORIGINE</th>
                                            <th>DATE ENTREE</th>
                                            <th>COT. MENSUELLE</th>
                                            <th>S.A</th>
                                            <th>HOPITAL PLAFOND CHAMBRE</th>
                                            <th>UNITE MATERNITE</th>
                                            <th>PHARMACIE</th>
                                        </tr>
                                         
                                    </thead>
                                    <tbody>
                                       {!! $tableListe !!}
                                       <tr>
                                          <th>{{ $NbreAff }}</th>
                                          <th>{{ $NbreAff }}</th>
                                          <th>{{ $NbreAD }}</th>
                                          <th></th>
                                          <th></th>
                                          <th></th>
                                          <th></th>
                                          <th>{{ $SommeOrigine }}</th>
                                          <th></th>
                                          <th></th>
                                          <th></th>
                                          <th></th>
                                        </tr>
                                    </tbody>
                                  
         </table><br />  
 
     <hr>
     <div style="text-align: center;">{{ $Consomation->Adresse }}
     </div>      
    </body>
</html>

