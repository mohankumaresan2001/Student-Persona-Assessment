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
	<meta charset="utf-8">
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
	<link rel="stylesheet" type="text/css" href="stylesheet/homepage.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>Academic Achievement</title>
</head>
<style type="text/css">
	#navtabs
	{
		font-weight: bold;
	}
	#cnavtabs
	{
		color: dimgrey;
	}
</style>
<body>
	
	<!-- navbar start -->

	<nav class="navbar navbar-light bg-light">
		<a class="navbar-brand" href="ahome.php">
			<img src="images/collegelogoub.png"  class="d-inline-block align-top" alt="" loading="lazy" id="collegelogo">
			<span id="lable">VIVEKANANDA COLLEGE - Department of <?php echo htmlspecialchars($_SESSION["department"]); ?></span>
		</a>
		<ul class="nav navbar-nav navbar-right">
			<li style="margin-top: -17px;"><a class="nav-link" href="logout.php" title="Logout"><span>Logout  </span><i class="fa fa-sign-out fa-lg"></i></a></li> 
		</ul>
	</nav>

	<!-- navbar end -->

	<!-- breadcrumb start -->

	<div class="page-header">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb" id="breadcrumb">
				<li class="breadcrumb-item"><a href="head_home.php">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Academic Achievement</li>
			</ol>
		</nav>
	</div>

	<!-- breadcrumb end -->

	<!-- main container start -->

	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="card" style="border-top:2px solid #087ec2;">
					<div class="card-header bg-light" style="height: 45px;">
						<h6 class="card-title card-text"><i class="fa fa-graduation-cap fa-lg"></i> <span>Student Academic Achievement</span></h6>
					</div>
					<div class = "card-body">
					<ul class="nav nav-tabs">
								<li class="nav-item">
									<a class="nav-link active" href="update_academic_achievement.php" id="navtabs">Update Academic Achievement</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="report_academic_achievement.php" id="cnavtabs" >Academic Achievement Report</a>
								</li>
							</ul>
						<div class="container-fluid"><br>
								<div class="row justify-content-center">
									<div class="col-sm-5 col-sm-5">
										<div class="card" style="border-top:2px solid #087ec2;">
											<div class="card-header bg-light" style="height: 45px;">
												<h6 class="card-title card-text" style="color:#087ec2; font-weight:bold; "><i class="fa fa-download"></i> Import CSV File</h6>
											</div>
											<!-- import -->
											<div class="card-body" style="height: 225px">
												<form action="import_academic_achievement.php" method="post" enctype="multipart/form-data">
												<!-- batch -->
												<div class="form-group">
													<label style="font-size: 17px; color:dimgrey; font-weight: bold;" class="control-label" for="batch_code"><span style="color: red">* </span>Batch Code</label>
													<input type="text" name="batch_code" class="form-control" id="batch_code" placeholder="Enter Batch Code">
												</div>
												<div>
												<button style="float: right;" class="btn btn-danger" name="import"> <i class = "fa fa-download" aria-hidden="ture"></i>&nbsp;&nbsp;Import </button>
												</div>
												</form>
											</div>
										</div>
									</div>
									<div class="col-sm-5 col-sm-5">
										<div class="card" style="border-top:2px solid #087ec2;">
											<div class="card-header bg-light" style="height: 45px;">
												<h6 class="card-title card-text" style="color:#087ec2; font-weight:bold;"><i class="fa fa-upload"></i> Export CSV File</h6>
											</div>
											<div class="card-body" style="height: 225px">
												<form action="export_academic_achievement.php" method="post" enctype="multipart/form-data">
													<!-- export -->
													<div class="form-group">
													<label style="font-size: 17px; color:dimgrey; font-weight: bold;" class="control-label" for="batch_code"><span style="color: red">* </span>File</label>
													<input type="file" name="file" class="form-control">
												</div>
													<div>
													<button style="float: right;" class="btn btn-success" type="submit" name="export"><i class = "fa fa-upload" aria-hidden="ture"></i>&nbsp;&nbsp;Export</button>
												</div>
												</form>	
											</div>
										</div>
									</div>
								</div>
							</div>
						</div><br>
					<div class="card-footer">
						<a href="head_home.php" class="btn btn-secondary ml-2"><i class="fa fa-home"></i>&nbsp; Home</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- main container end -->

	<!-- footer -->

	<div class="footer">
		<strong>Student Persona Assessment (SPA)</strong>
	</div>
</body>
</html>