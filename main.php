<?php
session_start ();

if (empty ( $_SESSION ['id'] )) {
	header ( "Location: index.php" );
}

$dsn = "mysql:host=localhost;dbname=WEB";
$db = new PDO ( $dsn, 'root' );
$db->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

$state = $db->prepare ( 'SELECT SEQNO, DISPLAY_NAME FROM CATALOG  WHERE IS_ACTIVITY = 1' );
$state->execute ();
$catalog_arr = $state->fetchAll ( PDO::FETCH_ASSOC );

$catalogList = '<option value="-1"></option>';
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

$placeList = '<option value="-1"></option>';
foreach ( $place_arr as $place ) {
	$placeList .= '<option value="' . $place ['SEQNO'] . '">' . $place ['DISPLAY_NAME'] . '</option>';
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Insert title here</title>
<link rel="stylesheet" href="css/main.css">
<!-- Bootstrap -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="css/bootstrap.css">
<!-- jQuery library -->
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script
	src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<!-- JQuery UI -->
<link rel="stylesheet"
	href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>


<!-- moment.js -->
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>


<!-- datepicker -->
<script
	src="https://rawgit.com/Eonasdan/bootstrap-datetimepicker/master/build/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet"
	href="https://rawgit.com/Eonasdan/bootstrap-datetimepicker/master/build/css/bootstrap-datetimepicker.min.css">
<!-- chosen -->
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.js"></script>
<script src="js/chosen/prism.js"></script>

<script type="text/javascript">
			$(function() {
				$("#catalogList").chosen({disable_search_threshold: 10,no_results_text: "nothing found ...",allow_single_deselect: true});
				$("#catalogList").chosen().change(function(){
					$.post(
						"operator/getPlaceListByCatalog.php",
						{catalog: $("#catalogList").chosen().val(), date: $("#datetimepicker").val(), time: $("#time").chosen().val()},
						function(data){
							$("#placelist").empty();
					    	$("#placelist").html(data);
					    	$('#placelist').trigger("chosen:updated");
						}
					);
// 					var xhttp = new XMLHttpRequest();

// 					xhttp.onreadystatechange = function() {
// 					    if (xhttp.readyState == 4 && xhttp.status == 200) {
// 					    	$("#placelist").empty();
// 					    	$("#placelist").append(xhttp.responseText);
// 					    	$('#placelist').trigger("chosen:updated");
// 					    }
// 					    console.log(xhttp.responseText);
// 					}

// 					xhttp.open("POST", "operator/getPlaceListByCatalog.php", true);
// 					xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
// 					xhttp.send("catalog="+$("#catalogList").chosen().val()+"&date="+$("#datetimepicker").val()+"&time="+$("#time").chosen().val());	    
				});
				
				$("#placelist").chosen({disable_search_threshold: 10,no_results_text: "nothing found ..."});
				$("#placelist").chosen().change(function(){
					if($("#datetimepicker").val() == ''){
						$('#datepicker').datepicker('setDate', 1);	//tomorrow
					}else{
						$('#datepicker').datepicker('setDate', $("#datetimepicker").val());
					}
					$('.ui-datepicker-current-day').click();	//trigger setDate
				});
				
				$("#time").chosen({disable_search_threshold: 8,no_results_text: "nothing found ..."});
				$("#time").chosen().change(function(){
// 					$.post(
// 							"operator/getCatalogAndPlaceListByDateTime.php",
// 							{date: $("#datetimepicker").val(), time: $("#time").chosen().val()},
// 							function(data){
// 								$("#placelist").empty();
// 						    	$("#placelist").html(data);
// 						    	$('#placelist').trigger("chosen:updated");
// 							}
// 						);
					
					var xhttp = new XMLHttpRequest();

					xhttp.onreadystatechange = function() {
					    if (xhttp.readyState == 4 && xhttp.status == 200) {
						    var response = xhttp.responseText.split(",");
					    	$("#placelist").empty();
					    	$("#placelist").append(response[0]);
					    	$("#placelist").trigger("chosen:updated");

					    	$("#catalogList").empty();
					    	$("#catalogList").append(response[1]);
					    	$("#catalogList").trigger("chosen:updated");
					    }
					    console.log(xhttp.responseText);
					}

					xhttp.open("POST", "operator/getCatalogAndPlaceListByDateTime.php", true);
					xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xhttp.send("date="+$("#datetimepicker").val()+"&time="+$("#time").chosen().val());	  
				});
				$("#time").prop('disabled', true).trigger("chosen:updated");
				
				$("#datetimepicker").datetimepicker({
					format: 'YYYY-MM-DD',
					useCurrent: false,
					minDate: moment(),
					showClear: true,
					disabledDates: new Array(moment())
				});
				$("#datetimepicker").on("dp.change",function (e) {
			        if($("#datetimepicker").val()){
			        	$("#time").prop('disabled', false).trigger("chosen:updated");
			        }else{
			        	$("#time").val('').trigger("chosen:updated");
			        	$("#time").prop('disabled', true).trigger("chosen:updated");
			        }

		        	var xhttp = new XMLHttpRequest();

					xhttp.onreadystatechange = function() {
					    if (xhttp.readyState == 4 && xhttp.status == 200) {
						    var response = xhttp.responseText.split(",");
					    	$("#placelist").empty();
					    	$("#placelist").append(response[0]);
					    	$("#placelist").trigger("chosen:updated");

					    	$("#catalogList").empty();
					    	$("#catalogList").append(response[1]);
					    	$("#catalogList").trigger("chosen:updated");
					    }
					    console.log(xhttp.responseText);
					}

					xhttp.open("POST", "operator/getCatalogAndPlaceListByDateTime.php", true);
					xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xhttp.send("date="+$("#datetimepicker").val()+"&time="+$("#time").chosen().val());	  
				}); 
				$( "#datepicker" ).datepicker({
					minDate: 1,
					dateFormat: "yy-mm-dd",
					onSelect: function(dateText,inst){
						console.log($("#placelist").chosen().val());
						if($("#placelist").chosen().val() == "-1"){
							alert('Choose one classrrom.');
							$('#datepicker').datepicker('setDate', 1);
						} else{
							$("#available").html("");

							var xhttp = new XMLHttpRequest();

							xhttp.onreadystatechange = function() {
							    if (xhttp.readyState == 4 && xhttp.status == 200) {
								    var selectCount = 0;
								    if(xhttp.responseText != ''){	//available
								    	var response = xhttp.responseText.split(",");
								    	for(var i = 0 ; i < response.length ; ++i){
									    	var text = paddingLeft(response[i],2)+":00-"+paddingLeft((parseInt(response[i])+1),2)+":00";
								    		$("#available").append("<button class='btn btn-sm btn-default time-btn' style='margin:2px' value='"+response[i]+"'>"+text+"</button>")
									    }
				
										$(".time-btn").click(function(event){
											if($(this).hasClass('btn-default')){
												$(this).removeClass('btn-default');
												$(this).addClass('btn-success');
												$('#applyBtn').prop('disabled', false);
												selectCount++;
											}else{
												$(this).removeClass('btn-success');
												$(this).addClass('btn-default');
												selectCount--;
												if(selectCount == 0){
													$('#applyBtn').prop('disabled', true);
												}
											}
										});	
								    }
							    	$("#available").append("<br><br><br><br><br><button id='applyBtn' class='btn btn-sm btn-primary' style='margin:2px' data-toggle='modal' data-target='#myModal' disabled>APPLY</button>")
									$('#applyBtn').click(function(){
										$('#classroomApply').html("<b>Classroom : </b>" + $("#placelist option:selected").html());
										$('#dateApply').html("<b>Date : </b>" + $("#datepicker").val());
										var temp = "";
										var temp2 = "";
										for(var i = 0 ; i < $(".time-btn").length ; ++i){
											if($(".time-btn").eq(i).hasClass('btn-success')){
												temp += $(".time-btn").eq(i).html() + ",";
												temp2 += $(".time-btn").eq(i).val() + ",";
											}
										}
										$('#timeApply').html("<b>Time : </b>" + temp.replace(/,$/, ''));
										//form	
										$('#placeInput').val($("#placelist").chosen().val());
										$('#dateInput').val($("#datepicker").val());
										$('#timeInput').val(temp2.replace(/,$/, ''));
											
									});




							    	
							    }
							};

							xhttp.open("POST", "operator/getAvailableTime.php", true);
							xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
							xhttp.send("place="+$("#placelist").chosen().val()+"&date="+dateText);
						}
					}
				});
			});

			function paddingLeft(str,length){
				str = str.toString();
				return str.length < length ? paddingLeft("0" + str,length) : str; 	
			}
		</script>
</head>
<body>
	<?php require_once 'header.php';?>
	<div class="row">
		<div
			class="col-md-4 col-md-offset-2 col-sm-5 col-sm-offset-1 col-xs-12">
			<label class="control-label col-md-2" for="email">Date:</label>
			<div class="col-md-10">
				<input type='text' class="form-control" id="datetimepicker"
					onkeydown="return false" />
			</div>
		</div>
		<div class="col-md-4 col-sm-5 col-xs-12">
			<label class="control-label col-md-2" for="pwd">Time:</label>
			<div class="col-md-10">
				<select class="form-control" multiple id="time">
					<option value="8">8:00 ~ 9:00</option>
					<option value="9">9:00 ~ 10:00</option>
					<option value="10">10:00 ~ 11:00</option>
					<option value="11">11:00 ~ 12:00</option>
					<option value="12">12:00 ~ 13:00</option>
					<option value="13">13:00 ~ 14:00</option>
					<option value="14">14:00 ~ 15:00</option>
					<option value="15">15:00 ~ 16:00</option>
					<option value="16">16:00 ~ 17:00</option>
					<option value="17">17:00 ~ 18:00</option>
				</select>

			</div>
		</div>
	</div>

	<div class="row">
		<div
			class="col-md-4 col-md-offset-2 col-sm-5 col-sm-offset-1 col-xs-12">
			<label class="control-label col-md-2" for="email">Catalog:</label>
			<div class="col-md-10">
				<select data-placeholder="--choose one--"
					class="chosen-select form-control" id="catalogList">
					<?php
					echo $catalogList;
					?>
				</select>
			</div>
		</div>

		<div class="col-md-4 col-sm-5 col-xs-12">
			<label class="control-label col-md-2" for="pwd">Classroom:</label>
			<div class="col-md-10">
				<select data-placeholder="--choose one--"
					class="chosen-select form-control" id="placelist">
					<?php
					echo $placeList;
					?>
				</select>
			</div>
		</div>
	</div>


	<div class="row">
		<div
			class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div id="datepicker-container">
							<div id="datepicker-center">
								<div id="datepicker"></div>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div id="available"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-2 col-sm-3 col-xs-2"></div>
	</div>
	
	
	<!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">確認</h4>
				</div>
				<div class="modal-body">
					<p id="classroomApply"></p>
					<p id="dateApply"></p>
					<p id="timeApply"></p>
				</div>
				<div class="modal-footer">
					<form action="operator/apply.php" method="post">
						<input id="placeInput" type="text" name="place" hidden="true"> <input
							id="dateInput" type="text" name="date" hidden="true"> <input
							id="timeInput" type="text" name="time" hidden="true"> <input
							type="submit" class="btn btn-primary"></input>
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>