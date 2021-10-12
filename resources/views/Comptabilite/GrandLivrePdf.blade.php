
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
          <p>Tél <span>{{session()->get('Telephone')}}</span></p>
          <p>Adresse: <span>{{session()->get('Adresse')}}</span></p>
          <p>Banque: <span>{{session()->get('BqnomUn')}}({{session()->get('BqnumUn')}}), {{session()->get('BqnomDeux')}}({{session()->get('BqnumDeux')}})</span></p>
        </div>   
      <h3 style="text-align: center;">COMPTABILITE / GRAND LIVRE</h3>
     <div style="font-weight:bold;">
        Exercice : {{$ExerciceComptab->Debut}} - {{$ExerciceComptab->Fin}}
       </div>
      <hr>
        
          <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Libellé</th>
                                                <th>Débit</th>
                                                <th>Crédit</th>
                                            </tr>
                                        </thead>
                                       
                                            {!! $tableListe !!}
                                       
           </table>

          <div>
          </div>
          <div class="footer-wrapper"><img src="{{ session()->get('Footerfile') }}" id="LOGO1"></div>
    </body>
</html>

