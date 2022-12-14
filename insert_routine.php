<?php
ob_start();
session_start();
if($_SESSION['name']!='schedule')
{
	header('location: login.php');
}
?>
<?php
include('config.php');
if(isset($_POST['form_routine'])) {

	try {
	
		if(empty($_POST['course_title'])) {
			throw new Exception('course_title can not be empty');
		}
		
		if(empty($_POST['course_id'])) {
			throw new Exception('course_id can not be empty');
		}
		
		if(empty($_POST['batch_no'])) {
			throw new Exception('batch_no can not be empty');
		}
		if(empty($_POST['date'])) {
			throw new Exception('date can not be empty');
		}
		if(empty($_POST['slot'])) {
			throw new Exception('slot can not be empty');
		}
		if(empty($_POST['start_time'])) {
			throw new Exception('start time can not be empty');
		}
		if(empty($_POST['end_time'])) {
			throw new Exception('end time can not be empty');
		}
		$st_time = $db->prepare("select * from tb_routine where course_id=? and batch_no=?");
		$st_time->execute(array($_POST['course_id'],$_POST['batch_no']));
		$r_time = $st_time->rowCount();
		if($r_time > 0){
			throw new Exception('Same Course for same Batch already exist!');
		}
		//$result = mysql_query("insert into tbl_student (st_name,st_roll,st_age,st_email) values('$_POST[st_name]','$_POST[st_roll]','$_POST[st_age]','$_POST[st_email]') ");
		
		$statement = $db->prepare("insert into tb_routine (course_title,course_id,batch_no,date,slot,start_time, end_time) values(?,?,?,?,?,?,?)");
		$statement->execute(array($_POST['course_title'],$_POST['course_id'],$_POST['batch_no'],$_POST['date'],$_POST['slot'],$_POST['start_time'],$_POST['end_time']));
		
		$success_message = 'Data has been inserted successfully.';
		echo $success_message;
		header('location: routine_view.php');
	}
	
	catch(Exception $e) {
		$error_message = $e->getMessage();
		echo $error_message;
		function do_alert($msg) 
				{
					echo '<script type="text/javascript">alert("' . $msg . '"); </script>';
				}
			do_alert($error_message);
	}
	
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Insert Routine::Exam Hall Manager</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="bootstarap/css/bootstrap.css" type="text/css">
    <link rel="icon" href="images/tf.png" type="image/png" sizes="16x16">
    <script src="bootstarap/js/jquery-3.0.0.min.js"></script>
    <script src="bootstarap/js/bootstrap.min.js"></script>
  </head>
<body class="w3-light-grey w3-content" style="max-width:1800px">
 <div class="container">
 <div class="row">
  <nav class="navbar-default navbar-static-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <a class="navbar-brand" href="#"><img src="images/tf.png" alt=""></a>
	  <div class="navbar-header">
      <a class="navbar-brand" href="#">Daffodil</a>
	   </div>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <!--<li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li> -->
		<li><a href="index.php"><span class="glyphicon glyphicon-home"></span></a></li>
		<li><a href="room_status.php">ROOM</a></li>
		<li><a href="routine_view.php">ROUTINE</a></li>
        <li><a href="summary_view.php">SUMMARY</a></li>
        <li><a href="details_view.php">DETAILS</a></li>
         <li><a href="view.php">VIEW</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
            <li><a href="settings.php" class="glyphicon glyphicon-cog" title="Settings"> </a></li>
            <li><a href="logout.php" class="glyphicon glyphicon-log-out" title="Log Out"></a></li>
            <li role="separator" class="divider"></li>
	  </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
  </div>
	<div class="row">
	<!-- lEFT LIST START -->
			<nav class="navbar navbar-default sidebar" role="navigation">
				<div class="container-fluid">
					<div class="navbar-header">
					  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					  </button>      
					</div>
					<div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
					  <ul class="nav navbar-nav">
						<li ><a href="index.php">Home<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon"></span></a></li>
						<li ><a href="room_status.php">Room Status<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon"></span></a></li>
						<li ><a href="course_wise_registration.php">Registration<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon"></span></a></li>
						<li ><a href="routine_view.php">Routine<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon"></span></a></li>
						<li ><a href="summary_view.php">Summary<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon"></span></a></li>
						<li ><a href="details_view.php">Details<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon"></span></a></li>
						<li ><a href="view.php">View<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon"></span></a></li>
						<li> <a href="insert_room_info.php">Insert room <span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon "></span></a>        
						<li class="active"><a href="insert_routine.php">Insert Routine<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon "></span></a></li>        
						<li ><a href="insert_course_info.php">Insert Courses<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon"></span></a></li>
						<li ><a href="#">Log off<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon"></span></a></li>
					  </ul>
					</div>
				</div>
			</nav>
	<!-- ENDOF LEFT LIST-->
			
			<div class="col-md-9 col-sm-4">
			<div class="panel panel-default">
			<div class="panel-heading">Insert Routine</div>
			<div class="panel-body">
			<form action="" method="post">
				<div class="form-group row">
				  <label for="example-text-input" class="col-xs-4 col-form-label">Course Name:</label>
				  <div class="col-xs-8">
					<input class="form-control" type="text" name="course_title" placeholder="Enter course name" id="example-text-input">
				  </div>
				</div>
				<div class="form-group row">
				  <label for="example-text-input" class="col-xs-4 col-form-label">Course ID:</label>
				  <div class="col-xs-8">
					<input class="form-control" type="text" name="course_id" placeholder="Enter course id" id="example-text-input">
				  </div>
				</div>
				<div class="form-group row">
				  <label for="example-text-input" class="col-xs-4 col-form-label">Batch No.</label>
				  <div class="col-xs-8">
					<input class="form-control" type="text" name="batch_no" placeholder="Enter batch number" id="example-text-input">
				  </div>
				</div>
				<?php date_default_timezone_set("Asia/Dhaka");?>
				<div class="form-group row">
				  <label for="example-date-input" class="col-xs-4 col-form-label">Date:</label>
				  <div class="col-xs-8">
					<input class="form-control" type="date" name="date" value="<?php echo date("Y-m-d");?>" id="example-date-input">
				  </div>
				</div>
				<div class="form-group row">
				  <label for="example-time-input" class="col-xs-4 col-form-label">Slot:</label>
				  <div class="col-xs-8">
					<input class="form-control" type="text" name="slot" placeholder="Enter slot" id="example-time-input">
				  </div>
				</div>
				<div class="form-group row">
				  <label for="example-time-input" class="col-xs-4 col-form-label">Start Time:</label>
				  <div class="col-xs-8">
					<input class="form-control" type="time" name="start_time" value="<?php echo date("h:i");?>" id="example-time-input">
				  </div>
				</div>
				<div class="form-group row">
				  <label for="example-time-input" class="col-xs-4 col-form-label">End Time:</label>
				  <div class="col-xs-8">
					<input class="form-control" type="time" name="end_time" value="<?php echo date("h:i");?>" id="example-time-input">
				  </div>
				</div>	
				</div>
				</div>				
				<div class="form-group">
					<button for="example-time-input" type="submit" name="form_routine" class="col-xs-3 btn btn-success">Save</button>
				</div>
			</form>
			</div>
		</div>
     </div>
</body>
</html>