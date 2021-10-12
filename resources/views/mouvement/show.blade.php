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
         <hr>
         <table>
         <thead>
           <tr>
             <th>CODE</th>
             <th>NOM</th>
             <th>PRENOM</th>
           </tr>
         </thead>
         <tbody>
          @foreach($beneficiaires as $beneficiaire)
           <tr>
             <td>{{$beneficiaire->Code}}</td>
             <td>{{$beneficiaire->Nom}}</td>
             <td>{{$beneficiaire->Prenom}}</td>
           </tr>
           @endforeach
         </tbody>
     </table>
    </body>
</html>

