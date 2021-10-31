
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>Journal - Facture</title>
        <link rel="icon" type="image/x-icon" href="images/LOGO ELICOM BURUNDI.jpg"/>

        <style type="text/css">
            td, th{
             border:1px solid black;
            }
            table{
                width: 100%;
                border-collapse: collapse;
            }

            #LOGO{
                width: 15%;
                height: 15%;
            }
        </style>
    </head>
    <body class="no-skin">
        <div class="header-wrapper"><img src="{{ session()->get('Headerfile') }}" id="LOGO"></div>
        <hr>
        <h3 style="text-align: center;">JOURNAL DES CONSOMMATIONS</h3>
        <table>
          <thead>
                                         <tr>
                                            <th>CODE</th>
                                            <th>ADHERANT</th>
                                            <th>JAN.</th>
                                            <th>FEV.</th>
                                            <th>MARS</th>
                                            <th>AVRIL</th>
                                            <th>MAI</th>
                                            <th>JUIN</th>
                                            <th>JUILLE</th>
                                            <th>AOUT</th>
                                            <th>SEMP.</th>
                                            <th>OCTO.</th>
                                            <th>NOV.</th>
                                            <th>DEC.</th>
                                            <th>TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       {!! $tableListe !!}
                                    </tbody>
                                    <tfoot>
                                        @foreach($Somme as $S)
                                        <tr>
                                           <th>{{ $S->AF }}</th>
                                            <th>{{ $S->AF }}</th>
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
                                            <th>{{ $S->ST }}</th>
                                       </tr>
                                       @endforeach
                                    </tfoot>
        </table> <hr />
        <div class="footer-wrapper"><img src="{{url(session()->get('Footerfile'))}}" id="LOGO1"></div>
    </body>
</html>

