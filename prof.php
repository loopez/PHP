<?php
//demarrage de la session 
	if(!session_id())
	{
		session_start();
	}
	$conn=oci_connect("usrecole","oracle","127.0.0.1/XE");
?>

	
	<br><br>
<table align="center" width='80%'>
	<tr>
		<td colspan="4" align="center"><h2>Choisissez une option</h2></td>
	</tr>
	<tr>
		<td align="center"><h3> Vos etudiants</h3></td>
		<td></td>
		<td align="center"><h3>Notes</h3></td>
		</tr>
	<tr>
		<td align="left"><form method="post">
		<select width='25%' name='cours'>
		<option>---Choisissez un cours---</option>
		<?php
		$prof=$_SESSION['loginp'];
		$selection=oci_parse($conn,"select unique c.NOMCOURS
	from COURS c JOIN(inscription i JOIN PROFS p ON 
	upper(i.NOPROF)=upper(p.NOPROF)) ON 
	upper(c.NOCOURS)=upper(i.NOCOURS)
	WHERE upper(p.NOPROF)=upper('$prof')");			
		oci_execute($selection);
		//4) analyse et affichage des resultats
		$nbrows=oci_fetch_all($selection,$resultats);
		for ($i=0;$i<$nbrows;$i++){
			echo "<option name='cours' value='".$resultats['NOMCOURS'][$i]."'>".$resultats['NOMCOURS'][$i]."</option>";
			}
		?>
		</select>
		<br><br>
		<input type='submit' name="afficher1" value="Afficher les etudiants">
</form></td>
	<td></td>
	
		<td align="right"><form method="post">
		<select width='25%' name='choixsession'>
		<option>---Choisissez la session---</option>
		<?php
		$selection=oci_parse($conn,"select unique i.LASESSION
		from COURS c JOIN(inscription i JOIN PROFS p ON 
		upper(i.NOPROF)=upper(p.NOPROF)) ON 
		upper(c.NOCOURS)=upper(i.NOCOURS)
		WHERE upper(p.NOPROF)=upper('$prof')");		
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
		$selection=oci_parse($conn,"select unique c.NOMCOURS
		from COURS c JOIN(inscription i JOIN PROFS p ON 
		upper(i.NOPROF)=upper(p.NOPROF)) ON 
		upper(c.NOCOURS)=upper(i.NOCOURS)
		WHERE upper(p.NOPROF)=upper('$prof')");		
		oci_execute($selection);
		//4) analyse et affichage des resultats
		$nbrows=oci_fetch_all($selection,$resultats);
		for ($i=0;$i<$nbrows;$i++){
			echo "<option value='".$resultats['NOMCOURS'][$i]."'>".$resultats['NOMCOURS'][$i]."</option>";
			}
		?>	
	</select><br><br>
	<input type='submit' name="afficher2" value="Afficher les notes">
</form></td>
	</tr>
</table>

<?php
//ETUDIANTS
if (isset($_POST["afficher1"])){	
	$conn=oci_connect("usrecole","oracle","127.0.0.1/XE");
	$cours=$_POST["cours"];
	if(!$conn)
	{
	echo "Echec de Connexion";
	}
	else
	{
	//3) requete
	$selection=oci_parse($conn,"select e.PHOTO, e.NOMETUD, e.PRENOMETUD, c.NOMCOURS, i.LASESSION
	from ETUDIANTS e JOIN(inscription i JOIN COURS c ON 
	upper(i.NOCOURS)=upper(c.NOCOURS)) ON 
	upper(e.CODEPERMANENT)=upper(i.CODEPERMANENT)
	WHERE upper(i.NOPROF)=upper('$prof')
	AND upper(c.NOMCOURS)=upper('$cours')
	ORDER BY c.NOMCOURS");
	oci_execute($selection);
	//4) analyse et affichage des resultats
	$nbrows=oci_fetch_all($selection,$resultats);
	if ($nbrows >0)
	{
		echo "<br><table width='80%' align='center' border='0'>
			<tr><td style='border: 1px solid #999; padding:0.5rem;' width:25%;>PHOTO</td>
			<td style='border: 1px solid #999;padding:0.5rem;' width:25%;>NOM ETUDIANT</td>
			<td style='border: 1px solid #999;padding:0.5rem;'>PRENOM ETUDIANT</td>
			<td style='border: 1px solid #999;padding:0.5rem;'>COURS</td></tr>";
		for ($i=0;$i<$nbrows;$i++){
			echo "
			<tr><td style='border: 1px solid #999;padding:0.5rem;' width:25%;><img height='50%' width='50%' src=".$resultats['PHOTO'][$i]."></td>
			<td style='border: 1px solid #999;padding:0.5rem;' width:25%;>".$resultats['NOMETUD'][$i]."</td>
			<td style='border: 1px solid #999;padding:0.5rem;'width:25%;>".$resultats['PRENOMETUD'][$i]."</td>
			<td style='border: 1px solid #999;padding:0.5rem;'>".$resultats['NOMCOURS'][$i]."</td></tr>";
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

<?php
//NOTES
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
	$selection=oci_parse($conn,"select e.PHOTO, e.NOMETUD, e.PRENOMETUD, c.NOMCOURS, i.NOTEFINALE
	from ETUDIANTS e JOIN(inscription i JOIN COURS c ON 
	upper(i.NOCOURS)=upper(c.NOCOURS)) ON 
	upper(e.CODEPERMANENT)=upper(i.CODEPERMANENT)
	WHERE upper(i.LASESSION)=upper('$lasession')
	AND upper(c.NOMCOURS)=upper('$cours')
	ORDER BY i.NOTEFINALE");
	oci_execute($selection);
	//4) analyse et affichage des resultats
	$nbrows=oci_fetch_all($selection,$resultats);
	if ($nbrows >0)
	{
		echo "<br><table width='100%' align='center' border='0'>
			<tr><td style='border: 1px solid #999;padding:0.5rem;' width:25%;>PHOTO</td>
			<td style='border: 1px solid #999;padding:0.5rem;' width:25%;>NOM ETUDIANT</td>
			<td style='border: 1px solid #999;padding:0.5rem;'>PRENOM ETUDIANT</td>
			<td style='border: 1px solid #999;padding:0.5rem;'>COURS</td>
			<td style='border: 1px solid #999;padding:0.5rem;'>SESSION</td>
			<td style='border: 1px solid #999;padding:0.5rem;'>NOTE</td></tr>";
		for ($i=0;$i<$nbrows;$i++){
			echo "
			<tr><td style='border: 1px solid #999;padding:0.5rem;' width:25%;><img height='50%' width='50%' src=".$resultats['PHOTO'][$i]."></td>
			<td style='border: 1px solid #999;padding:0.5rem;' width:25%;>".$resultats['NOMETUD'][$i]."</td>
			<td style='border: 1px solid #999;padding:0.5rem;' width:25%;>".$resultats['PRENOMETUD'][$i]."</td>
			<td style='border: 1px solid #999;padding:0.5rem;'>".$resultats['NOMCOURS'][$i]."</td>
			<td style='border: 1px solid #999;padding:0.5rem;'>".$lasession."</td>
			<td style='border: 1px solid #999;padding:0.5rem;'>".$resultats['NOTEFINALE'][$i]."</td></tr>";
			}
		echo "</table>";
	}	
	else
	{
		echo "Etudiants non trouvés";		
	}
}
}
?>

