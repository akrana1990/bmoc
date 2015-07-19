$(document).ready(function () {
    //button register click
    $("#btn-register-student").click(function () {
        if(register.validateRegistration() == true) {
            //validation passed
            var regname  	   = $("#name").val(),
                regs_image     = $("#fr_image").val(),
                reggender 	   = $("#gender").val(),
				regdob  	   = $("#dob").val(),
                regfather		= $("#father_name").val(),
				fregpresent	    = $("#fr_residential_address").val(),
                fr_office		= $("#fr_office").val(),
				fr_pin			= $("#fr_pin").val(),
				fr_district		= $("#fr_district").val(),
				fr_state		= $("#fr_state").val(),
                regemail		= $("#reg-email").val(),
				regcontact		= $("#contact").val(),
				fr_education	= $("#fr_education").val(),
                fr_experience	= $("#fr_experience").val(),
				fr_applied		= $("#fr_applied").val(),
                fr_course		= $("#fr_course").val(),
                regBotSsum		= $("#reg-bot-sum").val();

            //create data that will be sent to server
            var data = { 
                userData: {
                    franchise_name		: regname,
                    franchise_image		: regs_image,
                    gender				: reggender,
                    franchise_dob			: regdob,
					franchise_father		: regfather,
					franchise_residence	: fregpresent,
					franchise_office	: fr_office,
					franchise_pin		: fr_pin,
					franchise_district	: fr_district,
					franchise_state		: fr_state,
					email				: regemail,
					contact_no			: regcontact,
					franchise_education	: fr_education,
					franchise_experience: fr_experience,
					franchise_applied	: fr_applied,
					franchise_course	: fr_course,
                    bot_sum         	: regBotSsum
                },
                fieldId: {
                    franchise_name 		: "name",
                    franchise_image		: "s_image",
                    gender       		: "gender",
                    franchise_dob		: "dob",
					franchise_father	: "father_name",
					franchise_residence	: "fr_residential_address",
					franchise_office	: "fr_office",
					franchise_pin		: "fr_pin",
					franchise_district	: "fr_district",
					franchise_state		: "fr_state",
					email			: "reg-email",
					contant_no		: "regcontact",
					franchise_education	: "fr_education",
					franchise_experience: "fr_experience",
					franchise_applied	: "fr_applied",
					franchise_course	: "fr_course",
                    bot_sum         : "reg-bot-sum"
                }

            };
            //send data to server
            register.registerUser(data);
        }                        
    });
});

/** REGISTER NAMESPACE
 ======================================== */

var register = {};

/* Registers new user.
 * @param {Object} data Register form data.
 */
register.registerUser = function (data) {
    //get register button
    var btn = $("#btn-register-student");
    
    //put button to loading state
    asengine.loadingButton(btn, $_lang.creating_account);
    
    //hash passwords before send them through network
    data.userData.password = CryptoJS.SHA512(data.userData.password).toString();
    data.userData.confirm_password = CryptoJS.SHA512(data.userData.confirm_password).toString();
    
    //send data to server
    $.ajax({
        url: "ASEngine/ASAjax.php",
        type: "POST",
        data: {
            action  : "registerFranchise",
            user    : data
        },
        success: function (result) {
            //return button to normal state
            asengine.removeLoadingButton(btn);

            console.log(result);
            
            //parse result to JSON
            var res = JSON.parse(result);
            
            if(res.status === "error") {
                //error
                
                //display all errors
                for(var i=0; i<res.errors.length; i++) {
                    var error = res.errors[i];
                    asengine.displayErrorMessage($("#"+error.id), error.msg);
                }
            }
            else {
                //display success message
                asengine.displaySuccessMessage($(".register-form fieldset"), res.msg);
            }
        }
    });
};

/* Validate registration form.
 * @returns {Boolean} TRUE if form is valid, FALSE otherwise.
 */
register.validateRegistration = function () {
    var valid = true;
    
    //remove previous error messages
    asengine.removeErrorMessages();
    
    //check if all fields are filled
    $(".register-form").find("input:text").each(function () {
        var el = $(this);
        if($.trim(el.val()) === "") {
            asengine.displayErrorMessage(el);
            valid = false;
        }
    });

    //get email, password and confirm password for further validation
    var regMail     = $("#reg-email");
    
    //check if email is valid
    if(!asengine.validateEmail(regMail.val()) && regMail.val() != "") {
        valid = false;
        asengine.displayErrorMessage(regMail,$_lang.email_wrong_format);
    }

    return valid;
};