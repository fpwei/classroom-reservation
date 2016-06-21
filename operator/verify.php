<?php
	if($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET['status']) && !empty($_GET['num'])){
// 		mail('fppowei@gmail.com', 'test', 'test');
		$dsn = "mysql:host=localhost;dbname=WEB";
		$db = new PDO ( $dsn, 'root' );
		$db->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		
		$state = $db->prepare ( 'SELECT PLACE_SEQNO, DATE, TIME FROM APPLY WHERE SEQNO = :SEQNO ' );
		$state->bindValue(':SEQNO', $_GET['num']);
		$state->execute ();
		$rs = $state->fetchAll ( PDO::FETCH_ASSOC );

		$date = $rs[0]['DATE'];
		$tarr = explode(',',$rs[0]['TIME']);
		$place = $rs[0]['PLACE_SEQNO'];
		
		$col = array();
		foreach ($tarr as $t){
			$col[] = str_pad($t, 2, '0', STR_PAD_LEFT).'00_'.str_pad($t+1, 2, '0', STR_PAD_LEFT).'00';
		}

		if($_GET['status'] == 'a'){
		
			$state = $db->prepare ( 'UPDATE APPLY SET STATUS=\'A\' WHERE SEQNO = :SEQNO' );
			$state->bindValue(':SEQNO', $_GET['num']);
			$state->execute ();
			
			$state = $db->prepare ( 'UPDATE SCHEDULE SET '.implode('=2,', $col).'=2,UPDATE_USER=\'auto\' WHERE PLACE_SEQNO = :PLACE_SEQNO && DATE = STR_TO_DATE(:DATE, \'%Y-%m-%d\')');
			$state->bindValue(':PLACE_SEQNO', $place);
			$state->bindValue(':DATE', $date);
			$state->execute();
			
		}elseif ($_GET['status'] == 'r'){
			$state = $db->prepare ( 'UPDATE APPLY SET STATUS=\'R\' WHERE SEQNO = :SEQNO' );
			$state->bindValue(':SEQNO', $_GET['num']);
			$state->execute ();
				
			$state = $db->prepare ( 'UPDATE SCHEDULE SET '.implode('=0,', $col).'=0,UPDATE_USER=\'auto\' WHERE PLACE_SEQNO = :PLACE_SEQNO && DATE = STR_TO_DATE(:DATE, \'%Y-%m-%d\')');
			$state->bindValue(':PLACE_SEQNO', $place);
			$state->bindValue(':DATE', $date);
			$state->execute();
		}
	}
	
	header("Location: ../management.php");


?>