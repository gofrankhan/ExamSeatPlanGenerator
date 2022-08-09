<?php
ob_start();
session_start();
if($_SESSION['name']!='schedule')
{
	header('location: login.php');
}
?>
<?php include('config.php'); 
if(isset($_POST['form_priority'])) {

	try {
	
		if(empty($_POST['dt5_p'])) {
			throw new Exception('DT5 priority can not be empty');
		}
		
		if(empty($_POST['cseb_p'])) {
			throw new Exception('CSEB priority can not be empty');
		}
		
		if(empty($_POST['ab_p'])) {
			throw new Exception('AB priority can not be empty');
		}
		
		if(empty($_POST['mc_p'])) {
			throw new Exception('MC priority can not be empty');
		}
		
		//$result = mysql_query("insert into tbl_student (st_name,st_roll,st_age,st_email) values('$_POST[st_name]','$_POST[st_roll]','$_POST[st_age]','$_POST[st_email]') ");
		
		$statement = $db->prepare("update tb_building_priority set level=? where building_no=?");
		$statement->execute(array($_POST['dt5_p'],"DT5"));
		$statement = $db->prepare("update tb_building_priority set level=? where building_no=?");
		$statement->execute(array($_POST['cseb_p'],"CSEB"));
		$statement = $db->prepare("update tb_building_priority set level=? where building_no=?");
		$statement->execute(array($_POST['ab_p'],"AB"));
		$statement = $db->prepare("update tb_building_priority set level=? where building_no=?");
		$statement->execute(array($_POST['mc_p'],"MC"));
		$success_message = 'Data has been inserted successfully.';
		
	
	}
	
	catch(Exception $e) {
		$error_message = $e->getMessage();
	}
	
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Building Priority:Settings::Exam Hall Manager</title>
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
					   <li ><a href="exam_registration.php">Exam Registration<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon"></span></a></li>
						<li><a href="settings.php">Block Room<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon"></span></a></li>
						<li ><a href="big_room.php">Big Room<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon"></span></a></li>
						<li class="active"><a href="building_priority.php">Set Building Priority<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon"></span></a></li>
						<li ><a href="block_course.php">Block Course<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon"></span></a></li>
						<li ><a href="user_register.php">User Registration<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon"></span></a></li>
						<li ><a href="change_password.php">Change Password<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon"></span></a></li>
						<li ><a href="#">Log off<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon"></span></a></li>
					  </ul>
					</div>
				</div>
			</nav>
			<div class="col-md-9 col-sm-4">
				<form action="" method="post">
				<div class="panel panel-default">
				<div class="panel-heading">Set Priority for Each Building</div>
				<div class="panel-body">
				<?php
					$statement = $db->prepare("select * from tb_building_priority");
					$statement->execute();
					$result = $statement->fetchAll(PDO::FETCH_ASSOC);
					foreach($result as $row){
						if($row['building_no'] == "DT5")
							$p_dt5 = $row['level'];
						if($row['building_no'] == "CSEB")
							$p_cseb = $row['level'];
						if($row['building_no'] == "AB")
							$p_ab = $row['level'];
						if($row['building_no'] == "MC")
							$p_mc = $row['level'];
					}
				?>
				<div class="form-group row">
				  <label for="example-text-input" class="col-xs-4 col-form-label">Daffodil Tower 5</label>
				  <div class="col-xs-2">
					<input class="form-control" type="text" name="dt5_p" value="<?php echo $p_dt5?>" id="example-text-input">
				  </div>
				</div>
				<div class="form-group row">
				  <label for="example-text-input" class="col-xs-4 col-form-label">CSE Building</label>
				  <div class="col-xs-2">
					<input class="form-control" type="text" name="cseb_p"  value="<?php echo $p_cseb?>" id="example-text-input">
				  </div>
				</div>
				<div class="form-group row">
				  <label for="example-text-input" class="col-xs-4 col-form-label">Administrative Building</label>
				  <div class="col-xs-2">
					<input class="form-control" type="text" name="ab_p"  value="<?php echo $p_ab?>" id="example-text-input">
				  </div>
				</div>
				<div class="form-group row">
				  <label for="example-text-input" class="col-xs-4 col-form-label">Main Building</label>
				  <div class="col-xs-2">
					<input class="form-control" type="text" name="mc_p"  value="<?php echo $p_mc?>" id="example-text-input">
				  </div>
				</div>
				<label><small>* insert 1 for high priority</small></label>
				</div>
				</div>
				<div class="form-group">
					<button for="example-time-input" type="submit" name="form_priority"class="col-xs-3 btn btn-success">Save</button>
				</div>
				</form>
			</div>
			
	</div>
	<!-- ENDOF LEFT LIST-->
		<!-- Overlay effect when opening sidenav on small screens -->
        <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

         <!-- !PAGE CONTENT! -->
        <div class="w3-main" style="margin-left:300px">
            
        </div>
        </div>
		</d>
    </div>
  </div>
</body>
</html>