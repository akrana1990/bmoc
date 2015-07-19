$(document).ready(function () {
    //button register click
    $("#btn-register-student").click(function () {
        if(register.validateRegistration() == true) {
            //validation passed
            var regname  	   = $("#name").val(),
                regs_image     = $("#s_image").val(),
                reggender 	   = $("#gender").val(),
				regdob  	   = $("#dob").val(),
                regmother 	   = $("#mother_name").val(),
                regfather		= $("#father_name").val(),
				regpresent	    = $("#present_address").val(),
                regparmanent	= $("#permanent_address").val(),
				regcontact		= $("#contact").val(),
                regemail		= $("#reg-email").val(),
				regelang			= $("#language").val(),
                regclass		= $("#study_class").val(),
				regschool		= $("#school_name").val(),
                regsaddr		= $("#school_address").val(),
                regBotSsum		= $("#reg-bot-sum").val();

            //create data that will be sent to server
            var data = { 
                userData: {
                    student_name		: regname,
                    student_image		: regs_image,
                    gender				: reggender,
                    student_dob			: regdob,
					student_mother		: regmother,
					student_father		: regfather,
					present_address		: regpresent,
					permanent_address	: regparmanent,
					contant_no			: regcontact,
					email				: regemail,
					exam_lang			: regelang,
					student_class		: regclass,
					school_name			: regschool,
					school_address		: regsaddr,
                    bot_sum         	: regBotSsum
                },
                fieldId: {
                    student_name    : "name",
                    student_image   : "s_image",
                    gender       	: "gender",
                    student_dob		: "dob",
					student_mother	: "mother_name",
					student_father	: "father_name",
					present_address	: "present_address",
					permanent_address: "permanent_address",
					contant_no		: "regcontact",
					email			: "reg-email",
					exam_lang		: "language",
					student_class	: "study_class",
					school_name		: "school_name",
					school_address	: "school_address",
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
            action  : "registerStudent",
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