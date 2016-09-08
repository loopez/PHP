<table align="center" width='80%'>
	<tr>
		<td colspan="4" align="center"><h2>Choisissez une option</h2></td>
	</tr>
	<tr>
		<td align="center" colspan="3"><h3> Ajoutez et supprimez des inscriptions ou modifiez les notes d'un etudiant</h3></td>
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
	echo "<h3> Formulaire d'ajout d'une inscription</h3>
	<form method='post'>
	<table align ='center'>
		<tr><td>Code Permanent</td> <td> <input type='text' name='codeetudiant'></td> </tr>
		<tr><td>Code du cours </td> <td> <input type='text' name='codecours'></td> </tr>
		<tr><td>Session </td> <td> <input type='text' name='lasession'></td> </tr>
		<tr><td>Code du professeur </td> <td> <input type='text' name='codeenseignant'></td> </tr>
		<tr><td>Note finale </td> <td> <input type='text' name='note'></td> </tr>
		<tr><td colspan='2' align='right'><input type='submit' name='inscrire' value='Ajouter'></td> </tr>
	</table>
	</form>";
}
	if(isset($_POST["inscrire"])){
		//recuperation des donnees
		$etudiant=$_POST["codeetudiant"];
		$cours=$_POST["codecours"];			
		$lasession=$_POST["lasession"];		
		$enseignant=$_POST["codeenseignant"];
		$note=$_POST["note"];
		
		//2) Connexion
		$conn=oci_connect("usrecole","oracle","127.0.0.1/XE");
		if(!$conn){
			echo "Echec de Connexion";
		}
			else{
		//3) requete
			$insertion=oci_parse($conn,"insert into INSCRIPTION values('$etudiant','$cours','$lasession','$enseignant',$note)");
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
	echo "<h2 align=center>MODIFICATION DUNE NOTE</h2>
		<h3align=center>Ecrivez le code de l'etudiant, du cours et la session </h2><form method='post'><br><br>
		<input type='hidden' value='Modifier' name='modifier'>
		<input type='text' name='etudiant' value='Etudiant'>
		<input type='text' name='lasession' value='Session'>
		<input type='text' name='cours' value='Cours'>
		<input type='submit' name='rechercher' value='rechercher' placeholder='Ecrivez le code de l'ensegnant'>
		</form><br>";
	if(isset($_POST["rechercher"])){
		$etudiant=$_POST["etudiant"];
		$lasession=$_POST["lasession"];
		$cours=$_POST["cours"];
		if(empty($etudiant)){
			echo "Completez tous lez champs";
		} else{
			$conn=oci_connect("usrecole","oracle","127.0.0.1/XE");
			$selection=oci_parse($conn,"select * from inscription WHERE CODEPERMANENT='$etudiant' AND NOCOURS='$cours' AND LASESSION='$lasession'");
			oci_execute($selection);	
			$nbrows=oci_fetch_all($selection,$resultats);
			if($nbrows > 0){
				echo "<h3> Formulaire de modification dune note </h3>
				<form method='post'>
				<input type='hidden' value='".$etudiant."' name='etudiant'>
				<input type='hidden' value='".$lasession."' name='lasession'>
				<input type='hidden' value='".$cours."' name='cours'>
				<input type='hidden' value='Modifier' name='modifier'>
				<input type='hidden' value='Recherche' name='rechercher'>
				<table align ='center'>";
				for ($i=0;$i<$nbrows;$i++){
					echo " <tr><td>Code Etudiant</td> <td><input name='etudiant' value='".$resultats['CODEPERMANENT'][$i]."'></td></tr>";
					echo " <tr><td>Code Cours </td> <td><input name='cours' value='".$resultats['NOCOURS'][$i]."'></td></tr>";
					echo "<tr><td>Session </td> <td> <input name='session' value='".$resultats['LASESSION'][$i]."'></td></tr>";
					echo "<tr><td>Note Finale</td> <td> <input name='note' value='".$resultats['NOTEFINALE'][$i]."'></td></tr>";
					}
					echo "<tr><td align='right' colspan='2'><input type='submit' name='sauvegarde4' value='Sauvegarde'></td></tr>
				</table>
				</form>";
		
				if(isset($_POST["sauvegarde4"])){
				$etudiant=$_POST["etudiant"];
				$cours=$_POST["cours"];
				$lasession=$_POST["lasession"];			
				$note=$_POST["note"];
					//3) requete
					$conn=oci_connect("usrecole","oracle","127.0.0.1/XE");
					$modification=oci_parse($conn,"UPDATE inscription SET NOTEFINALE='$note'
						WHERE CODEPERMANENT='$etudiant' and NOCOURS='$cours' and LASESSION='$lasession'");
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
			else{
				echo "Inscription non trouvée"; }
		}	
	}
} 
?>

<?php
//SUPPRESSION 
if(isset($_POST["supprimer"])){ 
	echo "<h2 align=center>SUPPRESSION DUNE INSCRIPTION</h2><form method='post'>
		<input type='hidden' value='supprimer' name='supprimer'>
		<input type='text' name='etudiant'>
		<input type='text' name='cours'>
		<input type='text' name='lasession'>
		<input type='submit' name='rechercher6' value='rechercher'>
		</form><br>";
	if(isset($_POST["rechercher6"])){
		$etudiant=$_POST["etudiant"];
		$cours=$_POST["cours"];
		$lasession=$_POST["lasession"];
		if(empty($etudiant)){
			echo "Completez tous les champs";
		
		} else{
			$conn=oci_connect("usrecole","oracle","127.0.0.1/XE");
			$selection=oci_parse($conn,"select * from inscription WHERE CODEPERMANENT='$etudiant' AND NOCOURS='$cours' AND LASESSION='$lasession'");
			oci_execute($selection);	
			$nbrows=oci_fetch_all($selection,$resultats);
			if($nbrows > 0){
				echo "<h3> Voulez-vous supprimer l'inscription de ".$etudiant." au cours ".$cours."?</h3>
				<form method='post'>
				<input type='hidden' value='".$etudiant."' name='etudiant'>
				<input type='hidden' value='".$cours."' name='cours'>
				<input type='hidden' value='".$lasession."' name='lasession'>
				<input type='hidden' value='Supprimer' name='supprimer'>
				<input type='hidden' value='rechercher' name='rechercher6'>
				<table align ='center'>";
				echo "<tr><td colspan='2'><input type='submit' name='oui2' value='Oui'></td>";
				echo "<td colspan='2'><input type='submit' name='non2' value='Non'></td></tr>";
				echo "</table>
				</form>";
				#} else {echo "Cours non trouvé";}
				if(isset($_POST["oui2"])){
					//recuperation des donnees
		
							//3) requete
					$conn=oci_connect("usrecole","oracle","127.0.0.1/XE");
					$suppression=oci_parse($conn,"DELETE from inscription WHERE CODEPERMANENT='$etudiant' AND NOCOURS='$cours' AND LASESSION='$lasession'");
					$selection=oci_parse($conn,"SELECT * from inscription WHERE CODEPERMANENT='$etudiant' AND NOCOURS='$cours' AND LASESSION='$lasession'");
					oci_execute($suppression);
					oci_execute($selection);
					//4) analyse et affichage des resultats
					$enreg=oci_num_rows($selection);
					if ($enreg >0){
						echo "<br><h2>Suppression non reussie</h2>";
						}
					else{
						echo "<br><h2>Suppression reussie</h2>";
						oci_commit($conn);
						}	
				//5) fermeture de la connexion
					}
				
				//5) fermeture de la connexion
				}
			}
		}	
	}
?>

