<?php
	session_start();
	if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['user']) && !empty($_POST['pwd'])){

		$dsn = "mysql:host=localhost;dbname=WEB";
		$db = new PDO ( $dsn, 'root' );
		$db->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		
		$state = $db->prepare ( 'SELECT * FROM USER WHERE ACCOUNT = :ACCOUNT AND PASSWORD = :PASSWORD' );
		$state->bindValue(':ACCOUNT', $_POST['user']);
		$state->bindValue(':PASSWORD', md5($_POST['pwd']));
		$state->execute();
		echo md5($_POST['pwd']);
		$rs = $state->fetchAll(PDO::FETCH_ASSOC);
		
		if(count($rs) == 1){
			$_SESSION['id'] = $rs[0]['ID'];
			$_SESSION['user'] = $rs[0]['ACCOUNT'];
			$_SESSION['admin'] = $rs[0]['IS_ADMIN'];
			header("Location: ../main.php");
		}else{
			header("Location: ../index.php");
		}
	}else{
		header("Location: ../index.php");
		
	}

	
	
	
?>