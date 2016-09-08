<?php
//demarrage de la session 
	if(!session_id())
	{
		session_start();
	}
	$conn=oci_connect("usrecole","oracle","127.0.0.1/XE");

		$etudiant=$_SESSION['logine'];
		$selection=oci_parse($conn,"select PRENOMETUD, NOMETUD, 
		DATENAISSANCE,TELETUD,LENO,RUE,VILLE,CODEPOSTAL,
		PROVINCE, NOGROUPE	
		FROM etudiants WHERE CODEPERMANENT='$etudiant' ");			
		oci_execute($selection);
		//4) analyse et affichage des resultats
		$nbrows=oci_fetch_all($selection,$resultats);
		for ($i=0;$i<$nbrows;$i++){
			$nom=$resultats['NOMETUD'][$i];
			$prenom=$resultats['PRENOMETUD'][$i];
			$date=$resultats['DATENAISSANCE'][$i];
			$tel=$resultats['TELETUD'][$i];
			$no=$resultats['LENO'][$i];
			$rue=$resultats['RUE'][$i];
			$ville=$resultats['VILLE'][$i];
			$code=$resultats['CODEPOSTAL'][$i];
			$province=$resultats['PROVINCE'][$i];
			$groupe=$resultats['NOGROUPE'][$i];
			}
?>
<br><br>
<table border='0' align="center" width='80%'>
	<tr>
		<td style='border: 1px solid #999;padding:0.5rem;'align="center"><img height='35%' width='35%' src='/IMAGES/me.jpg'></td>
		<td style='border: 1px solid #999;padding:0.5rem;'colspan="3" align="left"><h2>Bienvenue <?php echo "$prenom $nom";?> </h2></td>
		<td style='border: 1px solid #999;padding:0.5rem;'><h3>GROUPE <?php echo "$groupe";?></h3> </td>
	</tr>
	<tr>
		<td style='border: 1px solid #999;padding:0.5rem;' align="left"><h3> PRENOM </h3></td>
		<td style='border: 1px solid #999;padding:0.5rem;' align="left"><h3> NOM </h3></td>
		<td style='border: 1px solid #999;padding:0.5rem;' align="left"><h3> DATE DE NAISSANCE </h3></td>
		<td style='border: 1px solid #999;padding:0.5rem;' align="left"><h3> TELEPHONE </h3></td>
		<td style='border: 1px solid #999;padding:0.5rem;' align="left"><h3> ADRESSE </h3></td>
		</tr>
	<tr>
		<td style='border: 1px solid #999;padding:0.5rem;' ><?php echo $prenom; ?></td>
		<td style='border: 1px solid #999;padding:0.5rem;'><?php echo $nom; ?></td>
		<td style='border: 1px solid #999;padding:0.5rem;'><?php echo $date; ?></td>
		<td style='border: 1px solid #999;padding:0.5rem;'><?php echo $tel; ?></td>
		<td style='border: 1px solid #999;padding:0.5rem;'><?php echo $no." ".$rue."<br>".$ville." ".$province." ".$code; ?></td>
	</tr>
</table>


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
		echo "<br><table width='80%' align='center' border='1'>
			<tr><td width:25%;>PHOTO</td><td width:25%;>NOM ETUDIANT</td><td>PRENOM ETUDIANT</td><td>COURS</td><td>SESSION</td><td>NOTE</td></tr>";
		for ($i=0;$i<$nbrows;$i++){
			echo "
			<tr><td width:25%;><img height='50%' width='50%' src=".$resultats['PHOTO'][$i]."></td>
			<td width:25%;>".$resultats['NOMETUD'][$i]."</td><td width:25%;>".$resultats['PRENOMETUD'][$i]."</td><td>".$resultats['NOMCOURS'][$i]."</td>
			<td>".$lasession."</td><td>".$resultats['NOTEFINALE'][$i]."</td></tr>";
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

