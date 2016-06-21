


<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>                        
	     	</button>
			<a class="navbar-brand" href="index.php">教室預約系統</a>
		</div>
		<div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav">
				<?php 
					if(!empty($_SESSION ['id'])){
						echo '<li><a href="/reservation_system/main.php">Reserve</a></li>
					<li><a href="/reservation_system/history.php">Record</a></li>';
					}
				?>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<?php
					if (!empty($_SESSION ['admin']) && $_SESSION ['admin'] == '1'){
						echo '<li><a href="/reservation_system/management.php"><span class="glyphicon glyphicon-list-alt"></span>
						Manage</a></li>';
					}
				
					if(!empty($_SESSION ['id'])){
						echo '<li><a href="/reservation_system/index.php"><span class="glyphicon glyphicon-log-out"></span>
						Logout</a></li>';
					}else{
						echo '<li><a href="/reservation_system/signup.php"><span class="glyphicon glyphicon-user"></span> Sign 
						Up</a></li> ';
					}
				
				?>
			</ul>
		</div>
	</div>
	<script type="text/javascript">
		$('a[href="'+window.location.pathname+'"]').parent().addClass("active");

	</script>
</nav>

