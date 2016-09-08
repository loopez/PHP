<?php
//demarrage de la session 
	if(!session_id())
	{
		session_start();
	}
$conn=oci_connect("usrecole","oracle","127.0.0.1/XE");
$etudiant=$_SESSION['logine'];	
		$req=oci_parse($conn,"select unique p.NOMPROF, p.PRENOMPROF 
		from PROFS p JOIN(inscription i JOIN ETUDIANTS e ON 
		upper(i.CODEPERMANENT)=upper(e.CODEPERMANENT)) ON 
		upper(p.NOPROF)=upper(i.NOPROF)
		WHERE upper(e.CODEPERMANENT)=upper('$etudiant')");
		oci_execute($req);
		$rows=oci_fetch_all($req,$result);
		
		$prof = array();
			for ($i=0;$i<$rows;$i++){
			$prof[]=$result['NOMPROF'][$i];
		}	
		
	?>
<div><br><br>
<table align="center" width='100%'>
	<tr>
		<td colspan="2" align="center"><h2>Vos cours et notes</h2></td>
	</tr>
	<td align="center"><form method="post">
		<select width='50%' name='choixsession'>
		<option>---Choisissez la session---</option>
		<?php
		//requete
		$selection=oci_parse($conn,"select unique i.LASESSION
		from inscription i JOIN ETUDIANTS e ON 
		upper(i.CODEPERMANENT)=upper(e.CODEPERMANENT) 
		WHERE upper(e.CODEPERMANENT)=upper('$etudiant')");
		
		oci_execute($selection);
		$nbrows=oci_fetch_all($selection,$resultats);
		for ($i=0;$i<$nbrows;$i++){
			echo "<option name='lasession' value='".$resultats['LASESSION'][$i]."'>".$resultats['LASESSION'][$i]."</option>";
			}
		?>
		</select></td>
		<td align="center" width='50%'><input type='submit' name="afficher" value="Afficher les notes">
</form></td>
		</table>
</div>
		
<?php		
if(isset($_POST["afficher"])){	
	$lasession=$_POST["choixsession"];
	$etudiant=$_SESSION['logine'];
	echo "<br><table><tr>
	<td style='border: 1px solid #999;padding:0.5rem;' align='center'><h3> SESSION </h3></td>
	<td style='border: 1px solid #999;padding:0.5rem;'colspan='2' align='center'><h3> COURS</h3></td>
	<td style='border: 1px solid #999;padding:0.5rem;'align='center'><h3>NOTE FINALE</h3></td>
	</tr>";
	$selection=oci_parse($conn,"SELECT UNIQUE i.LASESSION, 
	c.NOMCOURS, i.NOTEFINALE 
	from COURS c JOIN(inscription i JOIN ETUDIANTS e ON 
	upper(i.CODEPERMANENT)=upper(e.CODEPERMANENT)) ON 
	upper(c.NOCOURS)=upper(i.NOCOURS)
	WHERE upper(e.CODEPERMANENT)=upper('$etudiant')
	AND upper(i.LASESSION)=upper('$lasession') 
	");
	oci_execute($selection);
	//4) analyse et affichage des resultats
	$nbrows=oci_fetch_all($selection,$resultats);
	for($i=0;$i<$nbrows;$i++){

		echo "
			<tr>
			<td style='border: 1px solid #999;padding:0.5rem;'align='center'>".$resultats['LASESSION'][$i]."</td>
			<td style='border: 1px solid #999;padding:0.5rem;'colspan='2' align='center'>".$resultats['NOMCOURS'][$i]."</td>
			<td style='border: 1px solid #999;padding:0.5rem;'align='center'>".$resultats['NOTEFINALE'][$i]."</td
		</tr>";
		}	
	$selection=oci_parse($conn,"SELECT NOTEFINALE
	from INSCRIPTION i JOIN ETUDIANTS e ON 
	upper(i.CODEPERMANENT)=upper(e.CODEPERMANENT)
	WHERE upper(e.CODEPERMANENT)=upper('$etudiant')
	AND upper(i.LASESSION)=upper('$lasession') 
	");
	oci_execute($selection);
	//4) analyse et affichage des resultats
	$nbrows=oci_fetch_all($selection,$resultats);
	$counter=0;
	$sum=0.0;
	for($i=0;$i<$nbrows;$i++){
		$counter=$counter+1;
		$sum=$sum+$resultats["NOTEFINALE"][$i];
	}
	
		$moyenne=$sum/$counter;
			echo "
	<tr><td style='border: 1px solid #999;padding:0.5rem;'align='center' colspan='3'><h3>MOYENNE</h3></td>
	<td style='border: 1px solid #999;padding:0.5rem;' align='center'>	

	".$moyenne." 
		
	</td>
	</tr>
</table>";
}
?>


