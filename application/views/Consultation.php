<?php
if (! session_id()){session_start();}
$VisiteurID = $_SESSION['ID'];
//------------------------------Select Nom Prenom------------------------------//


$np =$_SESSION['npBDD'];

//------------------------------Select Frais------------------------------//
	$mE=$_SESSION['mE'];
	$mK=$_SESSION['mK'];
	$mH=$_SESSION['mH'];
	$mR=$_SESSION['mR'];

//------------------------------mois pour le choix du mois dans le button------------------------------//
$MonthArray = array(
"1" => "Janvier", "2" => "Février", "3" => "Mars", "4" => "Avril",
"5" => "Mai", "6" => "Juin", "7" => "Juillet", "8" => "aout",
"9" => "Septembre", "10" => "Octobre", "11" => "Novembre", "12" => "Decembre",
);
//------------------------------set les hors forfait (évite les bugs) ------------------------------//
//q=quantité
//l=libelle
//d=date
//i=id
   	$hFq1 = "...";
	$hFl1 = "...";
	$hFd1 = "...";
	$hFi1 = "...";

	$hFq2 = "...";
	$hFl2 = "...";
	$hFd2 = "...";
	$hFi2 = "...";

	$hFq3 = "...";
	$hFl3 = "...";
	$hFd3 = "...";
	$hFi3 = "...";
//------------------------------set à 0 si aucun mois selectionné------------------------------//
if( !isset($_SESSION['Month'])){
	$mois = null;
	$date = "...";
	$ETP = "0";
	$KM = "0";
	$NUI = "0";
	$REP = "0";
	$montantF = "0";
	$montantHF = "0";

}
//------------------------------sinon faire la consultation de la page en récuperant les données de la BBD------------------------------//
else{
	if(isset($_POST['month'])){
		$mois = $_POST['month'];
		$_SESSION['Month'] =  $_POST['month'];
	}
	else{
		$mois = 1;
	}


switch($mois) {
    case(1) :
        $mois = "janvier";
        break;
    case(2) :
        $mois = "fevrier";
        break;
    case(3) :
        $mois = "mars";
        break;
    case(4) : 
        $mois = "avril";
        break;
    case(5) :
        $mois = "mai";
        break;
    case(6) :
        $mois = "juin";
        break;
    case(7) :
        $mois = "juillet";
        break;
    case(8) :
        $mois = "aout";
        break;
    case(9) :
        $mois = "septembre";
        break;
    case(10) :
        $mois = "octobre";
        break;
    case(11) :
        $mois = "novembre";
        break;
    case(12) :
        $mois = "decembre";
        break;
        default;
        	$mois = "janvier";
}


//------------------------------Select ETP quantité------------------------------//
$ETP = $_SESSION['Eta'];

//------------------------------Select KM quantité------------------------------//

$KM = $_SESSION['kilo'];

//------------------------------Select NUI quantité------------------------------//

$NUI = $_SESSION['Hot'];

//------------------------------Select REP quantité------------------------------//

$REP = $_SESSION['Restau'];



$hFi1 = null;
$hFi2 = null;
$hFi3 = null;
$hFq1 = 0; 
$hFq2 = 0;
$hFq3 = 0;




//------------------------------Select HorForfait ------------------------------//

$listHF = $_SESSION['HForfait'];
$list1	=$listHF[0];
$list2	=$listHF[1];
$list3	=$listHF[2];


if(isset($list1[0])){
	$hFq1 = $list1[0];
	$hFl1 = $list1[1];
	$hFd1 = $list1[2];
}
if(isset($list2[0])){

	$hFq2 = $list2[0];
	$hFl2 = $list2[1];
	$hFd2 = $list2[2];

}
if(isset($list3[0])){
	$hFq3 = $list3[0];
	$hFl3 = $list3[1];
	$hFd3 = $list3[2];
}

	$montantF = $mE*$ETP + $mK*$KM + $mH*$NUI + $mR*$REP;
	$montantHF = $hFq1+$hFq2+$hFq3;
}





?>

<!DOCTYPEhtml>
<html>
	<head>
		<meta charset="utf-8"/>
		<link rel="stylesheet" href="/CodeIgniter/CodeIgniter-3.0.0/assets/Style.CSS"/>
		<title>Consultation</title>
	</head>
	
	<body>


		<form method="post" action="index.php?action=Consultation">
			<select name="month">
			<option value="">Selectionner le mois</option>
			<?php
			foreach ($MonthArray as $monthNum=>$month) {
			$selected = (isset($getMonth) && $getMonth == $monthNum) ? 'selected' : '';
				echo '<option ' . $selected . ' value="' . $monthNum . '">' . $month . '</option>';

			}
			$_SESSION['Month'] = $selected;

			?>
			</select>
			<input type="submit" value="valider" onclick= "<?php $_SESSION['Action'] = "Consultation";?>" />
		</form>

		<h1> fiche Frais de <?php echo $np; ?> </h1>
		<h1> Saisie le <?php echo $mois; ?> </h1>

			<table>
		<tr>
			<th width="1%" align="center">Nom du frais</th>
			<th width="1%" align="center">Quantité</th>
			<th width="1%" align="center">taux forfaitaire</th>
		</tr>
		
		<tr>
			<td width="1%" align="center">Forfait Etape</td>
			<td> <?php echo $ETP?> </td>
			<td> <?php echo $mE?> </td>
		</tr>
		
		<tr>
			<td align="center">Frais Kilométre</td>
			<td> <?php echo $KM ?> </td>
			<td> <?php echo $mK ?></td>
		</tr>
		
		<tr>
			<td align="center">Nuitée Hotel</td>
			<td><?php echo $NUI ?></td>
			<td> <?php echo $mH?></td>
		</tr>
		
		<tr>
			<td align="center">Repas restaurant</td>
			<td><?php echo $REP ?></td>
			<td> <?php echo $mR ?></td>
		</tr>
		<tr>
			<td align="center">Total forfait</td>
			<td><?php echo $montantF ?></td>

		</tr>

	</table>

	<table>
		<tr>
			<td><?php echo $hFd1 ?></td>
			<td><?php echo $hFl1 ?></td>
			<td><?php echo $hFq1 ?></td>
		</tr>

	</table>
	<table>
		<tr>
			<td><?php echo $hFd2 ?></td>
			<td><?php echo $hFl2 ?></td>
			<td><?php echo $hFq2 ?></td>
		</tr>

	</table>
	<table>
		<tr>
			<td><?php echo $hFd3 ?></td>
			<td><?php echo $hFl3 ?></td>
			<td><?php echo $hFq3 ?></td>
		</tr>

	</table>

	<table>
		<tr>
			<td>Total hors forfait</td>
			<td><?php echo $montantHF ?></td>
		</tr>

	</table>

	<form method="post" action="index.php?action=deconnexion">
		<button class="Retour_Button" type="submit" >déconnexion</button> 
	</form>

	</body>

</html>