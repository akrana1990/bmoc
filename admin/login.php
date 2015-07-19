<?php session_start();ob_start();

	include "../lib/db.php";
	$objSql = new SqlClass();
	
	if(isset($_POST['login'])){
	$username=$_REQUEST['username'];
	$password=md5($_REQUEST['password']);
		
$query="SELECT * FROM bm_admin WHERE username ='".$username."' AND password ='".$password."' and status='active'";
		
	$objSql->setAdvanceErr(true);
	if($record = $objSql->executeSql($query))
	{
		if($objSql->getNumRecord())
		{
			while($row = $objSql->fetchRow($record))
			{
				$_SESSION['adminuser'] = $username;
				$_SESSION['admin_login'] = "admin";
				$_SESSION['admin_sessid']=$row['id'];
				
				header("Location:index.php");
				exit;
			}
		}
		else
		{
			$_SESSION['msg'] = "Login Credentials didn't match";
			header("Location:login.php");
			exit;
		}	
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <link rel="shortcut icon" href="#" type="image/png">
    <title>Login</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
	<style>
	#loginForm label.error {
    color: #ff6c60;
    display: inline;
    margin: 5px 0;
    width: auto;
	font-weight: normal;
}
.alert_info {
    background: #dbe3ff none repeat scroll 0 0;
    border: 1px solid #a2b4ee;
    color: #0888c3;
    cursor: pointer;
    font-weight: bold;
    margin: auto;
}
	</style>
</head>
<body class="login-body">
<div class="container">

    <form method="POST" role="form" id="loginForm" class="form-horizontal adminex-form form-signin" >
        <div class="form-signin-heading text-center">
            <h1 class="sign-title">Sign In</h1>
            <img src="images/login-logo.png" alt=""/>
        </div>

        <div class="login-wrap">
            <input type="text" name="username" class="form-control" placeholder="User ID" autofocus required>
            <input type="password" name="password" class="form-control" placeholder="Password" required>

            <button name="login" class="btn btn-lg btn-login btn-block" type="submit">
                <i class="fa fa-check"></i>
            </button>

            <div class="registration"></div>
            <label class="checkbox">
                <input type="checkbox" value="remember-me"> Remember me
                <span class="pull-right">
                    <a data-toggle="modal" href="#myModal"> Forgot Password?</a>

                </span>
            </label>

        </div>

        <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Forgot Password ?</h4>
                    </div>
                    <div class="modal-body">
                        <p>Enter your e-mail address below to reset your password.</p>
                        <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">

                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                        <button class="btn btn-primary" type="button">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal -->

    </form>

</div>
<script src="js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script src="js/validation-init.js"></script>
<!-- Placed js at the end of the document so the pages load faster -->
<script src="js/bootstrap.min.js"></script>
<script src="js/modernizr.min.js"></script>
</body>
</html>