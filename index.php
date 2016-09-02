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
		<style style="text/css">
			li{
				float:left;
				width:20%;
				display:inline;
			}
			
			body{
				text-align:center;
				background-color:#000000;	
				background-attachment:fixed;
				background-position:50% 50%;
				background-image:url('/imgbouffe/kitchen.jpg');	
				background-size:100%;
				background-repeat:no-repeat;
				font-family:"Palatino Linotype", "Book Antiqua", Palatino, serif;
				font-size:1em;
			}
			
			ol {
				list-style-type: none;
				padding: 1%;
				overflow: hidden;
				background-color: #333333;
				opacity: 0.8;
				margin: 0;
				font-weight:bold;
				
			}
			
			li a {
				color: white;
				text-align: center;
				width:60px;
				padding: 20px;
				text-decoration: none;
			}

			li a:hover {
				background-color: #111111;
				opacity: 0.8;
			}
			
			td {
			color:white;
			}
		
		</style>
		
		
	<div style="background-color:white; ">
				<h1>BONNE BOUFFE!</h1>
		</div>	
	</head>

	
	
	<body>
<!-- Section menu -->
		<div>
			<ol>
				<li><a href="index.php?lien=accueil"> ACCUEIL </a> </li>
				<li><a href="index.php?lien=login">LOGIN</a> </li>
				<li><a href="index.php?lien=recettes">RECETTES</a> </li>
				<li><a href="index.php?lien=contacts">CONTACTS</a> </li>
				<li><a href="index.php?lien=references">REFERENCES</a> </li>
			</ol>
			
		</div>

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
					$lien="acceuil";
				}
			
				switch($lien)
				{
					case "accueil":
						echo "ACCUEIL";
					break;
					
					case "login":
						include("login.php");
					break;
					
					case "recettes":
						include("recettes.php");
					break;
					
					case "contacts":
						echo "CONTACTS";
					break;
					
					case "references":
						echo "REFERENCES";
					break;
					
					case "nonmembre":
						echo "Inscrire membre!";
						include("inscription.php");
					break;
					
					default:
						echo "DEFAULT";
					
				}
				
				
			
			?>
		</div>
	</body>

</html>
