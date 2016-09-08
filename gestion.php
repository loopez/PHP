<?php
	//demarrage de la session 
	if(!session_id())
	{
		session_start();
	}
?>

<!DOCTYPE html>
<html>
	<head>
	
		<link rel="stylesheet" type="text/css" href="style.css">
		
			<div id='banner' >
			<table align='center' border='0'>
				<tr>
					<td  width='25%' align='left'>
						<a href="index.php?lien=accueil"><img src="/IMAGES/SYMBOL.jpg" style="width: 60%; heigth: 60%;"></a>
					</td>
					<td align='left'>
						<h1 >
						INSTITUT<br> SGBDR<br> ORACLE
						</h1>
					</td>	
				</tr>
			</table>
			</div>
			
	</head>
	
	
	<body>
<!-- Section menu -->
		<div id="header">	
		<table style="width:100%">
		<tr>
		<td>
			<ol class="nav" >
				<li style="width:20%;"><a href="gestion.php?lien=accueil"> ACCUEIL </a> </li>
				<li style="width:20%;"><a href="gestion.php?lien=etudiant">ETUDIANT</a> </li>
				<li style="width:20%;"><a href="gestion.php?lien=cours">COURS</a> </li>
				<li style="width:20%;"><a href="gestion.php?lien=enseignant">ENSEIGNANT</a> </li>
				<li style="width:20%;"><a href="gestion.php?lien=inscription">INSCRIPTION</a> </li>
				<li style='float:right;'><br>
		<a  href="gestion.php?lien=deconnexion">DECONNEXION </a> </li></ol></td></tr>
		</table>
		</div>
<div align ="center">
			<?php
			/*Recuperation du lien par la méthode "GET"			*/
				if(isset($_GET["lien"])) //Cas où la variable lien est initialisée
				{
					$lien=$_GET["lien"];
				}
				else //Cas où la variable lien n'est pas initialisée
				{
					$lien="accueil";
				}
			
				switch($lien)
				{
					case "accueil":
						echo "<h3 style='font-family:sans-serif;'>Bienvenue
						<br><p>
						Choisissez le type de donnee a modifier.
						</p>
						</h3>";
					break;
					
					case "etudiant":
						include("/GESTION/gestionetudiant.php");
					break;
					
					case "cours":
						include("/GESTION/gestioncours.php");
					break;
					
					case "enseignant":
						include("/GESTION/gestionenseignant.php");
					break;
					
					case "inscription":
						include("/GESTION/inscription.php");				
					break;
					
					case "deconnexion":
					$ip=$_SERVER["SERVER_ADDR"];
					echo"<script>window.location.href='http://localhost/index.php';</script>";
					break;
					
					default:
						echo "DEFAULT";
				}
				
				
			
			?>
		</div>
