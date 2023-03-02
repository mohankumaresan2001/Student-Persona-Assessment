<?php

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$uname = $password = "";
$uname_err = $password_err = $login_err = $email = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{

    // Check if username is empty
    if(empty(trim($_POST["user_name"])))
    {
     echo '<script language="javascript">';
     echo'alert("Please enter a Username."); location.href="index.php"';
     echo '</script>';
        // $uname_err = "Please enter Username.";
 } 
 else
 {
    $uname = trim($_POST["user_name"]);
        //echo($uname);
}

    // Check if password is empty
if(empty(trim($_POST["password"])))
{

 echo '<script language="javascript">';
 echo'alert("Please enter your Password."); location.href="index.php"';
 echo '</script>';
        // $password_err = "Please enter your Password.";
} 
else
{
    $password = trim($_POST["password"]);
}
    // Validate credentials
    if(empty($uname_err) && empty($password_err))
    {
        // Prepare a select statement
        $sql = "SELECT id, user_name, admin_name, password, dob FROM admin_login WHERE user_name = ?";

        if($stmt = mysqli_prepare($link, $sql))
        {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_uname);

            // Set parameters
            $param_uname = $uname;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
            {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1)
                {                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $uname, $aname, $hashed_password, $adob);
                    if(mysqli_stmt_fetch($stmt))
                    {
                        if(password_verify($password, $hashed_password))
                        {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["steponeverification"] = true;
                            $_SESSION["steptwoverification"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["user_name"] = $uname;
                            $_SESSION["admin_name"] = $aname;
                            $_SESSION["dob"] = $adob; 
                            header("location: admin_home.php");                           
                        } 
                        else
                        {
                            echo '<script language="javascript">';
                            echo'alert("Invalid Admin Username or Password."); location.href="index.php"';
                            echo '</script>';
                        }
                    }
                } 
                else
                {
                    echo '<script language="javascript">';
                    echo'alert("Invalid Admin Username or Password."); location.href="index.php"';
                    echo '</script>';
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

    // Close connection
mysqli_close($link);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="stylesheet/loginpage.css">
    <link rel="stylesheet" type="text/css" href="bootstrap-3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body id = "body">
    <img src="images/collegelablewe.jpg" class="img-responsive"/>
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar" id="button">
                <span class="icon-bar" id="bar"></span>
                <span class="icon-bar" id="bar"></span>
                <span class="icon-bar" id="bar"></span>                        
            </button>
            <a href="index.php" class="navbar-brand" id="brand">
            PERSONA ASSESSMENT</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav  navbar-right">
               <li><a href="hand_login.php"><span class="glyphicon glyphicon-pencil"></span> Hand</a></li>
               <li><a href="heart_login.php"><span class="glyphicon glyphicon-bell"></span> Heart</a></li>
               <li><a href="head_login.php"><span class="glyphicon glyphicon-education"></span> Head</a></li>
               <li><a href="index.php"><span class="glyphicon glyphicon-user"></span> Admin</a></li>
           </ul> 
       </div>
   </div>
</nav>
<br>
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3" >
            <div class="panel panel-default" style="border-top:2px solid #087ec2;">
                <div class="panel-heading"> 
                   <h1 class="panel-title" style="color:#087ec2; font-weight:bold;"><span class="glyphicon glyphicon-lock"></span> Admin Login</h1>
               </div>
               <div class="panel-body">
                   <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                      <!-- admin login image -->
                      <img src="images/adminlogin.png" class="img-circle img-responsive center-block d-block mx-auto" id="login"/>
                      <br><br>
                      <div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                       <input type="text" id="uname" name="user_name" placeholder="Enter Admin Username." class="form-control" value=""/>
                   </div><br>
                   <div class="form-group">
                     <div class="input-group"><span class="input-group-addon"><i class="fa fa-key"></i></span>
                         <input type="password" id="password" name="password" placeholder="Enter Password." class="form-control" value=""/>
                     </div>
                 </div><br>
                 <div class="text-center">
                     <button type="submit" id="loginbutton" name="btnLogin" class="btn btn-primary"><i class="glyphicon glyphicon-log-in"></i> Next</button>
                 </div>
             </form>
             <br>
             <div class="panel-default" style="border-top:2px solid #087ec2;">
                <div class="panel-heading">
                    <h1 class="panel-title" style=" color:#087ec2; font-weight: bold; text-align: center;">Admin Login</h1>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<div class="footer">
    <p>Student Persona Assessment (SPA)</p>
</div>
</body>
</html>