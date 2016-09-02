<h3> Formulaire d'inscription du membre </h3>
<form method="post">
 <table align ="center">
 <tr><td>Nom </td> <td> <input type="text" name="nom" placeholder="Entrer le nom"></td> </tr>
 <tr><td>Prenom </td> <td> <input type="text" name="prenom" placeholder="Entrer le prenom"></td> </tr>
 <tr><td>Telephone </td> <td> <input type="text" name="telephone" placeholder="Entrer le telephone"></td> </tr>
 <tr><td>Adresse </td> <td><input type="text" name="adresse" placeholder="Entrer l'adresse"></td> </tr>
 <tr><td>Date de naisssance </td> <td><input type="text" name="datenaissance" placeholder=""></td> </tr>
 <tr><td>Login </td> <td><input type="text" name="login" placeholder="Entrer le login"></td> </tr>
 <tr><td>Password </td> <td><input type="password" name="password" placeholder="Entrer le password"></td> </tr>
 <tr><td colspan="2"><input type="submit" name="inscrire" value="inscrire"></td> </tr>
 </table>
</form>
<?php
if(isset($_POST["inscrire"]))
{
	//1/0 recuperation des donnees

	$nom=$_POST["nom"];	
	$prenom=$_POST["prenom"];
	$telephone=$_POST["telephone"];
	$adresse=$_POST["adresse"];
	$naissance=$_POST["datenaissance"];
	$login=$_POST["login"];
	$password=$_POST["password"];
	
	//2) Connexion
		$conn=oci_connect("system","oracle","127.0.0.1/XE");
	if(!$conn)
	{
	echo "Echec de Connexion";
	}
	else
	{
	//3) requete
		$insertion=oci_parse($conn,"insert into membre values (substr('$nom',1,3)||substr('$prenom',1,1),'$nom','$prenom','$telephone','$adresse','$naissance','$login','$password')");
		oci_execute($insertion);
		oci_commit($conn);
	
	//4) analyse et affichage des resultats
		$enreg=oci_num_rows($insertion);
		if ($enreg >0)
		{
		echo oci_num_rows($insertion)."OK";
		}
		else
		{
		echo "KO";
		}	
	
	//5) fermeture de la connexion
	oci_close($conn); 		
	}
}
?>
