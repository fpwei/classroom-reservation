<?php
session_start ();

if (empty($_SESSION ['id'])) {
	header ( "Location: index.php" );
} else {
	$dsn = "mysql:host=localhost;dbname=WEB";
	$db = new PDO ( $dsn, 'root' );
	$db->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	
	$state = $db->prepare ( 'SELECT  A.DATE, A.TIME, P.DISPLAY_NAME, 
			CASE WHEN STATUS = \'A\' THEN \'Approve\' WHEN STATUS = \'R\' THEN \'Refuse\' ELSE \'Unckeck\' END STATUS 
			FROM APPLY A JOIN PLACE P ON A.PLACE_SEQNO = P.SEQNO WHERE USER_SEQNO = :USER_SEQNO' );
	$state->bindValue(':USER_SEQNO', $_SESSION ['id']);
	$state->execute ();
	
	$rs = $state->fetchAll ( PDO::FETCH_ASSOC );
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Insert title here</title>
<!-- jQuery library -->
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script
	src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="css/bootstrap.css">
<style type="text/css">
td > a {
	margin-right: 15px;
}
</style>
</head>
<body>
<?php require_once 'header.php';?>
<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>Date</th>
					<th>Time</th>
					<th>Classroom</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			for ( $i = 1 ; $i <= count($rs) ; ++$i) {
				echo '<tr>';
				echo '<td>'.$i.'</td>';
				echo '<td>'.$rs[$i-1]['DATE'].'</td>';
				$tarr = explode(',', $rs[$i-1]['TIME']);
				$time = '';
				foreach ($tarr as $t){
					$time .= str_pad($t, 2, '0', STR_PAD_LEFT).':00~'.str_pad($t+1, 2, '0', STR_PAD_LEFT).':00, ';
				}
				
				echo '<td>'.rtrim($time,', ').'</td>';
				echo '<td>'.$rs[$i-1]['DISPLAY_NAME'].'</td>';
				echo '<td>'.$rs[$i-1]['STATUS'].'</td>';
				echo '</tr>';
			}
			
			
			?>
			</tbody>
		</table>
	</div>

</body>
</html>