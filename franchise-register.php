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
        <title>Registration | BMOC</title>
        <script type="text/javascript" src="assets/js/jquery.min.js"></script>
        <link rel='stylesheet' href='assets/css/bootstrap.min3.css' type='text/css' media='all' />
        <script type="text/javascript" src="assets/js/bootstrap.min3.js"></script>
        <link rel='stylesheet' href='ASLibrary/css/style3.css' type='text/css' media='all' />
        <link href="assets/css/bootstrap-responsive.min.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="ASLibrary/js/bootstrap-fileinput/bootstrap-fileinput.css"/>
        <script type="text/javascript" src="assets/js/respond.min.js"></script>
        <script type="text/javascript">
            var SUCCESS_LOGIN_REDIRECT = "<?php echo SUCCESS_LOGIN_REDIRECT; ?>";
            var $_lang = <?php echo ASLang::all(); ?>;
        </script>
        <style>
.btn.default {
    background-color: #e5e5e5;
    color: #333333;
}
.btn.default:hover, .btn.default:focus, .btn.default:active, .btn.default.active {
  color: #333333;
  background-color: #d1d1d1;
}
.red.btn {
    background-color: #d84a38;
    color: white;
}
.btn {
    background-image: none !important;
    border-width: 0;
    box-shadow: none;
    filter: none;
    font-size: 14px;
    outline: medium none !important;
    padding: 7px 14px;
    text-shadow: none;
}
		</style>
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
          <li class="active"><a href="#create" data-toggle="tab">Create Account</a></li>
		  <li><a href="login.php">Login</a></li>
          <li><a href="forget.php">Forgot Password?</a></li>
              </ul>
			  <script type="text/javascript">
$(document).ready(function (e){
$("#tab").on('submit',(function(e){
var form = $(this);
formData = new FormData();
//alert(formData);
e.preventDefault();
$.ajax({
url: "upload.php",
type: "POST",
data:  formData,
success: function(data){
//alert(data);
},
error: function(){} 	        
});
}));
});
</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
              <div id="myTabContent" class="tab-content">
                <div class="tab-pane active in" id="create">
                  <form class="form-horizontal register-form" id="tab">
                      <fieldset>
                        <div id="legend">
                          <legend class="">Register Franchise Form</legend>
                        </div>
						<div class="control-group  form-group">
                            <label class="control-label col-lg-4" for="reg-username">NAME OF APPLICANT<span class="required">*</span></label>
                            <div class="controls col-lg-8">
                                <input type="text" id="name" class="input-xlarge form-control">
                            </div>
                        </div>
						
						<div class="control-group">
							<label class="control-label col-lg-4" for="reg-username">Image Upload</label>		
							<div class="controls col-lg-8">
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
									<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image"/>
								</div>
									<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
												<div>
								<span class="btn default btn-file">
								<span class="fileinput-new">Select image </span>
								<span class="fileinput-exists">Change</span><input type="file" id="fr_image" name="fr_image"></span>
								<a href="#" class="btn red fileinput-exists" data-dismiss="fileinput">Remove </a>
												</div>
						</div>
						</div>
						</div>
						
						<div class="control-group  form-group">
                           <label class="control-label col-lg-4" >Gender<span class="required">*</span></label>
                            <div class="controls col-lg-8">
							<input name="gender" id="gender" value="boy" type="radio" />Boy 
                            <input name="gender" id="gender" value="girl" type="radio" />Girl 
                            </div>
                        </div>
						<div class="control-group  form-group">
                            <label class="control-label col-lg-4" for="reg-username">Date of Birth :<span class="required">*</span></label>
                            <div class="controls col-lg-8">
                                <input type="text" id="dob" readonly class="input-xlarge form-control">
                            </div>
                        </div>
						<div class="control-group  form-group">
                            <label class="control-label col-lg-4" for="reg-username">Father's Name (BLOCK LETTERS)  <span class="required">*</span></label>
                            <div class="controls col-lg-8">
                                <input type="text" id="father_name" class="input-xlarge form-control">
                            </div>
                        </div>  
						<div class="control-group  form-group">
                            <label class="control-label col-lg-4" for="reg-username">Residential Address<span class="required">*</span></label>
                            <div class="controls col-lg-8">
                                <textarea id="fr_residential_address" class="input-xlarge form-control"></textarea>
                            </div>
                        </div>
						<div class="control-group  form-group">
                            <label class="control-label col-lg-4" for="reg-username">Office/Centre Address<span class="required">*</span></label>
                            <div class="controls col-lg-8">
                                <textarea id="fr_office" class="input-xlarge form-control"></textarea>
                            </div>
                        </div>
						<div class="control-group  form-group">
                            <label class="control-label col-lg-4" for="reg-username">Pin Code <span class="required">*</span></label>
                            <div class="controls col-lg-8">
                                <input type="text" id="fr_pin" class="input-xlarge form-control">
                            </div>
                        </div>
												<div class="control-group  form-group">
                            <label class="control-label col-lg-4" for="reg-username">District <span class="required">*</span></label>
                            <div class="controls col-lg-8">
                                <input type="text" id="fr_district" class="input-xlarge form-control">
                            </div>
                        </div>
						
												<div class="control-group  form-group">
                            <label class="control-label col-lg-4" for="reg-username">State <span class="required">*</span></label>
                            <div class="controls col-lg-8">
                                <input type="text" id="fr_state" class="input-xlarge form-control">
                            </div>
                        </div>
                        <div class="control-group  form-group">
                            <label class="control-label col-lg-4" for='reg-email' >E-Mail ID<span class="required">*</span></label>
                            <div class="controls col-lg-8">
                                <input type="text" id="reg-email" class="input-xlarge form-control">
                            </div>
                        </div>
						<div class="control-group  form-group">
                            <label class="control-label col-lg-4" for="reg-username">Contact / Telephone No. <span class="required">*</span></label>
                            <div class="controls col-lg-8">
                                <input type="text" id="contact" class="input-xlarge form-control">
                            </div>
                        </div>
																			<div class="control-group  form-group">
                            <label class="control-label col-lg-4" for="reg-username">Education <span class="required">*</span></label>
                            <div class="controls col-lg-8">
                                <input type="text" id="fr_education" class="input-xlarge form-control">
                            </div>
                        </div>
																				<div class="control-group  form-group">
                            <label class="control-label col-lg-4" for="reg-username">Work Experience <span class="required">*</span></label>
                            <div class="controls col-lg-8">
                                <input type="text" id="fr_experience" class="input-xlarge form-control">
                            </div>
                        </div>
							<div class="control-group  form-group">
                            <label class="control-label col-lg-4" >Franchisee, applied for<span class="required">*</span></label>
                            <div class="controls col-lg-8">
							<input name="fr_applied" id="fr_applied" value="BMCF" type="radio" />BMCF  
                            <input name="fr_applied" id="fr_applied" value="DMF" type="radio" /> DMF  
							<input name="fr_applied" id="fr_applied" value="RMF" type="radio" /> RMF  
                            </div>
                        </div>
						<div class="control-group  form-group">
                            <label class="control-label col-lg-4" >Course, applied for<span class="required">*</span></label>
                            <div class="controls col-lg-8">
							<input name="fr_course" id="fr_course" value="Abacus_Education" type="radio" />Abacus Education  
                            <input name="fr_course" id="fr_course" value="Vedic_Maths" type="radio" /> Vedic Maths <br> 
							<input name="fr_course" id="fr_course" value="Abacus_Education-Vedic_Maths" type="radio" /> Both Abacus Education & Vedic Maths  
                            </div>
                        </div>	
                        <div class="control-group  form-group">
                            <label class="control-label col-lg-4" for="reg-bot-sum">
                                <?php echo ASSession::get("bot_first_number"); ?> + 
                                <?php echo ASSession::get("bot_second_number"); ?>
                                <span class="required">*</span>
                            </label>
                            <div class="controls col-lg-8">
                                <input type="text" id="reg-bot-sum" class="input-xlarge form-control">
                            </div>
                        </div>

                        <div class="control-group  form-group">
                            <div class="controls col-lg-offset-4 col-lg-8">
                                <button id="btn-register-student" class="btn btn-success"><?php echo ASLang::get('create_account'); ?></button>
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
            <script type="text/javascript" src="ASLibrary/js/register_frenchise.js"></script>
            <script type="text/javascript" src="ASLibrary/js/login.js"></script>
            <script type="text/javascript" src="ASLibrary/js/passwordreset.js"></script>
			<script type="text/javascript" src="ASLibrary/js/bootstrap-fileinput/bootstrap-fileinput.js"></script>
            <script type="text/javascript">
                $(document).ready(function () {
                   $("#loginModal").modal({
                       keyboard: false,
                       backdrop: "static"
                   }); 
                
	$( "#dob" ).datepicker({
      changeMonth: true,
      changeYear: true
    });
				});
            </script>
    </body>
</html>