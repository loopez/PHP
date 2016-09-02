<h2 align ="center">Branchez-vous membre! </h2>
<form method="post" action="index.php?lien=login">
	<table align ="center">
	
	<tr><td>login</td><td><input type="text" name="login" value=""></td></tr>
	<tr><td>password</td><td><input type="password" name="password" value=""></td></tr>
	<tr><td colspan="2"><input type="submit" name="entrer" value="entrer"> <a href="index.php?lien=nonmembre">Inscription</td></tr>
	
	</table>
</form>
<h2 align ="center">Administrateur </h2>
<form method="post">
	<table align ="center">
	
	<tr><td>loginadmin</td><td><input type="text" name="loginadmin" value=""></td></tr>
	<tr><td>passwordadmin</td><td><input type="password" name="passwordadmin" value=""></td></tr>
	<tr><td colspan="2"><input type="submit" name="entreradmin" value="entrer"></td></tr>
	
	</table>
</form>
<?php
//traitement des membres
if(isset($_POST["entrer"]))
{		
	//1)Recuperation par POST
	$login=$_POST["login"];
	$password=$_POST["password"];
	//2)Connexion avec ORACLE
	$conn=oci_connect("system","oracle","127.0.0.1/XE");
	if(!$conn)
	{
	echo "Echec de Connexion";
	}
	else
	{
	//3) requete
	$selection=oci_parse($conn,"select * from membre where login='$login' and password='$password'");
	oci_execute($selection);
	//4) analyse et affichage des resultats
	$nbrows=oci_fetch_all($selection,$resultats);
	if ($nbrows >0)
	{
		for ($i=0;$i<$nbrows;$i++)
		{
			$_SESSION["numero"]=$resultats['NUMERO'][$i];
			$_SESSION["telephone"]=$resultats['TELEPHONE'][$i];
			$_SESSION["adresse"]=$resultats['ADRESSE'][$i];
			echo $resultats['ADRESSE'][$i];  
		}	
	//Rediriger vers la page membre.php	
	
	$ip=$_SERVER["SERVER_ADDR"];
	echo"<script>window.location.href='http://localhost/indexmembre.php';</script>";
	}
	else
	{
		echo "Login et /ou mot de passe incorrect";		
	}

	
	}
}	


//traitement de ADMIN		
if(isset($_POST["entreradmin"]))
{		
//1)Recuperation par POST
	$login=$_POST["loginadmin"];
	$password=$_POST["passwordadmin"];
	//2)Connexion avec ORACLE
	$conn=oci_connect("system","oracle","127.0.0.1/XE");
	if(!$conn)
	{
	echo "Echec de Connexion";
	}
	else
	{
	//3) requete
	$selection=oci_parse($conn,"select * from administrateur where login='$login' and password='$password'");
	oci_execute($selection);
	//4) analyse et affichage des resultats
	$nbrows=oci_fetch_all($selection,$resultats);
	if ($nbrows >0)
	{
		for ($i=0;$i<$nbrows;$i++)
		{
			$_SESSION["login"]=$resultats['LOGIN'][$i];
			$_SESSION["password"]=$resultats['PASSWORD'][$i];
			echo $_SESSION["login"];  
			echo $_SESSION["password"];  
		}	
	//Rediriger vers la page membre.php	
	
	$ip=$_SERVER["SERVER_ADDR"];
	echo"<script>window.location.href='http://localhost/indexadmin.php';</script>";
	}
	else
	{
		echo "Login et /ou mot de passe incorrect";		
	}
	}
}
?>
