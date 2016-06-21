<?php
	if ($_SERVER ['REQUEST_METHOD'] == 'GET') {
		$dsn = "mysql:host=localhost;dbname=WEB";
		$db = new PDO ( $dsn, 'root' );
		$db->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	
		try {
			$response = array();
	
			$state = $db->prepare ( 'DELETE FROM CATALOG WHERE SEQNO = :SEQNO' );
			$state->bindValue ( ':SEQNO', $_GET ['seqno'] );
			$state->execute ();
			
			$response['info'] = 'Success !';
			echo json_encode($response);
		} catch ( PDOException $e ) {
			$response['info'] = 'Fail !<br>' . implode ( '<br>', $state->errorInfo () );
			echo json_encode($response);
		}
	}
?>