
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
        <div class="footer-wrapper"><img src="{{url(session()->get('Headerfile'))}}" id="LOGO"></div><hr>
        <h3 style="text-align: center;">VENTILLATION GENERAL DU {{ $Debut }} AU {{ $Fin }}</h3>
        <table>
          <thead>
                                        <tr>
                                            <th>CODE</th>
                                            <th>ADHERANT</th>
                                            <th>A.D</th>
                                            <th>JAN.</th>
                                            <th>FEV.</th>
                                            <th>MARS</th>
                                            <th>AVRIL</th>
                                            <th>MAI</th>
                                            <th>JUIN</th>
                                            <th>JUILLE</th>
                                            <th>AOUT</th>
                                            <th>SEPT.</th>
                                            <th>OCTO.</th>
                                            <th>NOV.</th>
                                            <th>DEC.</th>
                                            <th>T.COT.</th>
                                            <th>T.FACT.</th>
                                            <th>ECART</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       {!! $tableListe !!}
                                       
                                    </tbody>
                                    <tfoot>
                                        @foreach($Somme as $S)
                                        <tr>
                                           <th>{{ $NbreAff }}</th>
                                           <th></th>
                                            <th>{{ $NbreAyDT }}</th>
                                            <th>{{ $S->J }}</th>
                                            <th>{{ $S->F }}</th>
                                            <th>{{ $S->M }}</th>
                                            <th>{{ $S->A }}</th>
                                            <th>{{ $S->Ma }}</th>
                                            <th>{{ $S->Ju }}</th>
                                            <th>{{ $S->Jui }}</th>
                                            <th>{{ $S->Ao }}</th>
                                            <th>{{ $S->S }}</th>
                                            <th>{{ $S->O }}</th>
                                            <th>{{ $S->N }}</th>
                                            <th>{{ $S->D }}</th>
                                            <th>{{ $TCot }}</th>
                                            <th>{{ $S->ST }}</th>
                                            <th>{{ $EcartT }}</th>
                                       </tr>
                                       @endforeach
                                    </tfoot>
        </table> 
          <hr>
       <div class="footer-wrapper"><img src="{{url(session()->get('Footerfile'))}}" id="LOGO1"></div>
     </div>        
    </body>
</html>

