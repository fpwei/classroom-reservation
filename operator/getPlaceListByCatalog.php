<?php
if ($_SERVER ['REQUEST_METHOD'] == 'POST' && ! empty ( $_POST ['catalog'] )) {
	
	$dsn = "mysql:host=localhost;dbname=WEB";
	$db = new PDO ( $dsn, 'root' );
	$db->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	
	if(!empty($_POST ['date'])){
		$condition = "0800_0900 = '0' OR 0900_1000 = '0' OR 1000_1100 = '0' OR 1100_1200 = '0' OR 1200_1300 = '0' OR 
				1300_1400 = '0' OR 1400_1500 = '0' OR 1500_1600 = '0' OR 1600_1700 = '0' OR 1700_1800 = '0'";
		if(!empty($_POST ['time']) && $_POST ['time'] != 'null'){
			$tarr = explode(',',$_POST['time']);
			$condition = "";
			foreach ($tarr as $t){
				$condition .= str_pad($t, 2, '0', STR_PAD_LEFT).'00_'.str_pad($t+1, 2, '0', STR_PAD_LEFT).'00 = \'0\' AND ';
			}
			$condition = rtrim($condition,'AND ');
		}
		
		$state = $db->prepare ( 'SELECT P.SEQNO, P.DISPLAY_NAME 
								 FROM PLACE P 
				                 LEFT JOIN (
									SELECT *
									FROM SCHEDULE 
									WHERE DATE = STR_TO_DATE(:DATE, \'%Y-%m-%d\')
								 ) S 
				                 ON P.SEQNO = S.PLACE_SEQNO 
								 WHERE (P.CATALOG_SEQNO = :CATALOG_SEQNO OR :CATALOG_SEQNO = -1) 
								 AND (S.DATE IS NULL OR ('.$condition.')) AND P.IS_ACTIVITY = \'1\'' );
		$state->bindValue ( ':CATALOG_SEQNO', $_POST ['catalog'] );
		$state->bindValue ( ':DATE', $_POST ['date'] );
		$state->execute ();
	}else{
		$state = $db->prepare ( 'SELECT SEQNO, DISPLAY_NAME FROM PLACE WHERE (CATALOG_SEQNO = :CATALOG_SEQNO OR :CATALOG_SEQNO = -1) AND IS_ACTIVITY = \'1\'' );
		$state->bindValue ( ':CATALOG_SEQNO', $_POST ['catalog'] );
		$state->execute ();
	}
	
	
	$rs = $state->fetchAll ( PDO::FETCH_ASSOC );
	
	$response = '<option value="-1"></option>';
	
	foreach ( $rs as $p ) {
		$response .= '<option value="' . $p ['SEQNO'] . '">' . $p ['DISPLAY_NAME'] . '</option>';
	}
	
	echo $response;
}

?>