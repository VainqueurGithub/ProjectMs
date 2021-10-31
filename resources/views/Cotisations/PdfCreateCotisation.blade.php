
<!DOCTYPE html>
<html lang="en">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        
        <title>Journal - Cotisation</title>
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
                width: 15%;
                height: 15%;
            }
        </style>
    </head>
    <body class="no-skin">
        <div><img src="{{ session()->get('Headerfile') }}" id="LOGO"></div><hr>
        @if($Origine !='' AND $Debut !='' AND $Fin !='')
        <h3 style="text-align: center;">JOURNAL DES COTISATION POUR
        {{$Origine->Origine}} DU {{$Debut}} AU {{$Fin}}
        </h3>
        @elseif($Individu !='' AND $Debut !='' AND $Fin !='')
        <h3 style="text-align: center;">JOURNAL DES COTISATION POUR
       {{$Individu->Code}} DU {{$Debut}} AU {{$Fin}}
        </h3>
        @elseif($Debut !='' AND $Fin !='')
        <h3 style="text-align: center;">JOURNAL DES COTISATION
        DU {{$Debut}} AU {{$Fin}}
        </h3>
        @elseif($Individu !='')
        <h3 style="text-align: center;">JOURNAL DES COTISATION POUR
        {{$Individu->Code}}
        </h3>
        @elseif($Origine !='')
         <h3 style="text-align: center;">JOURNAL DES COTISATIONS POUR
         {{$Origine->Origine}}
        </h3>
    @endif
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
                                            <th>SEPT.</th>
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
        </table>  
          <hr>
       <div><img src="{{url(session()->get('Footerfile'))}}" id="LOGO1"></div>
     </div>       
    </body>
</html>

