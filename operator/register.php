<?php

if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['user']) && !empty($_POST['pwd'])){
	$dsn = "mysql:host=localhost;dbname=WEB";
	$db = new PDO ( $dsn, 'root' );
	$db->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	
	$state = $db->prepare ( 'SELECT * FROM USER WHERE ACCOUNT = :ACCOUNT' );
	$state->bindValue(':ACCOUNT', $_POST['user']);
	$state->execute();
	
	$rs = $state->fetchAll(PDO::FETCH_ASSOC);
	
	if(count($rs) == 1){
		echo '<script type="text/javascript">alert("user has exist.");window.location.replace("../signup.php");</script>';
	}else{
		$state = $db->prepare ( 'INSERT USER (ACCOUNT, PASSWORD) VALUES(:ACCOUNT, :PASSWORD)' );
		$state->bindValue(':ACCOUNT', $_POST['user']);
		$state->bindValue(':PASSWORD', md5($_POST['pwd']));
		$state->execute();
		header("Location: ../index.php");
	}
	
}else{
	header("Location: ../index.php");
}


?>