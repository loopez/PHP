<?php
	//demarrage de la session 
	if(!session_id())
	{
		session_start();
	}
	echo "Bonjour";
	echo $_SESSION['login'];  
	echo $_SESSION['password'];  
?>

oci_close($conn);
