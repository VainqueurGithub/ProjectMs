<!DOCTYPE html>
<html>
<head>
	<title>FICHE ADHESION - {{$Affil->Nom}} {{$Affil->Prenom}}</title>
	<style type="text/css">
table{
	border-collapse: collapse;
}	
td, th /* Mettre une bordure sur les td ET les th */
{
border: 2px solid black;
padding: 5px;
text-align: center;
}
	</style>
</head>
<body>
    <div style="border: double;padding: 10px;font-family:sans-serif;font-size:10px;">
    	<div><h4 style="text-align:justify;">FICHE ADHESION MUTUALITE MS-SYS <span style="margin-left: 30%;">
    		<button id="aff" style="border: none;cursor: pointer;" target="PromoteFirefoxWindowName" onclick="openFFPromotionPopup(this); return false;" value="{{$Affil->id}}">N°: {{ $Affil->id}}</button>
    		</span></h4></div>
    	<h4><i>ADHERANT</i></h4>
    	<p>Nom & Prénom: <span><i style="font-weight: bold;">{{$Affil->Nom}} {{$Affil->Prenom}}</i></span> </p>
    	<p>Année de Naissance: <span><i style="font-weight: bold;">{{$Affil->DateNaiss}} </i></span> </p>
    	<p>Adresse: <span><i style="font-weight: bold;">{{$Affil->Adresse}}</i></span> </p>
         
         @if($Affil->profession!='')
    	<p>Profession: <span><i style="font-weight: bold;">{{$Affil->profession}}</i></span> </p>
    	 @else
    	 <p>Profession: <span><i style="font-weight: bold;">SANS</i></span> </p>
         @endif
    	<p>
    		<span>Date d'entrée: <i style="font-weight: bold;">{{$Affil->DateEntree}}</i></span>
    		<span style="margin-left:2%"> Droit d'adhésion payé: <i style="font-weight: bold;">{{$Affil->droit_adhesion}}</i></span> 
    	</p>

    	<p>
    		<span>Numéro de code: <i style="font-weight: bold;">{{$Affil->Code}}</i></span>
    		<span style="margin-left:2%"> Carte délivrée le: <i style="font-weight: bold;">{{$DateDelivrey}}</i></span> 
    	</p>
    	<p>
    		<span>Période d'observation: <i style="font-weight: bold;">{{$Affil->periode_observation}}</i></span> 
    	</p>
    
    	<h4><i>PERSONNES A CHARGE</i></h4>
    	<table>
    		<thead>
    			<tr>
    				<th>Date d'entrée</th>
    				<th>N° de code</th>
    				<th>Nom et prénom</th>
    				<th>Date de naissance</th>
    				<th>Lien parenté</th>
    				<th>Date de sortie</th>
    				<th>Remarques</th>
    			</tr>
    		</thead>
    		<tbody>
    			@foreach($beneficiaires as $beneficiaire)
    			<tr>
    				<td></td>
    				<td></td>
    				<td>{{$beneficiaire->Nom}} {{$beneficiaire->Prenom}}</td>
    				<td></td>
    				<td>{{$beneficiaire->Lien}}</td>
    				<td></td>
    				<td></td>
    			</tr>
    			@endforeach
    		</tbody>
    	</table>

    	<h4><i>OBSERVATIONS</i></h4>
    	<textarea cols="80" rows="4" readonly=""></textarea>
    </div>

    <script type="text/javascript">
    	 var WindowObjectReference = null; // variable globale
function openFFPromotionPopup(va) {
     //var id = document.getElementById("aff").value();
     var id = document.getElementById("aff").value();
     alert(id);
     var url = "{{ route('Affiliers.show', ":id") }}";
     url = url.replace(':id', id);
  if (WindowObjectReference == null || WindowObjectReference.closed) {
    WindowObjectReference = window.open(url,
           "PromoteFirefoxWindowName", "width=940,height=500,resizable,scrollbars=yes,status=1");
  }
  else {
    WindowObjectReference.focus();
  };
}
    </script>
</body>
</html>