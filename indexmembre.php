<?php
	//demarrage de la session 
	if(!session_id())
	{
		session_start();
	}
	echo "Bonjour";
	echo $_SESSION['adresse'];  
?>

oci_close($conn);
