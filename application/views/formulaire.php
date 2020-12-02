
<!DOCTYPEhtml>
<html>
	<head>
		<meta charset="utf-8"/>
		<link rel="stylesheet" href="/CodeIgniter/CodeIgniter-3.0.0/assets/Style.CSS"/>
		<title>Formulaire GSB</title>
	</head>
	
	<body>
		<div>
			<form method="post" action="index.php?action=recapitulatif">
				<h2>Frais Forfaitaires : </h2>
			
				<h3>Forfait étape : </h3>
				<div class="TextBox_Form">
					<input class="TextBox" type="number" name="Etape"/>	
				</div>
			
				<h3>frais kilométrique : </h3>
				<div class="TextBox_Form">
					<input class="TextBox" type="number" name="kilométrique"/>	
				</div>
			
				<h3>Nuitée Hotel : </h3>			
				<div class="TextBox_Form">
					<input class="TextBox" type="number" name="Hotel"/>	
				</div>
				<h3>Repas Restaurant : </h3>
				<div class="TextBox_Form">
					<input class="TextBox" type="number" name="Restaurant"/>	
				</div>
		</div>
		
		<div>
		
			<h2>Autres Frais : </h2>
			<div class="date_input">
				<input type="date" name="date1"/>
				<input class="TextBox" type="text" placeholder="Intitulé du frais" name="F1"/>
				<input class="TextBox" type="number" placeholder="Montant €" name="MontantHF1"/>
			
			</div>
		
			<div class="date_input">
				<input type="date"/ name="date2">
				<input class="TextBox" type="text" placeholder="Intitulé du frais" name="F2"/>
				<input class="TextBox" type="number" placeholder="Montant €" name="MontantHF2"/>
			</div>
		
			<div class="date_input">
				<input type="date"/ name="date3">
				<input class="TextBox" type="text" placeholder="Intitulé du frais" name="F3"/>
				<input class="TextBox" type="number" placeholder="Montant €" name="MontantHF3"/>
			</div>
		
		</div>
				<button class="valider_Button" type="submit"  >Valider</button> 
			</form>


		<form method="post" action="index.php?action=Consultation">
			<button class="Retour_Button" type="submit" >Consultation Fiche Frais</button> 
		</form>	
	</body>
	
	
	
	
	
</html>