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
if(isset($_POST['form_course'])) {

	try {
	
		if(empty($_POST['course_title'])) {
			throw new Exception('course_title can not be empty');
		}
		
		if(empty($_POST['course_id'])) {
			throw new Exception('col_1 can not be empty');
		}
		
		if(empty($_POST['section'])) {
			throw new Exception('section can not be empty');
		}
		
		if(empty($_POST['std_reg'])) {
			throw new Exception('std_reg can not be empty');
		}
		
		if($_POST['std_reg']<0) {
			throw new Exception('std_reg can not be negative!');
		}
		if(empty($_POST['tech_name'])) {
			throw new Exception('tech_name can not be empty');
		}
		if(empty($_POST['batch_no'])) {
			throw new Exception('batch_no can not be empty');
		}
		$course_details = $db->prepare("select * from tb_course where course_id=? and section=?");
		$course_details->execute(array($_POST['course_id'],$_POST['section']));
		$course_details = $course_details->rowCount();
		if($course_details > 0)
		{
			throw new Exception('Same Section and Course already exist!');	
		}
		
		//$result = mysql_query("insert into tbl_student (st_name,st_roll,st_age,st_email) values('$_POST[st_name]','$_POST[st_roll]','$_POST[st_age]','$_POST[st_email]') ");
		
		$statement = $db->prepare("insert into tb_course (course_title,course_id,section,std_reg,tech_name,batch_no) values(?,?,?,?,?,?)");
		$statement->execute(array($_POST['course_title'],$_POST['course_id'],$_POST['section'],$_POST['std_reg'],$_POST['tech_name'],$_POST['batch_no']));
		
		$statement = $db->prepare("insert into tb_block_course (course_id, section, batch_no, status) values(?,?,?,?)");
		$statement->execute(array($_POST['course_id'],$_POST['section'],$_POST['batch_no'],'0'));
		
		$success_message = 'Data has been inserted successfully.';
		header('location: course_wise_registration.php');
	
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
    <title>Insert Couse::Exam Hall Manager</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="bootstarap/css/bootstrap.css" type="text/css">
    <link rel="icon" href="images/tf.png" type="image/png" sizes="16x16">
    <script src="bootstarap/js/jquery-3.0.0.min.js"></script>
    <script src="bootstarap/js/bootstrap.min.js"></script>
  </head>
<body class="w3-light-grey w3-content" style="max-width:1600px">
 <div class="container">
 <div class="row">
  <nav class="navbar-default navbar-static-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
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
						<li ><a href="batch_info.php">Batch<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon"></span></a></li>
						<li> <a href="insert_batch_info.php">Insert Batch <span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon "></span></a>
						<li> <a href="insert_room_info.php">Insert room <span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon "></span></a>        
						<li ><a href="insert_routine.php">Insert Routine<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon "></span></a></li>        
						<li class="active"><a href="insert_course_info.php">Insert Courses<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon"></span></a></li>
						<li ><a href="#">Log off<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon"></span></a></li>
					  </ul>
					</div>
				</div>
			</nav>
	<!-- ENDOF LEFT LIST-->
			<div class="col-md-9 col-sm-4">
			<div class="panel panel-default">
			<div class="panel-heading">Insert Course Information</div>
			<div class="panel-body">
			<form action="" method="post">
				<div class="form-group row">
				  <label for="example-text-input" class="col-xs-4 col-form-label">Course Name</label>
				  <div class="col-xs-8">
					<input class="form-control" type="text" name="course_title" placeholder ="Enter course name" id="example-text-input">
				  </div>
				</div>
				<div class="form-group row">
				  <label for="example-text-input" class="col-xs-4 col-form-label">Course ID</label>
				  <div class="col-xs-8">
					<input class="form-control" type="text" name="course_id" placeholder ="Enter course id" id="example-text-input">
				  </div>
				</div>
				
				<div class="form-group row">
				  <label for="example-text-input" class="col-xs-4 col-form-label">Section</label>
				  <div class="col-xs-8">
					<input class="form-control" type="text" name="section" placeholder ="Enter Section" id="example-text-input">
				  </div>
				</div>
				<div class="form-group row">
				  <label for="example-text-input" class="col-xs-4 col-form-label">Registered Students</label>
				  <div class="col-xs-8">
					<input class="form-control" type="number" name="std_reg" placeholder ="Total number of registered students" id="example-text-input">
				  </div>
				</div>
				<div class="form-group row">
				  <label for="example-text-input" class="col-xs-4 col-form-label">Teacher Initials</label>
				  <div class="col-xs-8">
					<input class="form-control" type="text" name="tech_name" placeholder ="Enter teacher initials" id="example-text-input">
				  </div>
				</div>
				<div class="form-group row">
				  <label for="example-text-input" class="col-xs-4 col-form-label">Batch no.</label>
				  <div class="col-xs-8">
					<input class="form-control" type="text" name="batch_no" placeholder ="Enter Batch number" id="example-text-input">
				  </div>
				</div>
				</div>
				</div>
				<div class="form-group">
				<button for="example-time-input" type="submit" name="form_course" class="col-xs-3 btn btn-success">Save</button>
				</div>
				</form>
			</div>
		</div>
		<!-- Overlay effect when opening sidenav on small screens -->
        <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

         <!-- !PAGE CONTENT! -->
        <div class="w3-main" style="margin-left:300px">

            
        </div>
        </div>
		</div>
    </div>
  </div>
</body>
</html>