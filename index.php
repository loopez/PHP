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
			<ol class="nav">
				<li><a href="index.php?lien=accueil"> ACCUEIL </a> </li>
				<li><a href="index.php?lien=etudiant">ETUDIANT</a> </li>
				<li><a href="index.php?lien=enseignant">ENSEIGNANT</a> </li>
				<li><a href="index.php?lien=gestion">GESTION</a> </li>
			</ol>
			
		</div>
		<br><br>
<!-- Section details -->
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
						echo "<br><br><h2 align='center'>Choisissez votre role dans le menu ci-dessus</h2>
						";
					
					break;
					
					case "etudiant":
					
						echo "<br><br><h2 align ='center'>Ouverture de session etudiant </h2>
						<form method='post' action='index.php?lien=etudiant'>
						<table align ='center'>
						<tr><td>CODE PERMANENT </td><td><input type='text' name='logine' value=''></td></tr>
						<tr><td>MOT DE PASSE </td><td><input type='password' name='password' value=''></td></tr>
						<tr><td colspan='1'><input type='submit' name='entrer' value='entrer'></td></tr>
						</table>";
						if(isset($_POST["entrer"])){
						$_SESSION['logine']=$_POST['logine'];
						}
					
					//traitement des membres
					if(isset($_POST["entrer"]))
					{		
						//1)Recuperation par POST
						$logine=$_POST["logine"];
						$password=$_POST["password"];
						//2)Connexion avec ORACLE
						$conn=oci_connect("usrecole","oracle","127.0.0.1/XE");
						if(!$conn)
						{
						echo "Echec de Connexion";
						}
						else
						{
							$selection=oci_parse($conn,"select * from etudiants where CODEPERMANENT='$logine' and password='$password'");
							oci_execute($selection);
							$nbrows=oci_fetch_all($selection,$resultats);
							if ($nbrows >0){			
							$ip=$_SERVER["SERVER_ADDR"];
							echo"<script>window.location.href='http://localhost/indexetudiant.php';</script>";
							}else {
								echo "<br><br>Verifiez votre Code et Mot de passe";
								}		}
					}
					
					break;					
					
					case "enseignant":
						echo "<br><br><h2 align ='center'>Ouverture de session enseignant </h2>
						<form method='post' action='index.php?lien=enseignant'>
						<table align ='center'>
						<tr><td>CODE </td><td><input type='text' name='loginp' value=''></td></tr>
						<tr><td>MOT DE PASSE </td><td><input type='password' name='password' value=''></td></tr>
						<tr><td colspan='1'><input type='submit' name='entrer' value='entrer'></td></tr>
						</table>";
						if(isset($_POST["entrer"])){
						$_SESSION['loginp']=$_POST['loginp'];
						}
					
					//traitement des membres
					if(isset($_POST["entrer"])){		
						//1)Recuperation par POST
						$loginp=$_POST["loginp"];
						$password=$_POST["password"];
						//2)Connexion avec ORACLE
						$conn=oci_connect("usrecole","oracle","127.0.0.1/XE");
						if(!$conn)
						{
						echo "Echec de Connexion";
						}
						else
						{		$selection=oci_parse($conn,"select * from profs where NOPROF='$loginp' and password='$password'");
								oci_execute($selection);
								$nbrows=oci_fetch_all($selection,$resultats);
								if ($nbrows >0){			
							$ip=$_SERVER["SERVER_ADDR"];
							echo"<script>window.location.href='http://localhost/indexenseignant.php';</script>";
								}else {
									echo "<br><br>Verifiez votre Code et Mot de passe";
									}
								}
					}
									
					break;
					
					case "gestion":
						echo "<br><br><h2 align ='center'>Ouverture de session Administrateur </h2>
<form method='post' action='index.php?lien=gestion'>
	<table align ='center'>
	<tr><td>login</td><td><input type='text' name='login' value=''></td></tr>
	<tr><td>password</td><td><input type='password'name='password' value=''></td></tr>
	<tr><td colspan='1'><input type='submit' name='entrer' value='entrer'></td></tr>
	</table>";			
						//traitement du login
						if(isset($_POST["entrer"]))
						{		
							//1)Recuperation par POST
							$login=$_POST["login"];
							$password=$_POST["password"];
							//2)Connexion avec ORACLE
							$conn=oci_connect("usrecole","oracle","127.0.0.1/XE");
							if(!$conn){echo "Echec de Connexion";}
							else{
							//3) requete
								$selection=oci_parse($conn,"select * from administration where login='$login' and password='$password'");
								oci_execute($selection);
								$nbrows=oci_fetch_all($selection,$resultats);
								if ($nbrows >0){							
									$ip=$_SERVER["SERVER_ADDR"];
									echo"<script>window.location.href='http://localhost/gestion.php';</script>";
								}
								else{

								echo "<br><br>Login et /ou mot de passe incorrect";		
								}						
							}
						}		
					break;
					
					default;
						echo "<br><br><h2>Choisissez votre role dans le menu ci-dessus</h2>";
					break;
					
				}
				
				
			
			?>
		</div>
	</body>

</html>
