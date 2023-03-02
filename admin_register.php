<?php

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["steponeverification"]) || $_SESSION["steponeverification"] && !isset($_SESSION["steptwoverification"]) || $_SESSION["steptwoverification"] !== true)
{
	header("location: index.php");
	exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$uname = $password = $cpassword = $aname = $email = $taname = $temail= $dob = "";
$uname_err = $password_err = $cpassword_err = $aname_err = $email_err = $dob_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
	if(empty(trim($_POST["uname"])))
	{
		$uname_err = "Please enter a Username.";
	}
	else
	{
		
	// Prepare a select statement
		$sql = "SELECT id FROM admin_login WHERE user_name = ?";
		
		if($stmt = mysqli_prepare($link, $sql))
		{
            // Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "s", $param_uname);
			
            // Set parameters
			$param_uname = trim($_POST["uname"]);
			
            // Attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt))
			{
				/* store result */
				mysqli_stmt_store_result($stmt);
				
				if(mysqli_stmt_num_rows($stmt) == 1)
				{
					$uname_err = "This Username is already taken.";
				} 
				else
				{
					$uname = trim($_POST["uname"]);
				}
			} 
			else
			{
				echo "Oops! Something went wrong. Please try again later.";
			}

            // Close statement
			mysqli_stmt_close($stmt);
		}
	}
    // Validate password
	if(empty(trim($_POST["password"])))
	{
		$password_err = "Please enter a Password.";     
	} 
	elseif(strlen(trim($_POST["password"])) < 8)
	{
		$password_err = "Password must have atleast 8 characters.";
	}
	elseif(!preg_match('@[0-9]@',trim($_POST["password"])))
	{
		$password_err = "Password must contain at least one number.";
	}
	elseif(!preg_match('@[A-Z]@',trim($_POST["password"])))
	{
		$password_err = "Password must contain at least one upper case letter.";
	}
	elseif(!preg_match('@[a-z]@',trim($_POST["password"])))
	{
		$password_err = "Password must contain at least one lower case letter.";
	} 
	elseif(!preg_match('@[^\w]@',trim($_POST["password"])))
	{
		$password_err = "Password must contain special character.";
	}  
	else
	{
		$password = trim($_POST["password"]);
		
	}

     // Validate confirm password
	if(empty(trim($_POST["cpassword"])))
	{
		$cpassword_err = "Please enter a  Confirm Password.";     
	} 
	else
	{
		$cpassword = trim($_POST["cpassword"]);
		if(empty($password_err) && ($password != $cpassword))
		{
			$cpassword_err = "Password did not match.";
		}
	}
    //validate staff name
	if(empty(trim($_POST["aname"])))
	{
		$aname_err = "Please enter a Staff Name.";
	}

	else
	{
		$taname=trim($_POST["aname"]);
	} 
	if(!preg_match("/^[a-zA-Z-'. ]*$/",$taname))
	{
		$aname_err = "Only letters, white space and dots are allowed.";
	} 
	
	else
	{
		$aname = trim($_POST["aname"]);
	}
	//validate email
	if (empty(trim($_POST["email"]))) 
	{
		$email_err = "Please enter a Email.";
	} 
	else 
	{
		$temail = trim($_POST["email"]);
	    // check if e-mail address is well-formed
		if (!filter_var($temail, FILTER_VALIDATE_EMAIL)) 
		{
			$email_err = "Invalid email format.";
		}
		else
		{
			$sql = "SELECT id FROM admin_login WHERE email = ?";

			if($stmt = mysqli_prepare($link, $sql))
			{
            // Bind variables to the prepared statement as parameters
				mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set parameters
				$param_email = trim($_POST["email"]);

            // Attempt to execute the prepared statement
				if(mysqli_stmt_execute($stmt))
				{
					/* store result */
					mysqli_stmt_store_result($stmt);

					if(mysqli_stmt_num_rows($stmt) == 1)
					{
						$email_err = "This Email ID is already taken.";
					} 
					else
					{
						$email = trim($_POST["email"]);
					}
				}
			}
		}
	}	
	//validate date of birth
	if (empty(trim($_POST["dob"])))
	{
		$dob_err = "Please select The Date Of Birth.";
	}
	else
	{
		$dob = trim($_POST["dob"]);
	}

  // Check input errors before inserting in database
	if(empty($uname_err) && empty($password_err) && empty($cpassword_err) && empty($aname_err) && empty($email_err) && empty($dob_err))
	{
		
        // Prepare an insert statement
		$sql = "INSERT INTO admin_login (user_name, admin_name, password, email, dob) VALUES (?, ?, ?, ?, ? )";
		
		if($stmt = mysqli_prepare($link, $sql))
		{
            // Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "sssss", $param_username, $param_aname ,$param_password, $param_email, $param_dob);
			
            // Set parameters
			$param_username = $uname;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_aname = $aname;
            $param_email = $email;
            $param_dob = $dob;
            //$param_verify_token = $verify_token;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
            {
                // Redirect to registeration page
            	echo '<script language="javascript">';
            	echo'alert("Successfully Registered."); location.href="admin_register.php"';
            	echo '</script>';
            } 
            else
            {
            	echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
    
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Registration</title>
	<meta charset="utf-8">
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
	<link rel="stylesheet" type="text/css" href="stylesheet/register.css">
	<link rel="stylesheet" type="text/css" href="bootstrap-4.5.3/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
</head>
<body>

	<!-- navbar -->

	<nav class="navbar navbar-light bg-light">
		<a class="navbar-brand" href="aregister.php">
			<img src="images/collegelogoub.png"  class="d-inline-block align-top" alt="" loading="lazy" id="collegelogo">
			<span id="header_lable">VIVEKANANDA COLLEGE - Student Personal Assessment</span>
		</a>
		<ul class="nav navbar-nav navbar-right">
			<li style="margin-top: -17px;"><a class="nav-link" href="logout.php" title="Logout"><span>Logout  </span><i class="fa fa-sign-out fa-lg"></i></a></li> 
		</ul>
	</nav>

	<!-- breadcrumb -->

	<div class="page-header">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb" id="breadcrumb">
				<li class="breadcrumb-item"><a href="admin_home.php">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Registration</li>
			</ol>
		</nav>
	</div>

	<!-- main container -->

	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="card" style="border-top:2px solid #087ec2;">
					<div class="card-header bg-light" style="height: 45px;">
						<h6 class="card-title card-text"><i class="fa fa-edit"></i> <span>Registration</span></h6>
					</div>
					<form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
						<div class="card-body">

							<!-- nav-tabs -->

							<ul class="nav nav-tabs">
								<li class="nav-item">
									<a class="nav-link active" href="admin_register.php" id="navtabs">Admin Registration</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="hand_register.php" id="cnavtabs" >Hand Registration</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="heart_register.php" id="cnavtabs">Heart Registration</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="head_register.php" id="cnavtabs">Head Registration</a>
								</li>
							</ul>

							<!-- end nav-tabs -->

							<div class="container-fluid"><br>
								<div class="row">
									<div class="col-sm-6 col-sm-6">
										<div class="card" style="border-top:2px solid #087ec2;">
											<div class="card-header bg-light" style="height: 45px;">
												<h6 class="card-title card-text" style="color:#087ec2; font-weight:bold; "><i class="fa fa-lock"></i> Admin Login Details</h6>
											</div>
											<div class="card-body" style="height: 350px">

												<!-- login details container -->

												<!-- username -->
												<div class="form-group">	
													<label style="font-size: 17px; color:dimgrey; font-weight: bold;" for="username"> <span style="color: red">* </span>User Name</label>
													<input type="text" name="uname" class="form-control <?php echo (!empty($uname_err)) ? 'is-invalid' : ''; ?> " value="<?php echo $uname; ?>" placeholder="Enter Admin Username" id="username">
													<span class="invalid-feedback"><?php echo $uname_err; ?></span>
												</div>
												<!-- password -->
												<div class="form-group">
													<label style="font-size: 17px; color:dimgrey; font-weight: bold;"  for="pwd"> <span style="color: red">* </span>Password</label>
													<input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?> " value="<?php echo $password; ?>" placeholder="Enter Password" id="pwd">
													<span class="invalid-feedback"><?php echo $password_err; ?></span>
												</div>
												<!-- confirm password -->
												<div class="form-group">
													<label style="font-size: 17px; color:dimgrey; font-weight: bold;"  for="cpwd"> <span style="color: red">* </span>Confirm Password</label>
													<input type="password" name="cpassword" class="form-control  <?php echo (!empty($cpassword_err)) ? 'is-invalid' : ''; ?> " value="<?php echo $cpassword; ?>" placeholder="Enter Confirm Password" id="cpwd">
													<span class="invalid-feedback"><?php echo $cpassword_err; ?></span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-6 col-sm-6">
										<div class="card" style="border-top:2px solid #087ec2;">
											<div class="card-header bg-light" style="height: 45px;">
												<h6 class="card-title card-text" style="color:#087ec2; font-weight:bold;"><i class="fa fa-user"></i> Admin Personal Details</h6>
											</div>
											<div class="card-body" style="height: 350px">

												<!-- personal details container -->

												<!-- Admin name -->
												<div class="form-group">
													<label style="font-size: 17px; color:dimgrey; font-weight: bold;" class="control-label" for="name"><span style="color: red">* </span>Admin Name</label>
													<input type="text" name="aname" class="form-control <?php echo (!empty($aname_err)) ? 'is-invalid' : ''; ?> " value="<?php echo $aname; ?>" id="name" placeholder="Enter Admin Name">
													<span class="invalid-feedback"><?php echo $aname_err; ?></span>
												</div>
												<!-- Date of Birth -->
												<div class="form-group">
													<label style="font-size: 17px; color:dimgrey; font-weight: bold;" class="control-label" for="dob"><span style="color: red">* </span>Date of Birth</label>
													<input type="date" name="dob" class="form-control <?php echo (!empty($dob_err)) ? 'is-invalid' : ''; ?> " value="<?php echo $dob; ?>" id="dob">
													<span class="invalid-feedback"><?php echo $dob_err; ?></span>
												</div>
												<!-- email -->
												<div class="form-group">
													<label style="font-size: 17px; color:dimgrey; font-weight: bold;" class="control-label" for="email"><span style="color: red">* </span>Email Id</label>
													<input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?> "  value="<?php echo $email; ?>" id="email" placeholder="Enter Email Id">
													<span class="invalid-feedback"><?php echo $email_err; ?></span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- button -->

						<div class="card-footer">
							<button  type="submit" class="btn btn-success" id="btnsave"><i class="fa fa-paper-plane" aria-hidden="ture"></i>&nbsp; Save</button>
							<a href="admin_home.php" class="btn btn-secondary ml-2"><i class="fa fa-home"></i>&nbsp; Home</a>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div><br>

	<div class="footer">
		<strong>Student Persona Assessment (SPA)</strong>
	</div>
</body>
</html>