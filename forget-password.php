<?php 
include "ASEngine/AS.php"; 
if($login->isLoggedIn())
    header("Location: index.php");

$token = $register->socialToken();
ASSession::set('as_social_token', $token);
$register->botProtection();
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="BMOC">
        <meta name="author" content="BMOC">
        <title>Login | BMOC</title>
        <script type="text/javascript" src="assets/js/jquery.min.js"></script>
        <link rel='stylesheet' href='assets/css/bootstrap.min3.css' type='text/css' media='all' />
        <script type="text/javascript" src="assets/js/bootstrap.min3.js"></script>
        <link rel='stylesheet' href='ASLibrary/css/style3.css' type='text/css' media='all' />
        <link href="assets/css/bootstrap-responsive.min.css" rel="stylesheet">
        <script type="text/javascript" src="assets/js/respond.min.js"></script>
        <script type="text/javascript">
            var SUCCESS_LOGIN_REDIRECT = "<?php echo SUCCESS_LOGIN_REDIRECT; ?>";
            var $_lang = <?php echo ASLang::all(); ?>;
        </script>
        
    </head>
    <body>
        <div class="container">
         <div class="modal" id="loginModal">
             <div class="modal-dialog" >
                 <div class="modal-content">
          <div class="modal-header">
            <h3><?php echo WEBSITE_NAME; ?></h3>
          </div>
          <div class="modal-body">
            <div class="well">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#forgot" data-toggle="tab">Forgot Password?</a></li>
                <li><a href="login.php">Login</a></li>
              </ul>
              <div id="myTabContent" class="tab-content">
                  <div class="tab-pane active in" id="forgot">
                        <form class="form-horizontal" id="forgot-pass-form">
                        <fieldset>
                          <div id="legend">
                            <legend class="">Forgot Password?</legend>
                          </div>    
                          <div class="control-group form-group">
                            <!-- Username -->
                            <label class="control-label col-lg-4"  for="forgot-password-email"><?php echo ASLang::get('your_email'); ?></label>
                            <div class="controls col-lg-8">
                              <input type="email" id="forgot-password-email" class="input-xlarge form-control">
                            </div>
                          </div>

                          <div class="control-group form-group">
                            <!-- Button -->
                            <div class="controls col-lg-offset-4 col-lg-8">
                              <button id="btn-forgot-password" class="btn btn-success"><?php echo ASLang::get('reset_password'); ?></button>
                            </div>
                          </div>
                        </fieldset>
                      </form>
                        
                  </div>
            </div>
          </div>
        </div>
                 </div>
             </div>
        </div>
            <script type="text/javascript" src="assets/js/sha512.js"></script>
            <script type="text/javascript" src="ASLibrary/js/asengine.js"></script>
            <script type="text/javascript" src="ASLibrary/js/register.js"></script>
            <script type="text/javascript" src="ASLibrary/js/login.js"></script>
            <script type="text/javascript" src="ASLibrary/js/passwordreset.js"></script>
            <script type="text/javascript">
                $(document).ready(function () {
                   $("#loginModal").modal({
                       keyboard: false,
                       backdrop: "static"
                   }); 
                });
            </script>
    </body>
</html>