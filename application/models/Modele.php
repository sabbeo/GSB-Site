<?php
// ligne pour la securite
defined('BASEPATH') OR exit('No direct script access allowed');


//définition d'une classe Model (par exeple meme nom que votre fichier controleur) 
//héritée de CI_Model et permettant d'utiliser les raccoucis et fonctions de CodeIgniter
// Attention vos Fichiers et Classes Controleur et Modele doit commencer par une Majuscule et suivre par des minuscules
class Modele extends CI_Model {

//==========================
// Code du modele
//===========================

public function getVisiteur() { 

//$bdd = new PDO('mysql:host=192.171.1.13:3306;dbname=gsbv2','admindb','password');
  $bdd = new PDO('mysql:host=localhost:3308;dbname=gsbv2','root','password');
$bddVisiteur =$bdd->query("SELECT * FROM visiteur") or  die(mysql_error());
return $bddVisiteur;
}
public function getNomPrenom($VisiteurID){

$bdd = new PDO('mysql:host=localhost:3308;dbname=gsbv2','root','password');
$Visiteur =$bdd->query("SELECT nom,prenom FROM visiteur where id = \"".$VisiteurID."\"") or  die(mysql_error());
$donnes = $Visiteur->fetch();
$nom = $donnes['nom'];
$prenom = $donnes['prenom'];
$np = $nom." ".$prenom;

return $np;
}

public function getFraislist() { 
  $bdd = new PDO('mysql:host=localhost:3308;dbname=gsbv2','root','password');

$Frais=array();

	$EtaQ = $bdd->query("SELECT * FROM fraisforfait WHERE id= 'ETP'") ;
	$kiloQ= $bdd->query("SELECT * FROM fraisforfait WHERE id= 'KM'") ;
	$HotQ = $bdd->query("SELECT * FROM fraisforfait WHERE id= 'NUI'") ;
	$RestauQ = $bdd->query("SELECT * FROM fraisforfait WHERE id= 'REP'") ;

	while($ligne=$EtaQ->fetch(PDO::FETCH_ASSOC)){
   		 $mE = $ligne['montant'];
   		 array_push($Frais, $mE);
	}
	while($ligne=$kiloQ->fetch(PDO::FETCH_ASSOC)){
   		 $mK = $ligne['montant'];
   		 array_push($Frais, $mK);
	}
	while($ligne=$HotQ->fetch(PDO::FETCH_ASSOC)){
   		 $mH = $ligne['montant'];
   		 array_push($Frais, $mH);
	}
	while($ligne=$RestauQ->fetch(PDO::FETCH_ASSOC)){
   		 $mR = $ligne['montant'];
   		 array_push($Frais, $mR);
	}

return $Frais;	
}

public function InsertFiche($VisiteurID,$mois,$nbJ,$montant) { 

  $bdd = new PDO('mysql:host=localhost:3308;dbname=gsbv2','root','password');

$idE = "CR";

$date = date("d-m-Y");
list($j,$m,$a)=explode("-",$date);

$requser = "insert into fichefrais values (\"".$VisiteurID."\",\"".$mois."\",".$nbJ.",".$montant.",\"".$date."\",\"".$idE."\")";

$bdd->exec($requser) ;
}

public function InsertETP($VisiteurID,$mois,$Eta) { 

  $bdd = new PDO('mysql:host=localhost:3308;dbname=gsbv2','root','password');

$requser = "select id from fraisforfait where id = \"ETP\"";

$reponse = $bdd->query($requser);

while($ligne=$reponse->fetch(PDO::FETCH_ASSOC)){
    $ide = $ligne['id'];
}

$requser = "insert into lignefraisforfait (idVisiteur,mois,idFraisForfait,quantite) values (\"".$VisiteurID."\",\"".$mois."\",\"".$ide."\",".$Eta.")";

$bdd->exec($requser) ;

}

public function InsertKM($VisiteurID,$mois,$kilo) { 
  $bdd = new PDO('mysql:host=localhost:3308;dbname=gsbv2','root','password');

$requser = "select id from fraisforfait where id = \"KM\"";

$reponse = $bdd->query($requser);

while($ligne=$reponse->fetch(PDO::FETCH_ASSOC)){
    $idk = $ligne['id'];
}

$requser = "insert into lignefraisforfait (idVisiteur,mois,idFraisForfait,quantite) values (\"".$VisiteurID."\",\"".$mois."\",\"".$idk."\",".$kilo.")";

$bdd->exec($requser) ;
}
public function InsertNUI($VisiteurID,$mois,$Hot) { 
  $bdd = new PDO('mysql:host=localhost:3308;dbname=gsbv2','root','password');


$requser = "select id from fraisforfait where id = \"NUI\"";

$reponse = $bdd->query($requser);

while($ligne=$reponse->fetch(PDO::FETCH_ASSOC)){
    $idn = $ligne['id'];
}

$requser = "insert into lignefraisforfait (idVisiteur,mois,idFraisForfait,quantite) values (\"".$VisiteurID."\",\"".$mois."\",\"".$idn."\",".$Hot.")";

$bdd->exec($requser) ;

}

public function InsertREP($VisiteurID,$mois,$Restau) { 

  $bdd = new PDO('mysql:host=localhost:3308;dbname=gsbv2','root','password');
$requser = "select id from fraisforfait where id = \"REP\"";

$reponse = $bdd->query($requser);

while($ligne=$reponse->fetch(PDO::FETCH_ASSOC)){
    $idr = $ligne['id'];
}

$requser = "insert into lignefraisforfait (idVisiteur,mois,idFraisForfait,quantite) values (\"".$VisiteurID."\",\"".$mois."\",\"".$idr."\",".$Restau.")";

$bdd->exec($requser);

}

public function InsertHorsF($VisiteurID,$mois,$F1,$date1,$MontantHF1) { 
  $bdd = new PDO('mysql:host=localhost:3308;dbname=gsbv2','root','password');

$requser = "select id from lignefraishorsforfait";

    $reponse = $bdd->query($requser);

    $idhf = 0;

if(isset($reponse)){


    while($ligne=$reponse->fetch(PDO::FETCH_ASSOC)){
        $idhf = $ligne['id'];
        if($idhf == 0) {
            $idhf = 0;
            
        }
        else {
            $idhf = $ligne['id'] + 1;
            
        }

    }
 }
else{
	$idhf = 0;
}

$requser = "insert into lignefraishorsforfait (id,idVisiteur,mois,libelle,date,montant) values (\"".$idhf."\",\"".$VisiteurID."\",\"".$mois."\",\"".$F1."\",\"".$date1."\",".$MontantHF1.")";

$bdd->exec($requser);
}

public function getFraisG($mois,$VisiteurID) { 
  $bdd = new PDO('mysql:host=localhost:3308;dbname=gsbv2','root','password');

$Frais=array();
//------------------------------Select Date------------------------------//
$requserDate = $bdd->query("SELECT dateModif FROM fichefrais where idVisiteur = \"".$VisiteurID."\" AND mois = \"".$mois."\"") or  die(mysql_error());
$donneDate = $requserDate->fetch();
$date = $donneDate['dateModif'];
array_push($Frais, $date);

//------------------------------Select ETP quantité------------------------------//
$ETP = "ETP";
$requserETP = $bdd->query("SELECT quantite FROM lignefraisforfait where idVisiteur = \"".$VisiteurID."\" AND idFraisForfait = \"".$ETP."\" AND mois= \"".$mois."\"");
$quantite = $requserETP->fetch();
$ETP = $quantite['quantite'];
array_push($Frais, $ETP);

//------------------------------Select KM quantité------------------------------//
$KM = "KM";
$requserKM = $bdd->query("SELECT quantite FROM lignefraisforfait where idVisiteur = \"".$VisiteurID."\" AND idFraisForfait = \"".$KM."\" AND mois= \"".$mois."\"");
$quantite = $requserKM->fetch();
$KM = $quantite['quantite'];
array_push($Frais, $KM);

//------------------------------Select NUI quantité------------------------------//
$NUI = "NUI";
$requserNUI = $bdd->query("SELECT quantite FROM lignefraisforfait where idVisiteur = \"".$VisiteurID."\" AND idFraisForfait = \"".$NUI."\" AND mois= \"".$mois."\"");
$quantite = $requserNUI->fetch();
$NUI = $quantite['quantite'];
array_push($Frais, $NUI);

//------------------------------Select REP quantité------------------------------//
$REP = "REP";
$requserREP = $bdd->query("SELECT quantite FROM lignefraisforfait where idVisiteur = \"".$VisiteurID."\" AND idFraisForfait = \"".$REP."\" AND mois= \"".$mois."\"");
$quantite = $requserREP->fetch();
$REP = $quantite['quantite'];
array_push($Frais, $REP);

return $Frais;

}

public function getFraisR($VisiteurID,$mois,$int,$hFi1,$hFi2){
  $bdd = new PDO('mysql:host=localhost:3308;dbname=gsbv2','root','password');


switch($int) {
    case(1) :
       $requser = $bdd->query("SELECT * FROM lignefraishorsforfait where idVisiteur = \"".$VisiteurID."\" AND mois= \"".$mois."\"");
    break;

    case(2) :
      $requser = $bdd->query("SELECT * FROM lignefraishorsforfait where idVisiteur = \"".$VisiteurID."\" AND mois= \"".$mois."\" AND id not in (\"".$hFi1."\")");
    break;

    case(3) :
      $requser = $bdd->query("SELECT * FROM lignefraishorsforfait where idVisiteur = \"".$VisiteurID."\" AND mois= \"".$mois."\" AND id not in (\"".$hFi1."\",\"".$hFi2."\")");
    break;

  }
  return $requser;
}
}
?>
