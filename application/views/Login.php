<?php
?>
<!DOCTYPEhtml>
<html>
	<head>
		<meta charset="utf-8"/>
		 <link rel="stylesheet" href="/CodeIgniter/CodeIgniter-3.0.0/assets/Style.css"/>

		<title>Login GSB</title>
	</head>
	
	
	<body> 
		<div class="container">
			<div>
				<img class="GSB_Logo" src="/CodeIgniter/CodeIgniter-3.0.0/assets/gsb.jpeg" height="225" width="325" />	
			</div>
			<form method="post" action="index.php?action=formulaire">
				<div>
					<h1> Identifiant </h1>
					<img class="IMG" src="/CodeIgniter/CodeIgniter-3.0.0/assets/login.jpeg" height="50" width="70"/>
					<div class="TextBox_ID">
						<input class="TextBox" type="text" name="ID" required />	
					</div>
		
					<h1> Mot de passe </h1>
					<img class="IMG" src="/CodeIgniter/CodeIgniter-3.0.0/assets/password.jpeg" height="50" width="50"/>
					<div class="TextBox_ID">
						<input class="TextBox" type="password" name="password" required />
					</div>	
				</div>
			
				
				<button class="Connection_Button" type="submit" >Connection</button> 
			</form>
		</div>


	</body>
</html>