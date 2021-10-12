
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

            #LOGO{
                width: 50%;
                height: 50%;
            }
        </style>
    </head>
    <body class="no-skin">
            <div style="text-align: center;"><img src="{{ ('icons/Entete.png') }}" id="LOGO"></div>
        <hr>
        <div style="text-align: left;font-size:10px;font-weight: bold;font-family:Arial Narrow;">
            <p>Partenaire : {{ $Partenaire->Partenaire }}</p>
            <p>Adherant Principal : {{ $Affilier->Code }} - {{ $Affilier->Nom }} {{ $Affilier->Prenom }}</p>
            <p>Origine : {{ $Origine->Origine }}</p>
            <p>Beneficiaire : {{ $Beneficiaire->Nom }} {{ $Beneficiaire->Prenom }} ({{ $Beneficiaire->Lien }})</p>
            <p>Date de Traitement : {{ $Fact->DateTraitement }}</p>
            @if($Service->Traitement ==3)
            <p>Type de Traitement subi(e) : MATERNITE </p>
            @elseif($Service->Traitement == 2)
            <p>Type de Traitement subi(e) : HOSPITALISATION </p>
            @elseif($Service->Traitement == 1)
            <p>Type de Traitement subi(e) : CONSULTATION </p>
            @elseif($Service->Traitement == 4)
            <p>Type de Traitement subi(e) : SOINS AMBULATOIRE AVEC MÉDICAMENTS </p>
            @elseif($Service->Traitement == 5)
            <p>Type de Traitement subi(e) : SOINS AMBULATOIRE AVEC LUNETTE</p>
            @elseif($Service->Traitement == 6)
            <p>Type de Traitement subi(e) : DENTISTERIE </p>
            @elseif($Service->Traitement == 7)
            <p>Type de Traitement subi(e) : LABORATOIRE </p>
            @elseif($Service->Traitement == 8)
            <p>Type de Traitement subi(e) : KINESITHERAPIE </p>
            @elseif($Service->Traitement == 9)
            <p>Type de Traitement subi(e) : REANIMATION </p>
            @elseif($Service->Traitement == 10)
            <p>Type de Traitement subi(e) : IMAGERIE MEDICALE </p>
            @endif
        </div>

        <h3 style="text-align: center;">Facture N° : {{$Fact->NumFacture}}/{{$Fact->AnneeT}}</h3>
        <table>
          <thead>
                                         <tr>
                                            <th>Libellé</th>
                                            <th>P.U</th>
                                            <th>Quantité</th>
                                            <th>P.T</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       {!! $tableListe !!}
                                       
                                    </tbody>
        </table>
        <hr>
        <p style="text-align: right;font-weight: bold;font-family:Arial Narrow;font-size:13px;">
            Comptant : {{ $ComptantAffilier }} FBU<br />
            SAAT : {{ $SAAT }} FBU<br />
            Total : {{ $Montant}} FBU
        </p>

         <div style="font-size: 12px;font-weight: bold;">
             <span>Nom et Signature du Soignant</span> <span style="margin-left: 160px;">Nom et Signature du L'affilié</span>
         </div> <br /><br /><br /><br /><br />
        
        <hr>
     <div style="text-align: center;font-size:10px;">{{ $Consomation->Adresse }}
     </div>      
    </body>
</html>

