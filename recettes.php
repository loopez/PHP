<?php
	//demarrage de la session 
	if(!session_id())
	{
		session_start();
	}
	echo "<h3> Liste des recettes </h3>"; 
	//Connexion avec ORACLE
	$conn=oci_connect("system","oracle","127.0.0.1/XE");
	if(!$conn)
	{
	echo "Echec de Connexion";
	}
	else
	{
	$selection=oci_parse($conn,"select * from recette");
	oci_execute($selection);	
	//Analyse et affichage des resultats
	$nbrows=oci_fetch_all($selection,$resultats);
	if($nbrows >0)
	{
		echo"<table style='background-color:black; opacity: 0.8; font'>";
		for ($i=0;$i<$nbrows;$i++)
		{
			echo "<tr><td style='font-weight:bold;'>".$resultats['NOM'][$i]."</td></tr>";
			echo "<tr><td><img src='".$resultats['PHOTO'][$i]."'></td><td style=color:white;>".$resultats['INGREDIENT'][$i]."<br>".$resultats['INGREDIENT'][$i]."</td>";
			
		}	
		echo"</table>";
	//Rediriger vers la page membre.php	
	}
	else
	{
		echo "Aucune recette!";		
	}
	
oci_close($conn);
	}
	

?>
