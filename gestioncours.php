<table align="center" width='80%'>
	<tr>
		<td colspan="4" align="center"><h2>Choisissez une option</h2></td>
	</tr>
	<tr>
		<td align="center" colspan="3"><h3> Ajoutez, supprimez ou modifiez les donnees d'un cours</h3></td>
		</tr>
	<tr>
		<td align="center"><form method="post"><input type=submit value="Ajouter" name="ajouter" style="width:50%"></form></td>
		<td align="center"><form method="post"><input type=submit value="Modifier" name="modifier" style="width:50%"></form></td>
		<td align="center"><form method="post"><input type=submit value="Supprimer" name="supprimer" style="width:50%"></form></td>
	</tr>
</table>

<?php
//AJOUT
if (isset($_POST["ajouter"])){ 
	echo "<h3> Formulaire d'ajout d'un cours </h3>
	<form method='post'>
	<table align ='center'>
		<tr><td>Numero de cours </td> <td> <input type='text' name='nocours'></td> </tr>
		<tr><td>Nom </td> <td> <input type='text' name='nomcours'></td> </tr>
		<tr><td>Description </td> <td> <input style='height: 100px !important;
width: 400px;' type='text' name='description'></td> </tr>
		<tr><td>Prix </td> <td> <input type='text' name='prix'></td> </tr>
		<tr><td colspan='2' align='right'><input type='submit' name='inscrire' value='Ajouter'></td> </tr>
	</table>
	</form>";
}
	if(isset($_POST["inscrire"])){
		//recuperation des donnees
		$nocours=$_POST["nocours"];
		$nomcours=$_POST["nomcours"];			
		$description=$_POST["description"];
		$prix=$_POST["prix"];		
		//2) Connexion
		$conn=oci_connect("usrecole","oracle","127.0.0.1/XE");
		if(!$conn){
			echo "Echec de Connexion";
		}
			else{
		//3) requete
			$insertion=oci_parse($conn,"insert into cours values('$nocours','$nomcours','$description','$prix')");
			oci_execute($insertion);
		//4) analyse et affichage des resultats
			$enreg=oci_num_rows($insertion);
			if ($enreg >0){
				echo "<br><h2>Ajout reussi</h2>";
				oci_commit($conn);
				}
			else{
				echo "<br><h2>Ajout non reussi</h2>";
				}	
		
		//5) fermeture de la connexion
		}
	}
?>

<?php
//MODIFICATION
if(isset($_POST["modifier"])){ 
	echo "<h2 align=center>MODIFICATION DUN COURS</h2><form method='post'>
		<input type='hidden' value='Modifier' name='modifier'>
		<input type='text' name='cours'>
		<input type='submit' name='rechercher' value='rechercher' placeholder='Ecrivez le nom ou le code du cours à modifier'>
		</form><br>";
	if(isset($_POST["rechercher"])){
		$cours=$_POST["cours"];
		if(empty($cours)){
			echo "Ecrivez un nom de cours";
		
		} else{
			$conn=oci_connect("usrecole","oracle","127.0.0.1/XE");
			$selection=oci_parse($conn,"select * from cours WHERE nomcours='$cours' or nomcours LIKE '%$cours%' or nocours='$cours'");
			oci_execute($selection);	
			$nbrows=oci_fetch_all($selection,$resultats);
			if($nbrows > 0){
				echo "<h3> Formulaire de modification d'un cours </h3>
				<form method='post'>
				<input type='hidden' value='".$cours."' name='cours'>
				<input type='hidden' value='Modifier' name='modifier'>
				<input type='hidden' value='Recherche' name='rechercher'>
				<table align ='center'>";
				for ($i=0;$i<$nbrows;$i++){
					echo " <tr><td>Numero de cours </td> <td><input name='nocours' value='".$resultats['NOCOURS'][$i]."'></td></tr>";
					echo "<tr><td>Nom </td> <td> <input name='nomcours' value='".$resultats['NOMCOURS'][$i]."'></td></tr>";
					echo "<tr><td>Description </td> <td> <input style='height: 100px !important;
					width: 400px;' type='text' name='description' value='".$resultats['DESCRIPCOURS'][$i]."'></td></tr>";
					echo "<tr><td>Prix </td> <td> <input name='prix' value='".$resultats['PRIXCOURS'][$i]."'></td></tr>";
					}
					echo "<tr><td colspan='2'><input type='submit' name='sauvegarde' value='Sauvegarde'></td></tr>
				</table>
				</form>";
				#} else {echo "Cours non trouvé";}
				if(isset($_POST["sauvegarde"])){
					//recuperation des donnees
					
					$nocours=$_POST["nocours"];
					$nom=$_POST["nomcours"];			
					$description=$_POST["description"];
					$prix=$_POST["prix"];	
			
					//3) requete
					$conn=oci_connect("usrecole","oracle","127.0.0.1/XE");
					$modification=oci_parse($conn,"UPDATE cours SET NOCOURS='$nocours', NOMCOURS='$nom',DESCRIPCOURS='$description',PRIXCOURS='$prix' WHERE NOMCOURS='$nom'");
					oci_execute($modification);
					//4) analyse et affichage des resultats
					$enreg=oci_num_rows($modification);
					if ($enreg >0){
						echo "<br><h2>Modification reussie</h2>";
						oci_commit($conn);
						}
					else{
						echo "<br><h2>Modification non reussie</h2>";
						}	
				//5) fermeture de la connexion
				}
			}
		}	
	}
} 
?>

<?php
//SUPPRESSION 
if(isset($_POST["supprimer"])){ 
	echo "<h2 align=center>SUPPRESSION DUN COURS</h2><form method='post'>
		<input type='hidden' value='supprimer' name='supprimer'>
		<input type='text' name='cours'>
		<input type='submit' name='rechercher2' value='rechercher' placeholder='Ecrivez le nom ou le code du cours à modifier'>
		</form><br>";
	if(isset($_POST["rechercher2"])){
		$cours=$_POST["cours"];
		if(empty($cours)){
			echo "Ecrivez un nom de cours";
		
		} else{
			$conn=oci_connect("usrecole","oracle","127.0.0.1/XE");
			$selection=oci_parse($conn,"select * from cours WHERE nomcours='$cours' or nomcours LIKE '%$cours%' or nocours='$cours'");
			oci_execute($selection);	
			$nbrows=oci_fetch_all($selection,$resultats);
			if($nbrows > 0){
				echo "<h3> Voulez-vous supprimer le cours ".$cours."</h3>
				<form method='post'>
				<input type='hidden' value='".$cours."' name='cours'>
				<input type='hidden' value='Supprimer' name='supprimer'>
				<input type='hidden' value='rechercher' name='rechercher2'>
				<table align ='center'>";
				echo "<tr><td colspan='2'><input type='submit' name='oui' value='Oui'></td>";
				echo "<td colspan='2'><input type='submit' name='non' value='Non'></td></tr>";
				echo "</table>
				</form>";
				#} else {echo "Cours non trouvé";}
				if(isset($_POST["oui"])){
					//recuperation des donnees
								
					//3) requete
					$conn=oci_connect("usrecole","oracle","127.0.0.1/XE");
					$suppression=oci_parse($conn,"DELETE from cours WHERE NOMCOURS='$cours' OR NOCOURS='$cours' ");
					$selection=oci_parse($conn,"SELECT from cours WHERE NOMCOURS='$cours' OR NOCOURS='$cours' ");
					oci_execute($suppression);
					//4) analyse et affichage des resultats
					$enreg=oci_num_rows($selection);
					if ($enreg >0){
						echo "<br><h2>Suppression non reussie</h2>";
						oci_commit($conn);
						}
					else{
						echo "<br><h2>Suppression reussie</h2>";
						oci_commit($conn);
						}	
				//5) fermeture de la connexion
				}
				if(isset($_POST["non"])){
					$_POST["supprimer"]="";
				}
			}
		}	
	}
}



?>

