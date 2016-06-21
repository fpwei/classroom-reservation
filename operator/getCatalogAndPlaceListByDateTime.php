<?php
if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
	
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
		$state = $db->prepare ( 'SELECT P.SEQNO, P.DISPLAY_NAME, P.CATALOG_SEQNO  
								 FROM PLACE P 
				                 LEFT JOIN (
									SELECT *
									FROM SCHEDULE 
									WHERE DATE = STR_TO_DATE(:DATE, \'%Y-%m-%d\')
								 ) S 
				                 ON P.SEQNO = S.PLACE_SEQNO 
								 JOIN CATALOG C
								 ON P.CATALOG_SEQNO = C.SEQNO
								 WHERE (S.DATE IS NULL OR ('.$condition.')) 
								 AND P.IS_ACTIVITY = 1
								 AND C.IS_ACTIVITY = 1' );
		$state->bindValue ( ':DATE', $_POST ['date'] );
		$state->execute ();
		
		
		$rsp = $state->fetchAll ( PDO::FETCH_ASSOC );
		
		$response = '<option value="-1"></option>';
		$carr = array();
		foreach ( $rsp as $p ) {
			$response .= '<option value="' . $p ['SEQNO'] . '">' . $p ['DISPLAY_NAME'] . '</option>';
			$carr[$p ['CATALOG_SEQNO']] = 'nocare';
		}
		
		$condition="";
		foreach($carr as $seqno => $nocare){
			$condition .= "SEQNO = ".$seqno." OR ";
		}
		
		$condition = rtrim($condition,' OR ');
		$state = $db->prepare ( 'SELECT SEQNO, DISPLAY_NAME FROM CATALOG WHERE IS_ACTIVITY = \'1\' AND ('.$condition.')' );
		$state->execute ();
		
		$rsc = $state->fetchAll ( PDO::FETCH_ASSOC );
		$response .= ',<option value="-1"></option>';
		foreach ( $rsc as $c ) {
			$response .= '<option value="' . $c ['SEQNO'] . '">' . $c ['DISPLAY_NAME'] . '</option>';
		}
		
		echo $response;//placelist,cataloglist
	}else{
		$state = $db->prepare ( 'SELECT SEQNO, DISPLAY_NAME FROM CATALOG  WHERE IS_ACTIVITY = 1' );
		$state->execute ();
		$catalog_arr = $state->fetchAll ( PDO::FETCH_ASSOC );
		
		$catalogList='<option value="-1"></option>';
		foreach ( $catalog_arr as $catalog ) {
			$catalogList .= '<option value="' . $catalog ['SEQNO'] . '">' . $catalog ['DISPLAY_NAME'] . '</option>';
		}
		
		
		$state = $db->prepare ( 'SELECT P.SEQNO, P.DISPLAY_NAME 
						 FROM PLACE P 
		                 JOIN CATALOG C 
						 ON P.CATALOG_SEQNO = C.SEQNO 
						 WHERE C.IS_ACTIVITY = 1 AND P.IS_ACTIVITY = 1' );
		$state->execute ();
		$place_arr = $state->fetchAll ( PDO::FETCH_ASSOC );
		
		$placeList='<option value="-1"></option>';
		foreach ( $catalog_arr as $catalog ) {
			$placeList .= '<option value="' . $catalog ['SEQNO'] . '">' . $catalog ['DISPLAY_NAME'] . '</option>';
		}
		
		echo $placeList.','.$catalogList;
	}
}

?>