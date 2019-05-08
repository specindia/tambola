<?php 
/*******************************************************************************************/
/*                           DATABASE CONFIGURATION                                        */
/*******************************************************************************************/



/*	Database Server Name  */
$servername = "localhost";


/*	Database Username  */
$username = "root";

/*	Database Password */
$password = "";

/*	Database Name */
$dbname="tambola";



/*******************************************************************************************/
/*                         APPLICATION CONFIGURATION                                        */
/*******************************************************************************************/


/*	Application Title */
$application_title="Tambola";
/*	Application URL */
$application_url="http://10.37.54.126/tambola";
/*	Terms and Conditions Text Content */
$terms_and_conditions='Terms and Conditions goes here';
/*	Allow to SignUp from front end */
$allow_frontend_signup=true;
/*	Use Email Id as Username */
$email_as_username=false;
/*	Limit of the Tickets to be Purchased */
$ticket_purchase_limit=5;
/*	Price */
$ticket_rate=10;
/*	Payment Collecter name */
$payment_collecter='Niraj Gohel (DZN)';
/*	Maximum declared numbers to be displayed */
$max_declared_numbers_to_display=3;


/*******************************************************************************************/
/*                           LOGIN CONFIGURATION                                       	   */
/*******************************************************************************************/


/*	Limit the Login Attempts */
$limit_login_attemps=true;
/*	Display the Alert after certain number of tries */
$display_alert_after=3;
/*	Block Login after certain number of tries */
$block_after=6;


/*******************************************************************************************/
/*                           EMAIL CONFIGURATION                                        */
/*******************************************************************************************/



/*	Email Id of the Sender */
$sender_email="spectorious@spec-india.com";
/*	Subject for the Registration Email */
$registration_email_subject="Registration Successful for eTambola by SPECtorious";
/*	Subject for the Tickets Generation Email */
$tickets_email_subject="Tickets Successfully Generated For eTambola";


/*******************************************************************************************/
/*                           SECURITY CONFIGURATION                                        */
/*******************************************************************************************/


/*	Database Encryption Key */
$db_encryption_key='spec2018';
/*	SSL Encryption Key */
$ssl_encryption_key='specTambola2018';
/*	SSL Encryption Initialization Vector */
$ssl_encryption_iv='spec2018';


/*******************************************************************************************/
/*                           WINNING CONFIGURATION                                        */
/*******************************************************************************************/

/*	Allow Top Line Winning */
$allow_top_line=true;
/*	Max Number of Top Line Winners */
$max_top_line_winners=3;

/*	Allow Middle Line Winning */
$allow_middle_line=true;
/*	Max Number of Middle Line Winners */
$max_middle_line_winners=3;

/*	Allow Bottom Line Winning */
$allow_bottom_line=true;
/*	Max Number of Bottom Line Winners */
$max_bottom_line_winners=3;

/*	Allow Four Corners Winning */
$allow_four_corners=true;
/*	Max Number of Four Corners Winners */
$max_four_corners_winners=3;

/*	Allow Star Formation Winning */
$allow_star=true;
/*	Max Number of Star Formation Winners */
$max_star_winners=3;

/*	Allow Full House Winning */
$allow_full_house=true;
/*	Max Number of Full House Winners */
$max_full_house_winners=3;


?>