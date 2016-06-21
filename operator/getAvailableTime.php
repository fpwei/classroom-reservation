<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$dsn = "mysql:host=localhost;dbname=WEB";
		$db = new PDO ( $dsn, 'root' );
		$db->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

		$state = $db->prepare ( 'SELECT * FROM SCHEDULE WHERE DATE = STR_TO_DATE(:DATE, \'%Y-%m-%d\') AND PLACE_SEQNO = :PLACE_SEQNO' );
		$state->bindValue(':DATE', $_POST['date']);
		$state->bindValue(':PLACE_SEQNO', $_POST['place']);
		$state->execute();
		
		$result = $state->fetchAll();
		$response = "";
		if(count($result) == 1){
			$response .= $result[0]['0800_0900'] == '0'?'8,':'';
			$response .= $result[0]['0900_1000'] == '0'?'9,':'';
			$response .= $result[0]['1000_1100'] == '0'?'10,':'';
			$response .= $result[0]['1100_1200'] == '0'?'11,':'';
			$response .= $result[0]['1200_1300'] == '0'?'12,':'';
			$response .= $result[0]['1300_1400'] == '0'?'13,':'';
			$response .= $result[0]['1400_1500'] == '0'?'14,':'';
			$response .= $result[0]['1500_1600'] == '0'?'15,':'';
			$response .= $result[0]['1600_1700'] == '0'?'16,':'';
			$response .= $result[0]['1700_1800'] == '0'?'17,':'';
// 			$response .= $result[0]['1800_1900'] == '0'?'8,':'';
// 			$response .= $result[0]['1900_2000'] == '0'?'8,':'';
			
			echo rtrim($response,',');
		}else{
			echo '8,9,10,11,12,13,14,15,16,17';			
		}
		
	}



?>