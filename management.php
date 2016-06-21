<?php
session_start ();

if ($_SESSION ['admin'] != '1') {
	header ( "Location: index.php" );
} else {
	$dsn = "mysql:host=localhost;dbname=WEB";
	$db = new PDO ( $dsn, 'root' );
	$db->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	
	$state = $db->prepare ( 'SELECT A.SEQNO, A.DATE, A.TIME, P.DISPLAY_NAME, U.ACCOUNT FROM APPLY A JOIN PLACE P ON A.PLACE_SEQNO = P.SEQNO 
			JOIN USER U ON A.USER_SEQNO = U.ID WHERE STATUS = \'U\' ' );
	$state->execute ();
	
	$rs = $state->fetchAll ( PDO::FETCH_ASSOC );
	
	// query catalog
	$state = $db->prepare ( 'SELECT SEQNO, DISPLAY_NAME, IS_ACTIVITY FROM CATALOG' );
	$state->execute ();
	$catalog_arr = $state->fetchAll ( PDO::FETCH_ASSOC );
	
	$catalogList='<option value=""> --choose one--</option>';
	foreach ( $catalog_arr as $catalog ) {
		$catalogList .= '<option value="' . $catalog ['SEQNO'] . '">' . $catalog ['DISPLAY_NAME'] . '</option>';
	}
	
	// query place
	$state = $db->prepare ( 'SELECT SEQNO, DISPLAY_NAME, IS_ACTIVITY, CATALOG_SEQNO FROM PLACE ' );
	$state->execute ();
	$place_arr = $state->fetchAll ( PDO::FETCH_ASSOC );
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
td>a {
	margin-right: 15px;
}
</style>

<script type="text/javascript">
	$(document).ready(function(){
		//CATALOG
		$(document).on('click', '.save_catalog', function(event){
		    var $tr = $(this).parents('tr');
		    var id = $tr.prop('id').split('.')[0];
		    var display_name = $tr.find('input[name="display_name"]').val();
		    var is_activity = $tr.find('input[name="is_activity"]').prop("checked")?'1':'0';

		    $.post( 
                  "operator/saveCatalog.php",
                  { seqno: id, display_name: display_name, is_activity: is_activity},
                  function(data) {
                	  $('#info').html(jQuery.parseJSON(data).info);
                      $("#infoModal").modal('show');

                      if(id == ''){
      	              	$tr.attr('id',jQuery.parseJSON(data).id+'.catalog');
                      }
                  }
            );

            
		});

		$(document).on('click', '.delete_catalog', function(event){
		    var $tr = $(this).parents('tr');
		    var id = $tr.prop('id').split('.')[0];

			if(id != ''){
			    $.get( 
	                  "operator/deleteCatalog.php",
	                  { seqno: id},
	                  function(data) {
	                	  $('#info').html(jQuery.parseJSON(data).info);
	                      $("#infoModal").modal('show');
	                  }
	            );
			}

            $tr.remove();
		});
		
		$(document).on('click', '.new_catalog', function(event){
		    $(this).parents('tr').before('<tr><td></td><td><input type="text" name="display_name"></td>'+
				    						 '<td><input type="checkbox" name="is_activity"></td>'+
				    						 '<td><a class="save_catalog" href="javascript: return false;"><span class="glyphicon glyphicon-floppy-disk"></span>Save</a>'+
					'<a class="delete_catalog" href="javascript: return false;"><span class="glyphicon glyphicon-trash"></span>Delete</a></td></tr>');
		});

		//PLACE
		$(document).on('click', '.save_place', function(event){
		    var $tr = $(this).parents('tr');
		    var id = $tr.prop('id').split('.')[0];
		    var catalog_seqno = $tr.find('select').val();
		    var display_name = $tr.find('input[name="display_name"]').val();
		    var is_activity = $tr.find('input[name="is_activity"]').prop("checked")?'1':'0';

		    $.post( 
                  "operator/savePlace.php",
                  { seqno: id, catalog_seqno: catalog_seqno, display_name: display_name, is_activity: is_activity},
                  function(data) {
                	  $('#info').html(jQuery.parseJSON(data).info);
                      $("#infoModal").modal('show');

                      if(id == ''){
      	              	$tr.attr('id',jQuery.parseJSON(data).id+'.place');
                      }
                  }
            );

            
		});

		$(document).on('click', '.delete_place', function(event){
		    var $tr = $(this).parents('tr');
		    var id = $tr.prop('id').split('.')[0];

			if(id != ''){
			    $.get( 
	                  "operator/deletePlace.php",
	                  { seqno: id},
	                  function(data) {
	                	  $('#info').html(jQuery.parseJSON(data).info);
	                      $("#infoModal").modal('show');
	                  }
	            );
			}

            $tr.remove();
		});
		
		$(document).on('click', '.new_place', function(event){
		    $(this).parents('tr').before('<tr><td></td><td><select style="width:80%">'+$("#catalogList").html()+'</select></td><td><input type="text" name="display_name"></td>'+
				    						 '<td><input type="checkbox" name="is_activity"></td>'+
				    						 '<td><a class="save_place" href="javascript: return false;"><span class="glyphicon glyphicon-floppy-disk"></span>Save</a>'+
					'<a class="delete_place" href="javascript: return false;"><span class="glyphicon glyphicon-trash"></span>Delete</a></td></tr>');
		});
		
	});



</script>
</head>
<body>
<?php require_once 'header.php';?>

	<ul class="nav nav-tabs">
		<li class="active"><a data-toggle="tab" href="#verify">Verify</a></li>
		<li><a data-toggle="tab" href="#catalog">Catalog</a></li>
		<li><a data-toggle="tab" href="#place">Place</a></li>
	</ul>
	<div class="tab-content">
		<div id="verify" class="tab-pane fade in active">
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>#</th>
							<th>Date</th>
							<th>Time</th>
							<th>Classroom</th>
							<th>applicant</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
			<?php
			for($i = 1; $i <= count ( $rs ); ++ $i) {
				echo '<tr>';
				echo '<td>' . $i . '</td>';
				echo '<td>' . $rs [$i - 1] ['DATE'] . '</td>';
				$tarr = explode ( ',', $rs [$i - 1] ['TIME'] );
				$time = '';
				foreach ( $tarr as $t ) {
					$time .= str_pad ( $t, 2, '0', STR_PAD_LEFT ) . ':00~' . str_pad ( $t + 1, 2, '0', STR_PAD_LEFT ) . ':00, ';
				}
				
				echo '<td>' . rtrim ( $time, ', ' ) . '</td>';
				echo '<td>' . $rs [$i - 1] ['DISPLAY_NAME'] . '</td>';
				echo '<td>' . $rs [$i - 1] ['ACCOUNT'] . '</td>';
				echo '<td><a href="operator/verify.php?status=a&num=' . $rs [$i - 1] ['SEQNO'] . '"><span class="glyphicon glyphicon-ok"></span>Approve</a> 
					<a href="operator/verify.php?status=r&num=' . $rs [$i - 1] ['SEQNO'] . '"><span class="glyphicon glyphicon-remove"></span>Refuse</a></td>';
				echo '</tr>';
			}
			
			?>
			</tbody>
				</table>
			</div>
		</div>
		<div id="catalog" class="tab-pane fade in">
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>#</th>
							<th>Display Name</th>
							<th>Enable</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					<?php
						for($i = 1; $i <= count ( $catalog_arr ); ++ $i) {
							$id = $catalog_arr [$i - 1] ['SEQNO'] . '.catalog';
							echo '<tr id=' . $id . '>';
							echo '<td>' . $i . '</td>';
							echo '<td><input type="text" name="display_name" value="' . $catalog_arr [$i - 1] ['DISPLAY_NAME'] . '"></td>';
							echo '<td><input type="checkbox" name="is_activity" ' . ($catalog_arr [$i - 1] ['IS_ACTIVITY'] == '1' ? 'checked' : '') . '></td>';
							echo '<td><a class="save_catalog" href="javascript: return false;"><span class="glyphicon glyphicon-floppy-disk"></span>Save</a>'.
								'<a class="delete_catalog" href="javascript: return false;"><span class="glyphicon glyphicon-trash"></span>Delete</a></td>';
							echo '</tr>';
						}
						echo '<tr><td/><td/><td/><td><a class="new_catalog" href="javascript: return false;"><span class="glyphicon glyphicon-plus"></span>New</a></tr>'
					?>
					</tbody>
				</table>
			</div>
		</div>
		<div id="place" class="tab-pane fade in">
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>#</th>
							<th>Catalog</th>
							<th>Display Name</th>
							<th>Enable</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					<?php
						for($i = 1; $i <= count ( $place_arr ); ++ $i) {
							$id = $place_arr [$i - 1] ['SEQNO'] . '.place';
							
							echo '<tr id=' . $id . '>';
							echo '<td>' . $i . '</td>';
							echo '<td><select name="'.$place_arr [$i - 1] ['CATALOG_SEQNO'].'" style="width:80%">'.$catalogList.'</select></td>';
							echo '<td><input type="text" name="display_name" value="' . $place_arr [$i - 1] ['DISPLAY_NAME'] . '"></td>';
							echo '<td><input type="checkbox" name="is_activity" ' . ($place_arr [$i - 1] ['IS_ACTIVITY'] == '1' ? 'checked' : '') . '></td>';
							echo '<td><a class="save_place" href="javascript: return false;"><span class="glyphicon glyphicon-floppy-disk"></span>Save</a>'.
								'<a class="delete_place" href="javascript: return false;"><span class="glyphicon glyphicon-trash"></span>Delete</a></td>';
							echo '</tr>';
						}
						echo '<tr><td/><td/><td/><td/><td><a class="new_place" href="javascript: return false;"><span class="glyphicon glyphicon-plus"></span>New</a></tr>'
					?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- Info Modal -->
	<div id="infoModal" class="modal fade" role="dialog">
		<div class="modal-dialog modal-sm">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-body" style="padding: 0">
					<div class="panel panel-info" style="margin: 0">
						<div class="panel-heading">Infomation</div>
						<div class="panel-body">
							<p id="info"></p>
							<div style="text-align: right;">
								<button type="button" class="btn btn-default btn-sm"
									data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
	<?php 
		echo '<label id="catalogList" hidden="true">'.$catalogList.'</label>';
	?>
	<script type="text/javascript">
		$('select').each(function(){
			console.log($(this).attr('name'));
			$(this).val($(this).attr('name'));
		})

	</script>
</body>
</html>