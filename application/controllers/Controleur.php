<?php
session_start();
defined('BASEPATH') OR exit('No direct script access allowed');



//définition d'une classe controleur (par exeple meme nom que votre fichier controleur) 
//héritée de CI_controller et permettant d'utiliser les raccoucis et fonctions de CodeIgniter
// Attention vos Fichiers et Classes Controleur et Modele doit commencer par une Majuscule et suivre par des minuscules
class Controleur extends CI_Controller {

//Fonction index correspondant au Controleur frontal (ou index.php) en MVC libre	
public function index(){



$this->load->model('Modele');


//regarde si c'est la premier connection du visiteur, si non garder en mémoire l'id et le mdp
if(isset($_POST['ID'])){
	$_SESSION['identifiant'] = $_POST['ID'];
	$_SESSION['mdp'] = $_POST['password'];

}
else{
    unset($_SESSION['identifiant']);
    unset($_SESSION['mdp']);

}

//si il y a un id et un mdp alors on demande au controlleur la fonction login(compare les visiteur avec l'id et le mdp)
if(isset($_SESSION['identifiant']) and (isset($_SESSION['mdp']))){
	$login=$this->login($_SESSION['identifiant'],$_SESSION['mdp']);

	if($login != null){
	//on prend  l'id du visiteur
		$_SESSION['ID'] = $login;

	}
	// si cela ne correspond à aucun visteur on bloucle sur la page login
	else{
		$_SESSION['Action'] = "Login";
	}
}

else{
	$_SESSION['Action'] = "Login";
}


//on regarde la variable action et si il est vide (premier connection), alors on le set sur la vue login 
if(isset($_SESSION['ID'])){
	$Action = $_GET["action"];
}
else{
	$Action = "Login";
}


try{

	// -------Action que souhaite l'utilisateur (affichage des vues/insertion bdd)------
	switch($Action) {
		case "Login":
			$this->VueLogin();

		break;

		case "formulaire":
			$this->Vueformulaire();
		break;	

		case "recapitulatif":
            $_SESSION['mE']=$this->getFrais("1");
            $_SESSION['mK']=$this->getFrais("2");
            $_SESSION['mH']=$this->getFrais("3");
            $_SESSION['mR']=$this->getFrais("4");
			$this->VueRecap();
		break;	
		
		case "Consultation":
            $_SESSION['npBDD']=$this->infoVisiteur($_SESSION['VisiteurID']);
            if(isset($_POST['month'])){
                print
                //------------------------------Select ETP quantité------------------------------//
                $_SESSION['Eta'] = $this->getfichefrais("2",$_POST['month'],$_SESSION['VisiteurID']);
               
                //------------------------------Select KM quantité------------------------------//
                $_SESSION['kilo'] = $this->getfichefrais("3",$_POST['month'],$_SESSION['VisiteurID']);
                //------------------------------Select NUI quantité------------------------------//
                $_SESSION['Hot'] = $this->getfichefrais("4",$_POST['month'],$_SESSION['VisiteurID']);
                //------------------------------Select REP quantité------------------------------//
                $_SESSION['Restau'] = $this->getfichefrais("5",$_POST['month'],$_SESSION['VisiteurID']);

                $_SESSION['HForfait'] = $this->geHorsForfait($_POST['month'],$_SESSION['VisiteurID']);
            }


			$this->Consultation();	
		break;	

		case "Insert":
			$this->Insert();
		break;	
		
		case "deconnexion":
			session_destroy();
			$this->VueLogin();
		break;	

		default:
			$this->VueLogin();
		break;
		}
	}
catch (Exception $e) {
    erreur($e->getMessage());
}
}

// vue sur les pages
public function VueLogin() { 
$this->load->view('Login.php');
}

public function Vueformulaire() { 
$this->load->view('formulaire.php');
}

public function Consultation() { 
$this->load->view('Consultation.php');
}

public function VueRecap() { 

$this->load->view('recapitulatif.php');

}


//récupere touts les visiteurs et le retourne au controlleur
public function login($Identifiant,$MDP ){


$result = null;	

$bddVisiteur = $this->Modele->getVisiteur();

while($MDPVisiteur = $bddVisiteur->fetch()){

		if ($Identifiant == $MDPVisiteur["login"] && $MDP == $MDPVisiteur["mdp"]){
			$result = $MDPVisiteur["login"];	
            $_SESSION['VisiteurID'] = $MDPVisiteur['id'];
			break;
		}

	}
		return $result;
}
	
//permet de récuperer le nom et prenom par l'id du visiteur    
public function infoVisiteur($id){
    $np = $this->Modele->getNomPrenom($id);
    return $np;
}

//récupere toutes les variables et le renvoie au modele pour les inseré, il ajoute +1 pour le nombre de frais par hors forfait

public function Insert(){


$date = date("d-m-Y");
list($j,$m,$a)=explode("-",$date);

$Eta = $_SESSION['Eta'];
$kilo = $_SESSION['kilo'];
$Hot = $_SESSION['Hot'];
$Restau = $_SESSION['Restau'];

$MontantHF1=$_SESSION['MontantHF1'];
$MontantHF2=$_SESSION['MontantHF2'];
$MontantHF3=$_SESSION['MontantHF3'];
$F1=$_SESSION['F1'];
$F2=$_SESSION['F2'];
$F3=$_SESSION['F3'];
$date1=$_SESSION['date1'];
$date2=$_SESSION['date2'];
$date3=$_SESSION['date3'];
$nbJ = 4;
if(isset($F1) && isset($date1) && isset($MontantHF1)){
    $nbJ ++;
}
if(isset($F2) && isset($date2) && isset($MontantHF2)){
    $nbJ ++;
}
if(isset($F3) && isset($date3) && isset($MontantHF3)){
    $nbJ ++;

}

$mois="$m";

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
}

$this->Modele->InsertFiche($_SESSION['VisiteurID'],$mois,$nbJ,$_SESSION['total']);
$this->Modele->InsertETP($_SESSION['VisiteurID'],$mois,$Eta);
$this->Modele->InsertKM($_SESSION['VisiteurID'],$mois,$kilo);
$this->Modele->InsertNUI($_SESSION['VisiteurID'],$mois,$Hot);
$this->Modele->InsertREP($_SESSION['VisiteurID'],$mois,$Restau);

if(isset($F1) && isset($date1) && isset($MontantHF1)){
	$this->Modele->InsertHorsF($_SESSION['VisiteurID'],$mois,$_SESSION['F1'],$_SESSION['date1'],$_SESSION['MontantHF1']);
}

if(isset($F2) && isset($date2) && isset($MontantHF2)){
	$this->Modele->InsertHorsF($_SESSION['VisiteurID'],$mois,$_SESSION['F2'],$_SESSION['date2'],$_SESSION['MontantHF2']);
}

if(isset($F3) && isset($date3) && isset($MontantHF3)){
	$this->Modele->InsertHorsF($_SESSION['VisiteurID'],$mois,$_SESSION['F3'],$_SESSION['date3'],$_SESSION['MontantHF3']);
}

$this->Consultation();     
}

//récupere les prix des frais
public function getFrais($index){


$result = null;
$array = $this->Modele->getFraislist(); 

switch($index) {

    case(1) :
         $result = $array[0];    
    break;

    case(2) :
         $result = $array[1];
    break;

    case(3) :
         $result = $array[2];
    break;

    case(4) :
         $result = $array[3];
    break;


}

return $result;
}

//récupere depuis le modele la liste des 4 frais de de la fiche frais correspondant et retourne celui besoin
public function getfichefrais($index,$month,$VisiteurID){

$mois = "janvier";
switch($month) {
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



$result = null;
$array = $this->Modele->getFraisG($mois,$VisiteurID); 

switch($index) {

    case(1) :
        $result = $array[0];    
    break;

    case(2) :
        $result = $array[1];
    break;

    case(3) :
         $result = $array[2];
    break;

    case(4) :
        $result = $array[3];
    break;

    case(5) :
        $result = $array[4];
    break;
}
return $result;

}

//récupere depuis le modele la liste des hors forfaits de de la fiche frais correspondant et retourne celui besoin
public function geHorsForfait($month,$VisiteurID){

    $mois = "janvier";
switch($month) {
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


$hFi1 = null;
$hFi2 = null;
$hFi3 = null;
$hFq1 = 0; 
$hFq2 = 0;
$hFq3 = 0;

$HF1= array();
$HF2= array();
$HF3= array();
$HFList= array();
    $requserhF1=$this->Modele->getFraisR($VisiteurID,$mois,"1","0","0");

    while($ligne=$requserhF1->fetch(PDO::FETCH_ASSOC)){

         if($ligne['mois'] == $mois){
            $hFq1 = $ligne['montant'];
            $hFl1 = $ligne['libelle'];
            $hFd1 = $ligne['date'];
            $hFi1 = $ligne['id'];

            array_push($HF1, $hFq1);
            array_push($HF1, $hFl1);
            array_push($HF1, $hFd1);
            break;
        }
        else{
            $hFq1 = "aucun";
            $hFl1 = "aucun";
            $hFd1 = "aucun";
        }
    }

//------------------------------Select HorForfait 2------------------------------//
$requserhF2=$this->Modele->getFraisR($VisiteurID,$mois,"2",$hFi1,"0");

    while($ligne=$requserhF2->fetch(PDO::FETCH_ASSOC)){
         if($ligne['mois'] == $mois ){
            $hFq2 = $ligne['montant'];
            $hFl2 = $ligne['libelle'];
            $hFd2 = $ligne['date'];
            $hFi2 = $ligne['id'];
            array_push($HF2, $hFq2);
            array_push($HF2, $hFl2);
            array_push($HF2, $hFd2);
            break;
        }
        else{
            $hFq2 = 0;
            $hFl2 = "aucun";
            $hFd2 = "aucun";
        
        }
    }

//------------------------------Select HorForfait 3------------------------------//

$requserhF3=$this->Modele->getFraisR($VisiteurID,$mois,"3",$hFi1,$hFi2);

    while($ligne=$requserhF3->fetch(PDO::FETCH_ASSOC)){
         if($ligne['mois'] == $mois){
            $hFq3 = $ligne['montant'];
            $hFl3 = $ligne['libelle'];
            $hFd3 = $ligne['date'];
            $hFi3 = $ligne['id'];
            array_push($HF3, $hFq3);
            array_push($HF3, $hFl3);
            array_push($HF3, $hFd3);
            break;
        }
        else{
            $hFq3 = 0;
            $hFl3 = "aucun";
            $hFd3 = "aucun";
        }
    }

array_push($HFList, $HF1);
array_push($HFList, $HF2);
array_push($HFList, $HF3);

return $HFList;

}
}
?>