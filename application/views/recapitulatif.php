<?php


//------------------------------verifier si les montants des hors forfaits et bien rempli------------------------------//
$array=array();
if( isset($_POST['MontantHF1'])){
	$MontantHF1 = $_POST['MontantHF1'];
	array_push($array, $MontantHF1);
}
if( isset($_POST['MontantHF2'])){
	$MontantHF2 = $_POST['MontantHF2'];
	array_push($array, $MontantHF2);
}
if( isset($_POST['MontantHF3'])){
	$MontantHF3 = $_POST['MontantHF3'];
	array_push($array, $MontantHF3);
}
//------------------------------Récupere les variables du formulaire------------------------------//
$Eta = $_POST['Etape'];
$kilo = $_POST['kilométrique'];
$Hot = $_POST['Hotel'];
$Restau = $_POST['Restaurant'];

$F1 =$_POST['F1'];
$F2 = $_POST['F2'];
$F3 = $_POST['F3']; 
$date1 =$_POST['date1']; 
$date2 =$_POST['date2']; 
$date3 = $_POST['date3'];
//------------------------------insere les variable du formulaire dans la session------------------------------//
$_SESSION['Eta'] =$Eta;
$_SESSION['kilo'] =$kilo;
$_SESSION['Hot'] =$Hot;
$_SESSION['Restau'] =$Restau;

$_SESSION['MontantHF1'] =$MontantHF1;
$_SESSION['MontantHF2'] =$MontantHF2;
$_SESSION['MontantHF3'] =$MontantHF3;
$_SESSION['F1'] =$F1;
$_SESSION['F2'] =$F2;
$_SESSION['F3'] =$F3;
$_SESSION['date1'] =$date1;
$_SESSION['date2'] =$date2;
$_SESSION['date3'] =$date3;

//------------------------------récupere les frais forfaitpour inserer dans le tableau et calculer la somme total------------------------------//

	$mE=$_SESSION['mE'];
	$mK=$_SESSION['mK'];
	$mH=$_SESSION['mH'];
	$mR=$_SESSION['mR'];

//calcule les montant totoal
	$montant = $mE*$Eta + $mK*$kilo + $mH*$Hot + $mR*$Restau;
	$montantHF = array_sum($array);
	$total = $montant+$montantHF;
	$_SESSION['total'] = $total;

?>
<!DOCTYPEhtml>
<html>
	<head>
		<meta charset="utf-8"/>
		<link rel="stylesheet" href="/CodeIgniter/CodeIgniter-3.0.0/assets/Style.CSS"/>
		<title>Formulaire GSB</title>
	</head>
	
	<body>
	
	 
	<table>
		<caption>récapitulatif de la note de frais du mois</caption>
		<tr>
			<th width="1%" align="center">Nom du frais</th>
			<th width="1%" align="center">Quantité</th>
			<th width="1%" align="center">taux forfaitaire</th>
		</tr>
		
		<tr>
			<td width="1%" align="center">Forfait Etape</td>
			<td> <?php echo $Eta; ?> </td>
			<td> <?php echo $mE; ?> </td>
		</tr>
		
		<tr>
			<td align="center">Frais Kilométre</td>
			<td> <?php echo $kilo; ?> </td>
			<td> <?php echo $mK ?></td>
		</tr>
		
		<tr>
			<td align="center">Nuitée Hotel</td>
			<td><?php echo $Hot; ?></td>
			<td> <?php echo $mH ?></td>
		</tr>
		
		<tr>
			<td align="center">Repas restaurant</td>
			<td><?php echo $Restau; ?></td>
			<td> <?php echo $mR?></td>
		</tr>
		<tr>
			<td align="center">Total Forfait</td>
			<td><?php echo $montant; ?></td>

		</tr>
	</table>	
	
	<table>
		<caption>récapitulatif de la note Hors forfait frais du mois</caption>
		<tr>
			<td>Date</td>
			<td>Libelle</td>
			<td>Prix</td>
		</tr>
		<tr>
			<td><?php echo $date1 ?></td>
			<td><?php echo $F1 ?></td>
			<td><?php echo $MontantHF1  ?></td>
		</tr>

	</table>
	<table>
		<tr>
			<td><?php echo $date2 ?></td>
			<td><?php echo $F2 ?></td>
			<td><?php echo $MontantHF2  ?></td>
		</tr>

	</table>
	<table>
		<tr>
			<td><?php echo $date3 ?></td>
			<td><?php echo $F3 ?></td>
			<td><?php echo $MontantHF3  ?></td>
		</tr>

	</table>

	<table>
		<tr>
			<td>Total hors forfait</td>
			<td><?php echo $montantHF ?></td>
		</tr>

	<table class="Total">
	<tr>
		<th></th>
		<th>Prix (€)</th>
	</tr>
	
	<tr>
		<td>Frais pris en charge  par l'entreprise</td>
		<td><?php echo $montant ?></td>

	</tr>
	
		<tr>
		<td>Frais pris en charge  par l'employé(e)</td>
		<td><?php echo $montantHF ?></td>

	</tr>
	
		<tr>
		<td>Total</td>
		<td><?php echo $total ?></td>

	</tr>
	
	</table>		
		<form  method="post" action="index.php?action=Insert">
			<button class="envoyer_Button" type="submit" >Envoyer</button> 
		</form>	
			</table>
	</body>
	

	
	
	
</html>
