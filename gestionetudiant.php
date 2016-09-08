<?php
	$conn=oci_connect("usrecole","oracle","127.0.0.1/XE");
?>


<table border='0' align="center" width='80%'>
	<tr>
		<td colspan="4" align="center"><h2>Choisissez une option</h2></td>
	</tr>
	<tr>
		<td align="center" colspan="3"><h3> Ajoutez, supprimez ou modifiez les donnees d'un etudiant</h3></td>
		<td align="center"><h3>Consultez la liste des etudiants par cours et par session</h3></td>
		</tr>
	<tr>
		<td align="center"><form method="post"><input type=submit value="Ajouter" name="ajouter" style="width:50%"></form></td>
		<td align="center"><form method="post"><input type=submit value="Modifier" name="modifier" style="width:50%"></form></td>
		<td align="center"><form method="post"><input type=submit value="Supprimer" name="supprimer" style="width:50%"></form></td>
		<td align="center"><form method="post">
		<select width='25%' name='choixsession'>
		<option>---Choisissez la session---</option>
		<?php
		$selection=oci_parse($conn,"select unique LASESSION  from inscription where LASESSION IS NOT NULL");
		oci_execute($selection);
		//4) analyse et affichage des resultats
		$nbrows=oci_fetch_all($selection,$resultats);
		for ($i=0;$i<$nbrows;$i++){
			echo "<option name='lasession' value='".$resultats['LASESSION'][$i]."'>".$resultats['LASESSION'][$i]."</option>";
			}
		?>
		</select>
		<br><br>
		<select width='25%' name='choixcours'>
		<option>---Choisissez le cours---</option>
		<?php
		$selection=oci_parse($conn,"select unique nomcours from cours where nomcours IS NOT NULL");
		oci_execute($selection);
		//4) analyse et affichage des resultats
		$nbrows=oci_fetch_all($selection,$resultats);
		for ($i=0;$i<$nbrows;$i++){
			echo "<option value='".$resultats['NOMCOURS'][$i]."'>".$resultats['NOMCOURS'][$i]."</option>";
			}
		?>	
	</select><br><br>
	<input type='submit' name="afficher2" value="Afficher">
</form></td>
	</tr>
</table>


<?php
//AJOUT
if (isset($_POST["ajouter"])){ 
	echo "<h3> Formulaire d'ajout d'un etudiant</h3>
	<form method='post'>
	<table align ='center'>
		<input type='hidden' value='Afficher' name='afficher'>
		<tr><td>Nom </td> <td> <input type='text' name='nom'></td> </tr>
		<tr><td>Prenom </td> <td> <input type='text' name='prenom'></td> </tr>
		<tr><td>Date de Naissance </td> <td> <input type='text' name='daten'></td> </tr>
		<tr><td>Telephone </td> <td> <input type='text' name='tel'></td> </tr>
		<tr><td>Numero de Rue </td> <td> <input type='text' name='no'></td> </tr>
		<tr><td>Nom de Rue </td> <td> <input type='text' name='rue'></td> </tr>
		<tr><td>Ville </td> <td> <input type='text' name='ville'></td> </tr>
		<tr><td>Code Postal </td> <td> <input type='text' name='cp'></td> </tr>
		<tr><td>Province </td> <td> <input type='text' name='province'></td> </tr>
		<tr><td>Chemin de la photo </td> <td> <input type='text' name='photo'></td> </tr>
		<tr><td>Groupe </td> <td> <input type='text' name='groupe'></td> </tr>
		<tr><td>Password </td> <td> <input type='password' name='password'></td> </tr>
	
		<tr><td colspan='2' align='right'><input type='submit' name='inscrire' value='Ajouter'></td> </tr>
	</table>
	</form>";
}
	if(isset($_POST["inscrire"])){
		//recuperation des donnees
		$nom=$_POST["nom"];
		$prenom=$_POST["prenom"];			
		$daten=$_POST["daten"];
		$tel=$_POST["tel"];		
		$no=$_POST["no"];
		$rue=$_POST["rue"];			
		$ville=$_POST["ville"];	
		$cp=$_POST["cp"];
		$province=$_POST["province"];
		$photo=$_POST["photo"];
		$groupe=$_POST["groupe"];
		$password=$_POST["password"];
		
		//2) Connexion
		$conn=oci_connect("usrecole","oracle","127.0.0.1/XE");
		if(!$conn){
			echo "Echec de Connexion";
		}
			else{
		//3) requete
			$insertion=oci_parse($conn,"insert into etudiants values(substr('$nom',1,3)||substr('$prenom',1,1)||'$daten','$nom','$prenom',to_date('$daten','dd-mm-yyyy'),'$tel','$no','$rue','$ville','$cp','$province','$photo','$groupe','$password')");
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
	echo "<h2 align=center>MODIFICATION DUN ETUDIANT</h2><form method='post'>
		<h3align=center>Ecrivez le code permanent</h2><form method='post'><br><br>
		<input type='hidden' value='Modifier' name='modifier'>
		<input type='text' name='etudiant'>
		<input type='submit' name='rechercher3' value='rechercher' placeholder='Ecrivez le nom ou le code du cours à modifier'>
		</form><br>";
	if(isset($_POST["rechercher3"])){
		$etudiant=$_POST["etudiant"];
		if(empty($etudiant)){
			echo "Ecrivez le code permanent";
		
		} else{
			$conn=oci_connect("usrecole","oracle","127.0.0.1/XE");
			$selection=oci_parse($conn,"select * from etudiants WHERE codepermanent='$etudiant'");
			oci_execute($selection);	
			$nbrows=oci_fetch_all($selection,$resultats);
			if($nbrows > 0){
				echo "<h3> Formulaire de modification dun etudiant </h3>
				<form method='post'>
				<input type='hidden' value='".$etudiant."' name='etudiant'>
				<input type='hidden' value='Modifier' name='modifier'>
				<input type='hidden' value='Recherche' name='rechercher3'>
				<table align ='center'>";
				for ($i=0;$i<$nbrows;$i++){
					echo " <tr><td>Code Permanent </td> <td><input name='code' value='".$resultats['CODEPERMANENT'][$i]."'></td></tr>";
					echo " <tr><td>Nom </td> <td><input name='nom' value='".$resultats['NOMETUD'][$i]."'></td></tr>";
					echo "<tr><td>Prenom </td> <td> <input name='prenom' value='".$resultats['PRENOMETUD'][$i]."'></td></tr>";
					echo "<tr><td>Date de Naissance </td> <td> <input name='daten' value='".$resultats['DATENAISSANCE'][$i]."'></td></tr>";
					echo "<tr><td>Telephone </td> <td> <input name='tel' value='".$resultats['TELETUD'][$i]."'></td></tr>";
					echo "<tr><td>Numero de Rue </td> <td> <input name='no' value='".$resultats['LENO'][$i]."'></td></tr>";
					echo "<tr><td>Nom de Rue </td> <td> <input name='rue' value='".$resultats['RUE'][$i]."'></td></tr>";
					echo "<tr><td>Ville</td> <td> <input name='ville' value='".$resultats['VILLE'][$i]."'></td></tr>";
					echo "<tr><td>Code Postale</td> <td> <input name='cp' value='".$resultats['CODEPOSTAL'][$i]."'></td></tr>";
					echo "<tr><td>Province</td> <td> <input name='province' value='".$resultats['PROVINCE'][$i]."'></td></tr>";
					echo "<tr><td>Chemin de la Photo</td> <td> <input name='photo' value='".$resultats['PHOTO'][$i]."'></td></tr>";
					echo "<tr><td>Groupe</td> <td> <input name='groupe' value='".$resultats['NOGROUPE'][$i]."'></td></tr>";
					echo "<tr><td>PAssword</td> <td> <input name='password' value='".$resultats['PASSWORD'][$i]."'></td></tr>";

					
					}
					echo "<tr><td colspan='2'><input type='submit' name='sauvegarde2' value='Sauvegarde'></td></tr>
				</table>
				</form>";
		
				#} else {echo "Cours non trouvé";}
				if(isset($_POST["sauvegarde2"])){
				$code=$_POST["code"];
				$nom=$_POST["nom"];
				$prenom=$_POST["prenom"];			
				$daten=$_POST["daten"];
				$tel=$_POST["tel"];		
				$no=$_POST["no"];
				$rue=$_POST["rue"];			
				$ville=$_POST["ville"];	
				$cp=$_POST["cp"];
				$province=$_POST["province"];
				$photo=$_POST["photo"];
				$groupe=$_POST["groupe"];
				$password=$_POST["password"];
					//3) requete
					$conn=oci_connect("usrecole","oracle","127.0.0.1/XE");
					$modification=oci_parse($conn,"UPDATE etudiants SET CODEPERMANENT='$code',NOMETUD='$nom',PRENOMETUD='$prenom',DATENAISSANCE='$daten',TELETUD='$tel',LENO='$no',RUE='$rue',VILLE='$ville',CODEPOSTAL='$cp',PROVINCE='$province',PHOTO='$photo',NOGROUPE='$groupe',PASSWORD='$password'
						WHERE CODEPERMANENT='$code'");
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
	echo "<h2 align=center>SUPPRESSION DUN ETUDIANT</h2><form method='post'>
		<input type='hidden' value='supprimer' name='supprimer'>
		<input type='text' name='etudiant'>
		<input type='submit' name='rechercher4' value='rechercher' placeholder='Ecrivez le nom ou le code du cours à modifier'>
		</form><br>";
	if(isset($_POST["rechercher4"])){
		$etudiant=$_POST["etudiant"];
		if(empty($etudiant)){
			echo "Ecrivez le code permanent";
		
		} else{
			$conn=oci_connect("usrecole","oracle","127.0.0.1/XE");
			$selection=oci_parse($conn,"select * from etudiants WHERE CODEPERMANENT='$etudiant'");
			oci_execute($selection);	
			$nbrows=oci_fetch_all($selection,$resultats);
			if($nbrows > 0){
				echo "<h3> Voulez-vous supprimer l'etudiant ".$etudiant."</h3>
				<form method='post'>
				<input type='hidden' value='".$etudiant."' name='etudiant'>
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
					$suppression=oci_parse($conn,"DELETE from etudiants WHERE CODEPERMANENT='$etudiant'");
					$selection=oci_parse($conn,"SELECT * from etudiants WHERE CODEPERMANENT='$etudiant'");
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

<?php
//LISTE
if (isset($_POST["afficher2"])){	
	$conn=oci_connect("usrecole","oracle","127.0.0.1/XE");
	$lasession=$_POST["choixsession"];			
	$cours=$_POST["choixcours"];
	if(!$conn)
	{
	echo "Echec de Connexion";
	}
	else
	{
	//3) requete
	$selection=oci_parse($conn,"select e.PHOTO, e.NOMETUD, e.PRENOMETUD, c.NOMCOURS
	from ETUDIANTS e JOIN(inscription i JOIN COURS c ON 
	upper(i.NOCOURS)=upper(c.NOCOURS)) ON 
	upper(e.CODEPERMANENT)=upper(i.CODEPERMANENT)
	WHERE upper(i.LASESSION)=upper('$lasession')
	AND upper(c.NOMCOURS)=upper('$cours')");
	oci_execute($selection);
	//4) analyse et affichage des resultats
	$nbrows=oci_fetch_all($selection,$resultats);
	if ($nbrows >0)
	{
		echo "<br><table width='80%' align='center' border='0'>
			<tr><td align='center' style='border: 1px solid #999;padding:0.5rem; width:20%;'>PHOTO</td>
			<td style='border: 1px solid #999;padding:0.5rem; width:20%;''>NOM ETUDIANT</td>
			<td style='border: 1px solid #999;padding:0.5rem; width:20%;'>PRENOM ETUDIANT</td>
			<td style='border: 1px solid #999;padding:0.5rem; width:20%;'>COURS</td>
			<td style='border: 1px solid #999;padding:0.5rem; width:20%;'>SESSION</td></tr>";
		for ($i=0;$i<$nbrows;$i++){
			echo "
			<tr><td align='center' style='border: 1px solid #999;padding:0rem;' width:20%;><img style='display: block; vertical-align: bottom; height:35%; width:35%' src=".$resultats['PHOTO'][$i]."></td>
			<td style='border: 1px solid #999;padding:0.5rem;' width:20%;>".$resultats['NOMETUD'][$i]."</td>
			<td style='border: 1px solid #999;padding:0.5rem;' width:20%;>".$resultats['PRENOMETUD'][$i]."</td>
			<td style='border: 1px solid #999;padding:0.5rem;' width:20%;>".$resultats['NOMCOURS'][$i]."</td>
			<td style='border: 1px solid #999;padding:0.5rem;' width:20%;>".$lasession."</td></tr>";
			}
		echo "</table>";
	}	
	else
	{
		echo "Cette inscription n'existe pas";		
	}
}
}
?>
