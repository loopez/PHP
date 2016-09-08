<table align="center" width='80%'>
	<tr>
		<td colspan="4" align="center"><h2>Choisissez une option</h2></td>
	</tr>
	<tr>
		<td align="center" colspan="3"><h3> Ajoutez, supprimez ou modifiez les donnees d'un enseignant</h3></td>
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
	echo "<h3> Formulaire d'ajout d'un enseignant</h3>
	<form method='post'>
	<table align ='center'>
		<tr><td>Nom </td> <td> <input type='text' name='nomprof'></td> </tr>
		<tr><td>Prenom </td> <td> <input type='text' name='prenomprof'></td> </tr>
		<tr><td>Telephone </td> <td> <input type='text' name='telprof'></td> </tr>
		<tr><td>Chemin de la photo </td> <td> <input type='text' name='photoprof'></td> </tr>
		<tr><td>Password </td> <td> <input type='password' name='passwordprof'></td> </tr>
		<tr><td colspan='2' align='right'><input type='submit' name='inscrire' value='Ajouter'></td> </tr>
	</table>
	</form>";
}
	if(isset($_POST["inscrire"])){
		//recuperation des donnees
		$nomprof=$_POST["nomprof"];
		$prenomprof=$_POST["prenomprof"];			
		$telprof=$_POST["telprof"];		
		$photoprof=$_POST["photoprof"];
		$passwordprof=$_POST["passwordprof"];
		
		//2) Connexion
		$conn=oci_connect("usrecole","oracle","127.0.0.1/XE");
		if(!$conn){
			echo "Echec de Connexion";
		}
			else{
		//3) requete
			$insertion=oci_parse($conn,"insert into profs values(substr('$nomprof',1,3)||substr('$prenomprof',1,1),'$nomprof','$prenomprof','$telprof','$photoprof','$passwordprof')");
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
	echo "<h2 align=center>MODIFICATION DUN ENSEIGNANT</h2>
		<h3align=center>Ecrivez le code de l'enseignant</h2><form method='post'><br><br>
		<input type='hidden' value='Modifier' name='modifier'>
		<input type='text' name='enseignant'>
		<input type='submit' name='rechercher' value='rechercher' placeholder='Ecrivez le code de l'ensegnant'>
		</form><br>";
	if(isset($_POST["rechercher"])){
		$enseignant=$_POST["enseignant"];
		if(empty($enseignant)){
			echo "Ecrivez le code de l'enseignant";
		} else{
			$conn=oci_connect("usrecole","oracle","127.0.0.1/XE");
			$selection=oci_parse($conn,"select * from profs WHERE NOPROF='$enseignant'");
			oci_execute($selection);	
			$nbrows=oci_fetch_all($selection,$resultats);
			if($nbrows > 0){
				echo "<h3> Formulaire de modification dun enseignant </h3>
				<form method='post'>
				<input type='hidden' value='".$enseignant."' name='enseignant'>
				<input type='hidden' value='Modifier' name='modifier'>
				<input type='hidden' value='Recherche' name='rechercher'>
				<table align ='center'>";
				for ($i=0;$i<$nbrows;$i++){
					echo " <tr><td>Code</td> <td><input name='codeprof' value='".$resultats['NOPROF'][$i]."'></td></tr>";
					echo " <tr><td>Nom </td> <td><input name='nomprof' value='".$resultats['NOMPROF'][$i]."'></td></tr>";
					echo "<tr><td>Prenom </td> <td> <input name='prenomprof' value='".$resultats['PRENOMPROF'][$i]."'></td></tr>";
					echo "<tr><td>Telephone </td> <td> <input name='telprof' value='".$resultats['TELPROF'][$i]."'></td></tr>";
					echo "<tr><td>Chemin de la Photo</td> <td> <input name='photoprof' value='".$resultats['PHOTO'][$i]."'></td></tr>";
					echo "<tr><td>Password</td> <td> <input name='passwordprof' value='".$resultats['PASSWORD'][$i]."'></td></tr>";
					}
					echo "<tr><td align='right' colspan='2'><input type='submit' name='sauvegarde4' value='Sauvegarde'></td></tr>
				</table>
				</form>";
		
				if(isset($_POST["sauvegarde4"])){
				$codeprof=$_POST["codeprof"];
				$nomprof=$_POST["nomprof"];
				$prenomprof=$_POST["prenomprof"];			
				$telprof=$_POST["telprof"];		
				$photoprof=$_POST["photoprof"];
				$passwordprof=$_POST["passwordprof"];
					//3) requete
					$conn=oci_connect("usrecole","oracle","127.0.0.1/XE");
					$modification=oci_parse($conn,"UPDATE profs SET NOPROF='$codeprof',NOMPROF='$nomprof',PRENOMPROF='$prenomprof',TELPROF='$telprof',PHOTO='$photoprof',PASSWORD='$passwordprof'
						WHERE NOPROF='$codeprof'");
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
				echo "Enseignant non trouvé"; }
		}	
	}
} 
?>

<?php
//SUPPRESSION 
if(isset($_POST["supprimer"])){ 
	echo "<h2 align=center>SUPPRESSION DUN ENSEIGNANT</h2><form method='post'>
		<input type='hidden' value='supprimer' name='supprimer'>
		<input type='text' name='enseignant'>
		<input type='submit' name='rechercher4' value='rechercher' placeholder='Ecrivez le nom ou le code du cours à modifier'>
		</form><br>";
	if(isset($_POST["rechercher4"])){
		$enseignant=$_POST["enseignant"];
		if(empty($enseignant)){
			echo "Ecrivez le code de l'enseignant";
		
		} else{
			$conn=oci_connect("usrecole","oracle","127.0.0.1/XE");
			$selection=oci_parse($conn,"select * from profs WHERE NOPROF='$enseignant'");
			oci_execute($selection);	
			$nbrows=oci_fetch_all($selection,$resultats);
			if($nbrows > 0){
				echo "<h3> Voulez-vous supprimer l'enseignant ".$enseignant."</h3>
				<form method='post'>
				<input type='hidden' value='".$enseignant."' name='enseignant'>
				<input type='hidden' value='Supprimer' name='supprimer'>
				<input type='hidden' value='rechercher' name='rechercher4'>
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
					$suppression=oci_parse($conn,"DELETE from profs WHERE NOPROF='$enseignant'");
					$selection=oci_parse($conn,"SELECT * from profs WHERE NOPROF='$enseignant'");
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
					
					if(isset($_POST["oui2"])){
					}
				
				//5) fermeture de la connexion
				}
			}
		}	
	}
?>

