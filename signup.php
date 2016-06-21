<?php
session_start ();
if (session_id ()) {
	session_destroy ();
	session_start ();
}

?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Insert title here</title>
<link rel="stylesheet" href="css/main.css">

<!-- jQuery library -->
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script
	src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="css/bootstrap.css">
<script type="text/javascript">
			function check(){
				if($("#user").val() && $("#pwd").val()){
				return true;
				}else{
					$("#warnModal").modal('show');
					return false;
				}
			}

		</script>
</head>

<body>
		<?php require_once 'header.php';?>
		<br>
	<br>
	<div class="row">
		<div class="col-md-4 col-sm-3 col-xs-1"></div>
		<div class="col-md-4 col-sm-6 col-xs-10">
			<form class="form-horizontal" role="form"
				action="operator/register.php" method="post"
				onsubmit="return check()">
				<div class="form-group">
					<label class="control-label col-md-4">User :</label>
					<div class="col-md-7">
						<input id="user" type="text" name="user">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-4">Password :</label>
					<div class="col-md-7">
						<input id="pwd" type="password" name="pwd">
					</div>
				</div>
					<div class="form-group">
					<div class="col-md-offset-2 col-md-6 col-sm-4 col-xs-4">
						<input class="btn btn-default form-control" type="submit"
							value="Register">
					</div>
				</div>

			</form>
		</div>
		<div class="col-md-4 col-sm-3 col-xs-1"></div>
	</div>
	
	<!-- Modal -->
	<div id="warnModal" class="modal fade" role="dialog">
		<div class="modal-dialog modal-sm">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-body">
					<p>User and Password are necessary.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>

		</div>
	</div>
</body>
</html>