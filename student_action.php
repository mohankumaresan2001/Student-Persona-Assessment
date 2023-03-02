<?php
 // Initialize the session
 session_start();
 
 // Check if the user is logged in, if not then redirect him to login page
 if(!isset($_SESSION["steponeverification"]) || $_SESSION["steponeverification"] && !isset($_SESSION["steptwoverification"]) || $_SESSION["steptwoverification"] !== true)
 {
     header("location: index.php");
     exit;
 }

?>
<!DOCTYPE html>
<html>
<head>
	<title>Student Actions</title>
	<meta charset="utf-8">
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>

.navbar
{
	height: 50px;
	padding-bottom: 1px;
	border-bottom: 2px solid #087ec2;
}
#collegelogo
{
	margin-top: -11px;
	margin-left: -5px;
	height: 45px;
}
#lable
{
	font-size:20px; 
	color:#000; 
	font-weight:bold; 
	margin-top: -4px;
	float:right;
}
.page-header
{
	vertical-align: middle;
	margin: 10px ;
	padding: 0;
	border-bottom: none;
}
.breadcrumb 
{
	background: none;
}
.footer 
{
	position: fixed;
	bottom: 0;
	width: 100%;
	text-align: center;
	background: #e8e8e8;
	border-top: 1px solid #d2d6de;
	color: #087ec2;
	padding: 15px;
}
.card-header h6 i 
{
	margin-right: 8px;
}
.card-header h6
{
	font-size: 16px;
	font-weight: 700;
	display: inline-block;
	color:#057EC5;
}
.card-title-new
{
	border-bottom: 1px dotted #000000; 
	padding-bottom: 5px; 
	margin-bottom:20px;
	margin-top: 10px; 
	color:#057EC5; 
	font-size:20px;
}
.btncss
{
	height: 120px;
	width: 230px;
	font-size: 25px;
	padding-top: 36px;
}
#faicon
{
	opacity: 0.4;
	float:left;
	padding-top: 5px;
	color: white;
}
#btnlab
{
	position: absolute;
	transform: translate(-60%,0%);
	color: white;
}
</style>
<body>

	<!-- navbar -->

	<nav class="navbar navbar-light bg-light">
		<a class="navbar-brand" href="ahome.php">
			<img src="images/collegelogo.jpg"  class="d-inline-block align-top" alt="" loading="lazy" id="collegelogo">
			<span id="lable">VIVEKANANDA COLLEGE - Student Persona Assessment</span>
		</a>
		<ul class="nav navbar-nav navbar-right">
			<li style="margin-top: -17px;"><a class="nav-link" href="logout.php" title="Logout"><span>Logout  </span><i class="fa fa-sign-out fa-lg"></i></a></li> 
		</ul>
	</nav>

	<!-- breadcrumb -->

	<div class="page-header">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="admin_home.php">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Student Actions</li>
			</ol>
		</nav>
	</div>

	<!-- main container -->

	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="card" style="border-top:2px solid #087ec2;">
					<div class="card-header bg-light" style="height: 45px;">
						<h6 class="card-title card-text"><i class="fa fa-edit fa-lg"></i> <span>Student Actions</span></h6>
					</div>
					<div class="card-body">
						<h3 class="card-title card-title-new">Student Actions</h3><br>
						<a  class="btn btn-warning btn-lg btncss" href="edit_student.php" role="button" id="btnas"><i class="fa fa-edit fa-3x" aria-hidden="ture"id="faicon"></i>&nbsp; <spam id="btnlab">Edit Student</spam></a>&nbsp;&nbsp;&nbsp;&nbsp;
						<a  class="btn btn-danger btn-lg btncss" href="delete_student.php" role="button" id="btnas"><i class="fa fa-trash fa-3x" aria-hidden="ture"id="faicon"></i>&nbsp; <spam id="btnlab">Delete Student</spam></a>&nbsp;&nbsp;&nbsp;&nbsp;<br><br>
						<div style="border-bottom:2px dashed #114F81; margin-bottom:15px;"></div>
					</div>
					<div class="card-footer">
						<a href="admin_home.php" class="btn btn-secondary ml-2"><i class="fa fa-home"></i>&nbsp; Home</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	

	<!-- footer -->

	<div class="footer">
		<strong>Student Persona Assessment (SPA)</strong>
	</div>
</body>
</html>