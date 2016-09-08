
<?php
	//demarrage de la session 
	if(!session_id())
	{
		session_start();
	}
	
	$prof=$_SESSION['loginp'];
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
			<table align='center' border='0'><tr>
			<tr><td>
			<ol style='width:100%;' class="nav">
				<li style='width:100%;  float:left;'><a href="index.php?lien=deconnexion">DECONNEXION</a> </li>
			</ol></td>
			</tr></table>
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
					$lien="information";
				}
			
				switch($lien)
				{
					case "information":
						include('prof.php');
					break;			
					
					case "deconnexion":
						if(session_id()){
								session_unset();
								}
							$ip=$_SERVER["SERVER_ADDR"];
						echo"<script>window.location.href='http://localhost/index.php';</script>";
					break;			
				}
					
			?>
		</div>
	</body>

</html>
