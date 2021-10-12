
<!DOCTYPE html>
<html lang="en">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        
        <title>Ventillation - General</title>
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
        <h3 style="text-align: center;"></h3>
        <table>
          <thead>
                                        <tr>
                                            <th>#</th>
                                            
                                            <th>PROPRIETE</th>
                                            <th>ENREGISTRER LE:</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                       {!! $tableListe !!}
                                       
                                    </tbody>
        </table> 
          <hr>
       <div style="text-align: center;font-size:10px;">{{ $Consomation->Adresse }}
     </div>        
    </body>
</html>

