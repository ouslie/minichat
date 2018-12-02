<?php
include("db.php");
session_start();
if (isset($_POST['submit']))
{
	if(isset($_COOKIE))
	{
	 setcookie('pseudo',  $_POST['pseudo'], time() + 365*24*3600, null, null, false, true); 
	}
	$req = $bdd->prepare('INSERT INTO messages(pseudo, mess, datepublication) VALUES(:pseudo, :mess, :datepublication)');
	$datepub = date("Y-m-d H:i:s");
	$req->execute(array(
		'pseudo' => $_POST['pseudo'],
		'mess' => $_POST['message'],
		'datepublication' => $datepub
		));
	
	header("Refresh:0");

}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<title>Minichat OpenClassroom</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>

	<div class="bg-contact3" style="background-image: url('images/bg-01.jpg');">
		<div class="container-contact3">
			<div class="wrap-contact3">
				<form class="contact3-form validate-form" method="post">
					<span class="contact3-form-title">
						Mini tchat OpenClassroom
					</span>		

					<div class="wrap-input3 validate-input" data-validate="Le pseudo est requis">
						<input class="input3" type="text" name="pseudo" placeholder="Votre pseudo" value="<?php if(isset($_COOKIE['pseudo'])){echo $_COOKIE['pseudo'];}?>">
						<span class="focus-input3"></span>
					</div>

					<div class="wrap-input3 validate-input" data-validate = "Le message est requis">
						<textarea class="input3" name="message" placeholder="Votre message"></textarea>
						<span class="focus-input3"></span>
					</div>

					<div class="container-contact3-form-btn">
						<button name="submit" class="contact3-form-btn">
							Envoyer
						</button>
					</div>
				</form>
			</div>
			<div class="wrap-contact3">
				<span class="contact3-form-title">
					Fil de messages
				</span>	
				<div class="contenumessage">
				<?php
$reponse = $bdd->query('SELECT * FROM messages ORDER BY datepublication DESC LIMIT 0, 10');

// Affichage de chaque message (toutes les données sont protégées par htmlspecialchars)
while ($donnees = $reponse->fetch())
{
	$date = date_create($donnees['datepublication']);
	$date = date_format($date,'d-m-Y H:i:s');
	echo '<p>Le '. $date .' par 
	<strong>' . htmlspecialchars($donnees['pseudo']) . '</strong> : 
	' . htmlspecialchars($donnees['mess']) . '</p> </br>';
}

$reponse->closeCursor();
?>
				</div>

			</div>
		</div>			
	</div>


	<div id="dropDownSelect1"></div>

<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

<!--===============================================================================================-->
</body>
</html>
