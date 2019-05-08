
<a href="https://www.spec-india.com/"><img src="https://s3.amazonaws.com/awsspec/wp-content/uploads/2018/02/04103534/cropped-SPEC-INDIA-2.png" title="SPEC INDIA" alt="SPEC INDIA"></a>


# eTambola By SPEC INDIA

Tambola, also known as Indian Bingo or Housie, is one of the wonderful games played across the world. The game comes with an enormous login screen, ticket screen, mark and claim sections in the application. Apart from this, the game also consists of the functionality to reject the claim wherein, the organizer can reject the claim. 

Now, this game is available online on GitHub for free with intuitive designs, wonderful user experience, extraordinary colour combination in the tickets. Tickets consist of set of random numbers to let the user check the numbers announced. The application comes with various typography to enhance the experience of the user. 

All you need to do is, login and buy the tickets, mark the numbers announced on the screen, claim the prize for the selection of various set of numbers in the different rows, corners, full ticket and columns. 


[![License](http://img.shields.io/:license-mit-blue.svg?style=flat-square)](http://badges.mit-license.org)




## Table of Contents
- [Installation](#installation)
- [FAQ](#faq)
- [Support](#support)
- [License](#license)




## Installation

- The server must be equipped with Apache 2 and MySQL with PHP Mail Support
- Install this project into your server's public directory that can be used by `http://`
- Import the given SQL file into your database

### Setup

- After Successful Installation change the `config.php` file and make necessary changes according to your need.

#### Database Configuration 
- `$servername` - The host name / IP Address of the database server
- `$username` - Database Username
- `$password` - Database Password
- `$dbname` - Database Name

#### Application  Configuration
##### General
- `$application_title` - Title of the application
- `$application_url` - The web accessible URL of your application which will be used to load resources and to be sent in Email. 
##### Signup and Ticket Purchase
- `$terms_and_conditions` - The terms and conditions which will be displayed while signing up 
- `$allow_frontend_signup` - If this option is set `true`, the users will be able to register themselves from the application and if it is set `false`, the administrator has to enter the users' data in database manually, Users can only login from Application 
- `$email_as_username` - If this option is set `true`, the email address will be used as the username and if it is set `false`, one more field of username will be added on signup 
- `$ticket_purchase_limit` - The maximum number of tickets a user can purchase
- `$ticket_rate` - Rate of Ticket 
- `$payment_collecter` - Contact person to collect the payment for the purchased tickets, this name will be displayed to the users after they request for purchasing tickets
- `$max_declared_numbers_to_display` - Number of Declared Numbers to be displayed on the top of the page 
- `$limit_login_attemps` - Set this option to `true` if you want to restrict user from doing fail login attempts  
- `$display_alert_after` - Number of failed attempts after which the alert will be displayed
- `$block_after` - Number of failed attempts after which the user will be blocked temporarily

#### Email Configuration
- `$sender_email`- The email address from which the emails for registration and ticket purchase will be sent
- `$registration_email_subject` - The subject of the email for Successful Registration
- `$tickets_email_subject` - The subject of the email containing the purchased tickets.

#### Encryption Configuration
- `$db_encryption_key` - Encryption key for Database (Used for `AES_ENCRYPT, AES_DECRYPT` method)
- `$ssl_encryption_key` - SSL Encryption Key (Used for Encrypting DOM ids and URL variables)
- `$ssl_encryption_iv` - SSL Encryption IV (Used for Encrypting DOM ids and URL variables)

#### Winner/Claim Categories Configuration
##### Top Line
- `$allow_top_line` - Set `true` if you want to list 'Top Line' Category for Claiming, Set `false` if not.
- `$max_top_line_winners` - Maximum number of Winners for 'Top Line' Category after which the category will be removed from the listing in Claim Popup box

##### Middle Line
- `$allow_middle_line` - Set `true` if you want to list 'Middle Line' Category for Claiming, Set `false` if not.
- `$max_middle_line_winners` - Maximum number of Winners for 'Middle Line' Category after which the category will be removed from the listing in Claim Popup box

##### Bottom Line
- `$allow_bottom_line` - Set `true` if you want to list 'Bottom Line' Category for Claiming, Set `false` if not.
- `$max_bottom_line_winners` - Maximum number of Winners for 'Bottom Line' Category after which the category will be removed from the listing in Claim Popup box

##### Four Corners
- `$allow_four_corners` - Set `true` if you want to list 'Four Corners' Category for Claiming, Set `false` if not.
- `$max_four_corners_winners` - Maximum number of Winners for 'Four Corners' Category after which the category will be removed from the listing in Claim Popup box

##### Star (Four Corners + Middle Line Center)
- `$allow_star` - Set `true` if you want to list 'Star' Category for Claiming, Set `false` if not.
- `$max_star_winners` - Maximum number of Winners for 'Star' Category after which the category will be removed from the listing in Claim Popup box

##### Full House
- `$allow_full_house` - Set `true` if you want to list 'Full House' Category for Claiming, Set `false` if not.
- `$max_full_house_winners` - Maximum number of Winners for 'Full House' Category after which the category will be removed from the listing in Claim Popup box


## FAQ

- **I have installed Xampp on Windows How do I get Started ?**
    - Just clone this repository into your `htdocs` folder and import the given SQL file into your database and modify the `config.php` file according to your need. 
- **I want to change a few of the core functionalities of this Application what Should I do ?**
    - Make necessary changes to `functions.php` file in user directory to make changes in the main functions of the application
- **Where can I change the images like for Background and Mail and everything?**
    - Images for application are in `images` folder and for mail, there is a separate `mail` folder, Just replace the images there. 
- **How to Login to Admin ?**
    - By Default, a user with username `admin` and password `admin` will be created when you import the database, if you want to make multiple admins, just change the `role` column in the `user` table.


## Support

Reach out to us at one of the following places!

- Website at <a href="http://www.spec-india.com" target="_blank">`spec-india.com`</a>
- Facebook at <a href="https://www.facebook.com/pages/SPEC-INDIA/182501847643" target="_blank">`SPEC INDIA`</a>
- Google+ at <a href="https://plus.google.com/+SpecindiaSPECINDIA" target="_blank">`SPEC INDIA`</a>
- LinkedIn at <a href="https://www.linkedin.com/company/spec-india" target="_blank">`SPEC INDIA`</a>
- Twitter at <a href="https://twitter.com/infospec_india" target="_blank">`SPEC INDIA`</a>
- Skype at <a href="callto://bdspecindia" target="_blank">`SPEC INDIA`</a>
- Blogs at <a href="https://www.spec-india.com/blog/feed/" target="_blank">`SPEC INDIA Blog`</a>

---


## License

[![License](http://img.shields.io/:license-mit-blue.svg?style=flat-square)](http://badges.mit-license.org)

- **[MIT license](http://opensource.org/licenses/mit-license.php)**
- Copyright 2019 © <a href="http://www.spec-india.com" target="_blank">SPEC INDIA</a>.
