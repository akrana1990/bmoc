<?php

/**
 * Advanced Security - PHP Register/Login System
 *
 * @author Milos Stojanovic
 * @link   http://mstojanovic.net/as
 */

/**
 * User registration class.
 *
 */
class ASRegister {

    /**
     * @var Instance of ASEmail class
     */
    private $mailer;

    /**
     * @var Instance of ASDatabase class
     */
    private $db = null;

    /**
     * Class constructor
     */
    function __construct() {
       
        //get database class instance
        $this->db = ASDatabase::getInstance();

        //create new object of ASEmail class
        $this->mailer = new ASEmail();
    }
    
	    
	    /**
     * Register Franchise.
     * @param array $data User details provided during the registration process.
     */
    public function register_Franchise($data) {
        $user = $data['userData'];
        
        //validate provided data
        $errors = $this->validateUser($data,'franchise');
        
        if(count($errors) == 0) {
            //no validation errors
            
            //generate email confirmation key
            $key = $this->_generateKey();
			//random password
			$password = $this->randomPassword(8);
			
            MAIL_CONFIRMATION_REQUIRED === true ? $confirmed = 'inactive' : $confirmed = 'active';
            //insert new user to database
            $this->db->insert('bm_franchise', array(
				"franchise_name" => $user['franchise_name'],
				"franchise_image" => time()."_".$user['franchise_image'],
				"gender" => $user['gender'],
				"franchise_dob" => date("Y-m-d", strtotime($user['franchise_dob'])),
				"franchise_father" => $user['franchise_father'],
				"franchise_residence" => $user['franchise_residence'],
				"franchise_office" => $user['franchise_office'],
				"franchise_pin" => $user['franchise_pin'],
				"franchise_district" => $user['franchise_district'],
				"franchise_state" => $user['franchise_state'],
				"franchise_email" => $user['email'],
				"contact_no" => $user['contact_no'],
				"password" => $password,
				"franchise_education" => $user['franchise_education'],
				"franchise_experience" => $user['franchise_experience'],
				"franchise_applied" => $user['franchise_applied'],
				"franchise_course" => $user['franchise_course'],
				"addDateTime" => date("Y-m-d H:i:s"),
				"addIpAddress" => $_SERVER['REMOTE_ADDR'],
                "status" => $confirmed,
                "confirmation_key"  => $key    
            ));
            $userId = $this->db->lastInsertId();

            $this->db->insert('as_user_details', array( 'user_id' => $userId ));
            
            //send confirmation email if needed
            if ( MAIL_CONFIRMATION_REQUIRED ) {
                $this->mailer->confirmationEmail($user['email'], $key);
                $msg = ASLang::get('success_registration_with_confirm');
            }
            else
                $msg = ASLang::get('success_registration_no_confirm');
            
            //prepare and output success message
            $result = array(
                "status" => "success",
                "msg"    => $msg
            );
            
            echo json_encode($result);
        }
        else {
            //there are validation errors
            
            //prepare result
            $result = array(
                "status" => "error",
                "errors" => $errors
            );
            
            //output result
            echo json_encode ($result);
        }
    }
	    /**
     * Register Student.
     * @param array $data User details provided during the registration process.
     */
    public function register_Student($data) {
        $user = $data['userData'];
        
        //validate provided data
        $errors = $this->validateUser($data);
        
        if(count($errors) == 0) {
            //no validation errors
            
            //generate email confirmation key
            $key = $this->_generateKey();
			//random password
			$password = $this->randomPassword(8);
			
            MAIL_CONFIRMATION_REQUIRED === true ? $confirmed = 'inactive' : $confirmed = 'active';
            
            //insert new user to database
            $this->db->insert('bm_students', array(
				"student_name" => $user['student_name'],
				"student_image" => time()."_".$user['student_image'],
				"gender" => $user['gender'],
				"student_dob" => date("Y-m-d", strtotime($user['student_dob'])),
				"student_mother" => $user['student_mother'],
				"student_father" => $user['student_father'],
				"present_address" => $user['present_address'],
				"permanent_address" => $user['permanent_address'],
				"contant_no" => $user['contant_no'],
				"student_email" => $user['email'],
				"password" => $password,
				"exam_lang" => $user['exam_lang'],
				"student_class" => $user['student_class'],
				"school_name" => $user['school_name'],
				"school_address" => $user['school_address'],
				"addDateTime" => date("Y-m-d H:i:s"),
				"addIpAddress" => $_SERVER['REMOTE_ADDR'],
                "status" => $confirmed,
                "confirmation_key"  => $key    
            ));
            $userId = $this->db->lastInsertId();

            $this->db->insert('as_user_details', array( 'user_id' => $userId ));
            
            //send confirmation email if needed
            if ( MAIL_CONFIRMATION_REQUIRED ) {
                $this->mailer->confirmationEmail($user['email'], $key);
                $msg = ASLang::get('success_registration_with_confirm');
            }
            else
                $msg = ASLang::get('success_registration_no_confirm');
            
            //prepare and output success message
            $result = array(
                "status" => "success",
                "msg"    => $msg
            );
            
            echo json_encode($result);
        }
        else {
            //there are validation errors
            
            //prepare result
            $result = array(
                "status" => "error",
                "errors" => $errors
            );
            
            //output result
            echo json_encode ($result);
        }
    }
	
    /**
     * Register user.
     * @param array $data User details provided during the registration process.
     */
    public function register($data) {
        $user = $data['userData'];
        
        //validate provided data
        $errors = $this->validateUser($data);
        
		exit;
        if(count($errors) == 0) {
            //no validation errors
            
            //generate email confirmation key
            $key = $this->_generateKey();

            MAIL_CONFIRMATION_REQUIRED === true ? $confirmed = 'N' : $confirmed = 'Y';
            
            //insert new user to database
            $this->db->insert('as_users', array(
                "email"     => $user['email'],
                "username"  => strip_tags($user['username']),
                "password"  => $this->hashPassword($user['password']),
                "confirmed" => $confirmed,
                "confirmation_key"  => $key,
                "register_date"     => date("Y-m-d")     
            ));

            $userId = $this->db->lastInsertId();

            $this->db->insert('as_user_details', array( 'user_id' => $userId ));
            
            //send confirmation email if needed
            if ( MAIL_CONFIRMATION_REQUIRED ) {
                $this->mailer->confirmationEmail($user['email'], $key);
                $msg = ASLang::get('success_registration_with_confirm');
            }
            else
                $msg = ASLang::get('success_registration_no_confirm');
            
            //prepare and output success message
            $result = array(
                "status" => "success",
                "msg"    => $msg
            );
            
            echo json_encode($result);
        }
        else {
            //there are validation errors
            
            //prepare result
            $result = array(
                "status" => "error",
                "errors" => $errors
            );
            
            //output result
            echo json_encode ($result);
        }
    }

    /**
     * Get user by email.
     * @param $email User's email
     * @return mixed User info if user with provided email exist, empty array otherwise.
     */
    public function getByEmail($email) {
        $result = $this->db->select("SELECT * FROM `as_users` WHERE `email` = :e", array( 'e' => $email ));
        if ( count ( $result ) > 0 )
            return $result[0];
        return $result;
    }


    /**
     * Check if user has already logged in via specific provider and return user's data if he does.
     * @param $provider oAuth provider (facebook, twitter or gmail)
     * @param $id Identifier provided by provider
     * @return array|mixed User info if user has already logged in via specific provider, empty array otherwise.
     */
    public function getBySocial($provider, $id) {
        $result = $this->db->select('SELECT * FROM `as_social_logins` WHERE `provider` = :p AND `provider_id` = :id ', array(
            'p'  => $provider,
            'id' => $id
        ));

        if ( count ( $result ) > 0 ) {
            $res = $result[0];
            $user = new ASUser($res['user_id']);
            return $user->getInfo();
        }

        else
            return $result;
    }

    /**
     * Check if user is already registred via some social network.
     * @param $provider Name of the provider ( twitter, facebook or google )
     * @param $id Provider identifier
     * @return bool TRUE if user exist in database (already registred), FALSE otherwise
     */
    public function registeredViaSocial($provider, $id) {
        $result = $this->getBySocial($provider, $id);

        if ( count ( $result ) === 0 )
            return false;
        else
            return true;
    }

    /**
     * Connect user's social account with his account at this system.
     * @param $userId User Id on this system
     * @param $provider oAuth provider (facebook, twitter or gmail)
     * @param $providerId Identifier provided by provider.
     */
    public function addSocialAccount($userId, $provider, $providerId) {
        $this->db->insert('as_social_logins', array(
            'user_id' => $userId,
            'provider' => $provider,
            'provider_id' => $providerId,
            'created_at' => date('Y-m-d H:i:s')
        ));
    }

    /**
     * Send forgot password email.
     * @param string $userEmail Provided email.
     */
    public function forgotPassword($userEmail) {

        $validator = new ASValidator();
        $errors = array();
        //we only have one field to validate here
        //so we don't need id's from other fields
        if($userEmail == "")
            $errors[] = ASLang::get('email_required');
        if( ! $validator->emailValid($userEmail) )
            $errors[] = ASLang::get('email_wrong_format');
        
        if( ! $validator->emailExist($userEmail) )
            $errors[] = ASLang::get('email_not_exist');

        $login = new ASLogin();

        if($login->_isBruteForce())
            $errors[] = ASLang::get('brute_force');
        
        if(count($errors) == 0) {
            //no validation errors
            
            //generate password reset key
            $key = $this->_generateKey();
            
            //write key to db
            $this->db->update(
                        'as_users', 
                         array(
                             "password_reset_key" => $key,
                             "password_reset_confirmed" => 'N',
                             "password_reset_timestamp" => date('Y-m-d H:i:s')
                         ),
                         "`email` = :email",
                         array("email" => $userEmail)
                    );

            $login->increaseLoginAttempts();
            
            //send email
            $this->mailer->passwordResetEmail($userEmail, $key);
        }
        else
            echo json_encode ($errors); //output json encoded errors
    }
    
    
    /**
     * Reset user's password if password reset request has been made.
     * @param string $newPass New password.
     * @param string $passwordResetKey Password reset key sent to user
     * in password reset email.
     */
    public function resetPassword($newPass, $passwordResetKey) {
        $validator = new ASValidator();
        if ( ! $validator->prKeyValid($passwordResetKey) ) {
            echo 'Invalid password reset key!';
            return;
        }

        $pass = $this->hashPassword($newPass);
        $this->db->update(
                    'as_users', 
                    array("password" => $pass, 'password_reset_confirmed' => 'Y', 'password_reset_key' => ''),
                    "`password_reset_key` = :prk ",
                    array("prk" => $passwordResetKey)
                );
    }
    
     
    /**
     * Hash given password.
     * @param string $password Unhashed password.
     * @return string Hashed password.
     */
     public function hashPassword($password) {
        //this salt will be used in both algorithms
        //for bcrypt it is required to look like this,
        //for sha512 it is not required but it can be used 
        $salt = "$2a$" . PASSWORD_BCRYPT_COST . "$" . PASSWORD_SALT;
        
        if(PASSWORD_ENCRYPTION == "bcrypt") {
            $newPassword = crypt($password, $salt);
        }
        else {
            $newPassword = $password;
            for($i=0; $i<PASSWORD_SHA512_ITERATIONS; $i++)
                $newPassword = hash('sha512',$salt.$newPassword.$salt);
        }
        
        return $newPassword;
     }
    
    
    /**
     * Generate two random numbers and store them into $_SESSION variable.
     * Numbers are used during the registration to prevent bots to register.
     */
     public function botProtection() {
        ASSession::set("bot_first_number", rand(1,9));
        ASSession::set("bot_second_number", rand(1,9));
    }

    /**
     * Validate user provided fields.
     * @param $data User provided fieds and id's of those fields that will be used for displaying error messages on client side.
     * @param bool $botProtection Should bot protection be validated or not
     * @return array Array with errors if there are some, empty array otherwise.
     */
    public function validateUser($data,$validateFor, $botProtection = true) {
        $id     = $data['fieldId'];
        $user   = $data['userData'];
        $errors = array();
        $validator = new ASValidator();
        
        //check if email is not empty
        if( $validator->isEmpty($user['email']) )
            $errors[] = array( 
                "id"    => $id['email'],
                "msg"   => ASLang::get('email_required') 
            );
        
        //check if email format is correct
        if( ! $validator->emailValid($user['email']) )
            $errors[] = array( 
                "id"    => $id['email'],
                "msg"   => ASLang::get('email_wrong_format')
            );
        
        //check if email is available
		if($validateFor=="student"){
        if( $validator->studentemailExist($user['email']) )
            $errors[] = array( 
                "id"    => $id['email'],
                "msg"   => ASLang::get('student_email_taken')
            );
		}elseif($validateFor=="franchise"){
		if( $validator->franchiseemailExist($user['email']) )
            $errors[] = array( 
                "id"    => $id['email'],
                "msg"   => ASLang::get('franchise_email_taken')
            );
		}
        
        if ( $botProtection )
        {
            //bot protection
            $sum = ASSession::get("bot_first_number") + ASSession::get("bot_second_number");
            if($sum != intval($user['bot_sum']))
                $errors[] = array( 
                    "id"    => $id['bot_sum'],
                    "msg"   => ASLang::get('wrong_sum')
                );
        }        
        
        return $errors;
    }

    /**
     * Generates random password
     * @param int $length Length of generated password
     * @return string Generated password
     */
    public function randomPassword($length = 7) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    /**
     * Generate random token that will be used for social authentication
     * @return string Generated token.
     */
    public function socialToken() {
        return $this->randomPassword(40);
    }


     /* PRIVATE AREA
     =================================================*/

    /**
     * Generate key used for confirmation and password reset.
     * @return string Generated key.
     */
    private function _generateKey() {
        return md5(time() . PASSWORD_SALT . time());
    }
    
}
