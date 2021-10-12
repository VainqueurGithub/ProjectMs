<!DOCTYPE html>
<html>
<head>
	<title>CARTE ADHESION - {{$Adherant->Nom}} {{$Adherant->Prenom}}</title>
	<style type="text/css">
table{
	/*border-collapse: collapse;*/
}	
td, th /* Mettre une bordure sur les td ET les th */
{
/*border: 2px solid black;*/
padding: 5px;
text-align: center;
}
	</style>
</head>
<body>
    <div style="border: double;padding: 10px;font-family:sans-serif;font-size:10px;">
    	<h4>ADHERANT</h4>
        <table>
            <thead>
                <tr>
                    <th>N° code</th>
                    <th>Nom et prénom</th>
                    <th>Né(e) En:</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$Adherant->Code}}</td>
                    <td>{{$Adherant->Nom}} {{$Adherant->Prenom}}</td>
                    <td>{{$Adherant->DateNaiss}}</td>
                </tr>
            </tbody>
        </table>

    	<h4>PERSONNES A CHARGE</h4>
    	<table>
    		<thead>
    			<tr>
    				<th>N° code</th>
                    <th>Nom et prénom</th>
                    <th>date de naissance</th>
    			</tr>
    		</thead>
    		<tbody>
    			@foreach($beneficiaires as $beneficiaire)
    			<tr>
    				<td></td>
    				<td>{{$beneficiaire->Nom}} {{$beneficiaire->Prenom}}</td>
    				<td></td>
    			</tr>
    			@endforeach
    		</tbody>
    	</table>

        <div>
            <h4><i>N° Fiche d'adhésion : {{$Adherant->Code}}</i></h4>
            <h4>VERSEMENT DES COTISATIONS</h4>
            <div>
                <table>
                    <tbody>
                         <tr>
                            <th>Janv.</th>
                            <th>Févr.</th>
                            <th>Mars</th>
                            <th>Avril</th>
                            <th>Mai</th>
                            <th>Juin</th>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name=""></td>
                            <td><input type="checkbox" name=""></td>
                            <td><input type="checkbox" name=""></td>
                             <td><input type="checkbox" name=""></td>
                            <td><input type="checkbox" name=""></td>
                            <td><input type="checkbox" name=""></td>
                        </tr>
                         <tr>
                            <th>Juil.</th>
                            <th>Aout</th>
                            <th>Sept.</th>
                            <th>Oct.</th>
                            <th>Nov.</th>
                            <th>Déc.</th>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name=""></td>
                            <td><input type="checkbox" name=""></td>
                            <td><input type="checkbox" name=""></td>
                            <td><input type="checkbox" name=""></td>
                            <td><input type="checkbox" name=""></td>
                            <td><input type="checkbox" name=""></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
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