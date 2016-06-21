<?php
	session_start();
	
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(!empty($_POST['place']) && !empty($_POST['date']) && !empty($_POST['time'])){
			$dsn = "mysql:host=localhost;dbname=WEB";
			$db = new PDO ( $dsn, 'root' );
			$db->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			
			try {
				$state = $db->prepare ( 'INSERT APPLY (PLACE_SEQNO, DATE, TIME, USER_SEQNO) VALUES (:PLACE_SEQNO, STR_TO_DATE(:DATE, \'%Y-%m-%d\'), :TIME, :USER_SEQNO)' );
				$state->bindValue(':PLACE_SEQNO', $_POST['place']);
				$state->bindValue(':DATE', $_POST['date']);
				$state->bindValue(':TIME', $_POST['time']);
				$state->bindValue(':USER_SEQNO', $_SESSION['id']);
				$state->execute();
				
				
				$state = $db->prepare ( 'SELECT * FROM SCHEDULE WHERE PLACE_SEQNO = :PLACE_SEQNO && DATE = STR_TO_DATE(:DATE, \'%Y-%m-%d\') ' );
				$state->bindValue(':PLACE_SEQNO', $_POST['place']);
				$state->bindValue(':DATE', $_POST['date']);
				$state->execute();
				$rs = $state->fetchAll ( PDO::FETCH_ASSOC );
				
				$tarr = explode(',',$_POST['time']);
				$col = array();
				$val = '';
				foreach ($tarr as $t){
					$col[] = str_pad($t, 2, '0', STR_PAD_LEFT).'00_'.str_pad($t+1, 2, '0', STR_PAD_LEFT).'00';
					$val .= '1,';
				}
				$val = rtrim($val,',');
				
				if (count($rs) == 0){
					$state = $db->prepare ( 'INSERT SCHEDULE (PLACE_SEQNO,DATE,'.implode(',', $col).',CREATE_USER,UPDATE_USER) VALUES (:PLACE_SEQNO,STR_TO_DATE(:DATE, \'%Y-%m-%d\'),'.$val.',\'auto\',\'auto\')' );
					$state->bindValue(':PLACE_SEQNO', $_POST['place']);
					$state->bindValue(':DATE', $_POST['date']);
					$state->execute();
				}else{
					$state = $db->prepare ( 'UPDATE SCHEDULE SET '.implode('=1,', $col).'=1,UPDATE_USER=\'auto\' WHERE PLACE_SEQNO = :PLACE_SEQNO && DATE = STR_TO_DATE(:DATE, \'%Y-%m-%d\')');
					$state->bindValue(':PLACE_SEQNO', $_POST['place']);
					$state->bindValue(':DATE', $_POST['date']);
					$state->execute();
				}
				
				
				echo '<script type="text/javascript">alert("SUCCESSFUL");window.location.replace("../main.php");</script>';
			} catch (PDOException $e){
				echo '<script type="text/javascript">alert("FAILED");console.log("'.implode('\n', $state->errorInfo()).'")</script>';
			}
		}
	}
	echo print_r($_POST);


?>