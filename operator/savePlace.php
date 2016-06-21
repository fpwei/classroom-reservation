<?php
session_start ();

if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
	$dsn = "mysql:host=localhost;dbname=WEB";
	$db = new PDO ( $dsn, 'root' );
	$db->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	
	try {
		$response = array ();
		
		if (! empty ( $_POST ['seqno'] )) {
			$state = $db->prepare ( 'UPDATE PLACE SET CATALOG_SEQNO = :CATALOG_SEQNO, DISPLAY_NAME = :DISPLAY_NAME, IS_ACTIVITY = :IS_ACTIVITY, UPDATE_USER = :UPDATE_USER WHERE SEQNO = :SEQNO' );
			$state->bindValue ( ':CATALOG_SEQNO', empty ( $_POST ['catalog_seqno'] ) ? null : $_POST ['catalog_seqno'] );
			$state->bindValue ( ':DISPLAY_NAME', empty ( $_POST ['display_name'] ) ? null : $_POST ['display_name']  );
			$state->bindValue ( ':IS_ACTIVITY', $_POST ['is_activity'] );
			$state->bindValue ( ':UPDATE_USER', $_SESSION ['user'] );
			$state->bindValue ( ':SEQNO', $_POST ['seqno'] );
			$state->execute ();
		} else {
			$state = $db->prepare ( 'INSERT PLACE (CATALOG_SEQNO, DISPLAY_NAME, IS_ACTIVITY, CREATE_USER, UPDATE_USER) VALUES (:CATALOG_SEQNO, :DISPLAY_NAME, :IS_ACTIVITY, :CREATE_USER, :UPDATE_USER )' );
			$state->bindValue ( ':CATALOG_SEQNO', empty ( $_POST ['catalog_seqno'] ) ? null : $_POST ['catalog_seqno'] );
			$state->bindValue ( ':DISPLAY_NAME', empty ( $_POST ['display_name'] ) ? null : $_POST ['display_name']  );
			$state->bindValue ( ':IS_ACTIVITY', $_POST ['is_activity'] );
			$state->bindValue ( ':CREATE_USER', $_SESSION ['user'] );
			$state->bindValue ( ':UPDATE_USER', $_SESSION ['user'] );
			$state->execute ();
			
			$response ['id'] = $db->lastInsertId ();
		}
		
		$response ['info'] = 'Success !';
		echo json_encode ( $response );
	} catch ( PDOException $e ) {
		$response ['info'] = 'Fail !<br>' . implode ( '<br>', $state->errorInfo () );
		echo json_encode ( $response );
	}
}

?>