<?php
//BOOTSTRAP
define('BOOTSTRAP_VERSION', 3);

//WEBSITE
define('WEBSITE_NAME', "BMOC");
define('WEBSITE_DOMAIN', "http://localhost");

//DATABASE CONFIGURATION
define('DB_HOST', "localhost"); 
define('DB_TYPE', "mysql"); 
define('DB_USER', "root"); 
define('DB_PASS', ""); 
define('DB_NAME', "bmoc"); 

//SESSION CONFIGURATION
define('SESSION_SECURE', false);   
define('SESSION_HTTP_ONLY', true);
define('SESSION_REGENERATE_ID', true);   
define('SESSION_USE_ONLY_COOKIES', 1);

//LOGIN CONFIGURATION
define('LOGIN_MAX_LOGIN_ATTEMPTS', 5); 
define('LOGIN_FINGERPRINT', true); 
define('SUCCESS_LOGIN_REDIRECT', "index.php"); 

//PASSWORD CONFIGURATION
define('PASSWORD_ENCRYPTION', "bcrypt"); //available values: "sha512", "bcrypt"
define('PASSWORD_BCRYPT_COST', "13"); 
define('PASSWORD_SHA512_ITERATIONS', 25000); 
define('PASSWORD_SALT', "SDPaCBmZQKhqcp2E.rDcSb"); //22 characters to be appended on first 7 characters that will be generated using PASSWORD_ info above
define('PASSWORD_RESET_KEY_LIFE', 5); 

//REGISTRATION CONFIGURATION
define('MAIL_CONFIRMATION_REQUIRED', true); 
define('REGISTER_CONFIRM', "http://localhost/bmoc/confirm.php"); 
define('REGISTER_PASSWORD_RESET', "http://localhost/bmoc/passwordreset.php"); 

//EMAIL SENDING CONFIGURATION
define('MAILER', "mail"); 
define('SMTP_HOST', ""); 
define('SMTP_PORT', 0); 
define('SMTP_USERNAME', ""); 
define('SMTP_PASSWORD', ""); 
define('SMTP_ENCRYPTION', ""); 

//SOCIAL LOGIN CONFIGURATION
define('SOCIAL_CALLBACK_URI', "http://localhost/bmoc/vendor/hybridauth/"); 
// GOOGLE
define('GOOGLE_ENABLED', false); 
define('GOOGLE_ID', ""); 
define('GOOGLE_SECRET', ""); 

// FACEBOOK
define('FACEBOOK_ENABLED', false); 
define('FACEBOOK_ID', ""); 
define('FACEBOOK_SECRET', ""); 

// TWITTER

// NOTE: Twitter api for authentication doesn't provide users email address!
// So, if you email address is strictly required for all users, consider disabling twitter login option.
define('TWITTER_ENABLED', false); 
define('TWITTER_KEY', ""); 
define('TWITTER_SECRET', ""); 

// TRANSLATION
define('DEFAULT_LANGUAGE', 'en'); 