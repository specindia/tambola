<?php
function randomPassword() {
  $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
      $n = rand(0, $alphaLength);
      $pass[] = $alphabet[$n];
  }
    return implode($pass); //turn the array into a string
}
function registrationMail($email,$fullname,$username,$password){
    global $application_url,$sender_email,$registration_email_subject;
    $mailContent='<body style="margin:0; padding:0; background-color:#F2F2F2;">
    <table style="width: 100%;text-align: center;white-space: normal;
    line-height: normal;
    font-weight: normal;border:0px;" cellspacing="0" cellpadding="0">'. "\r\n".'<tr>
    <td align="center">
    <table width="800" cellspacing="0" cellpadding="0" border="0" align="center" style="background-color:#1D093A;" bgcolor="#1D093A">
    <tbody>
    <tr>
    <td align="center" colspan="3" valign="top" style="padding-top:10px; color: white;">
    <img src="'.$application_url.'/mail/header.png">
    </td>
    </tr>'. "\r\n".'<tr>
    <td width="100" style="min-width:100px;width: 100px;">
    <span style="width:100px;min-width:100px;max-width:100px;">
    </td>
    <td align="center" valign="top" style="">
    <table width="700" cellspacing="0" cellpadding="0" border="0" align="center" style="max-width:700px; width:100%;">
    <tbody>
    <tr>
    <td align="left" valign="top" style="font-size:21px; padding-top:10px; color: white;">
    <strong>Hey There!</strong>
    </td>
    </tr>
    <tr>
    <td align="left" valign="top" style="font-size:36px; padding-top:15px; color: white; color: #FFB216;">'.$fullname.'
    </td>
    </tr>'. "\r\n".'<tr>
    <td colspan="2" align="left" valign="top" style="font-size:21px; padding-top:20px; color: white;">
    Thanks for signing up. Here are your login credentials. Get ready for 10
    days of crazy entertainment that is heading your way!
    </td>
    </tr>
    <tr>
    <td align="left" valign="top" style="font-size:36px; padding-top:50px; color: white;">
    ID:
    </td>
    <td align="right" valign="top" style="font-size:36px; padding-top:50px; color: #FFB216;">'.$username.'
    </td>
    </tr>
    <tr>
    <td align="left" valign="top" style="font-size:36px; padding-top:20px; color: white; padding-bottom:30px;">
    Password:
    </td>
    <td align="right" valign="top" style="font-size:36px; padding-top:20px; color: #FFB216; padding-bottom:30px;">
    '.$password.'
    </td>
    </tr>
    <tr>
    <td colspan="2" align="left" valign="top" style="font-size:21px; padding-top:20px; color: white;">
    The next step is to login and generate your Tambola Tickets. You can
    find the link from here: 
    </td>
    </tr>
    <tr>
    <td colspan="2" align="left" valign="top" style="font-size:26px; padding-top:40px; color: #FFB216; font-weight: 500">
    <a href="'.$application_url.'" style="font-size:26px; color: #FFB216; font-weight: 500;text-decoration:none">'.$application_url.'</a> 
    </td>
    </tr>
    <tr>
    <td colspan="2" align="left" valign="top" style="font-size:32px; padding-top:50px; color: white;">
    All the Best! 
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    <td width="100" style="min-width:100px;width: 100px;">
    <span style="width:100px;min-width:100px;max-width:100px;">
    </td>
    </tr>
    <tr>
    <td align="center" colspan="3" valign="top" style="padding-top:10px; color: white;">
    <img src="'.$application_url.'/mail/footer.png">
    </td>
    </tr>'. "\r\n".'</tbody>
    </table>
    </td>
    </tr>
    </table>
    </body>';

    $to = $email;
    $subject = $registration_email_subject;
    $message = '<style>body{font-family:"Calibri";}</style>'.$mailContent;
    $headers = 'From:'.$sender_email. "\r\n";
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    mail($to, $subject, $message, $headers);
}
function printTambolaTicketObjforMail($tambola,$i){
    $colors=array('#FF7F00','#78BA12','#FFBC01','#2A39D2','#DD367B');
    $string='<table style="background-color:'.$colors[$i%5].';font-weight:bold;color:black;margin-top:10px;width:100%;height:180px;text-align:center" border="2" cellpadding="10" bordercolor="white" cellspacing="10">';
    $table=$tambola;
    for ($j=0; $j <3 ; $j++) { 
        $string.='<tr>';
        for ($k=0; $k <9 ; $k++) { 
            if (isset($table[$j][$k]->value)) {
               $string.='<td bgcolor="#ffffff">'.$table[$j][$k]->value.'</td>';
           }
           else{
            $string.='<td></td>';
        }
    }
    $string.='</tr>';
}
$string.='</table><br>';
return $string;
}
function ticketsMail($conn,$email,$fullname,$user_id){
    global $application_url,$sender_email,$tickets_email_subject;
    $mailContent='<body style="margin:0; padding:0; background-color:#F2F2F2;">
    <table style="width: 100%;text-align: center;white-space: normal;
    line-height: normal;
    font-weight: normal;border:0px;" cellspacing="0" cellpadding="0">
    <tr>
    <td align="center">
    <table width="800" cellspacing="0" cellpadding="0" border="0" align="center" style="background-color:#1D093A;" bgcolor="#1D093A">
    <tbody>
    <tr>
    <td align="center" colspan="3" valign="top" style="padding-top:10px; color: white;">
    <img src="'.$application_url.'/mail/header.png">
    </td>
    </tr>
    <tr>
    <td width="100" style="min-width:100px;width: 100px;">
    <span style="width:100px;min-width:100px;max-width:100px;">
    </td>
    <td align="center" valign="top" style="">
    <table width="700" cellspacing="0" cellpadding="0" border="0" align="center" style="max-width:700px; width:100%;">
    <tbody>
    <tr>
    <td align="left" valign="top" style="font-size:21px; padding-top:10px; color: white;">
    <strong>Hey There!</strong>
    </td>
    </tr>'. "\r\n".'<tr>
    <td align="left" valign="top" style="font-size:36px; padding-top:15px; color: white; color: #FFB216;">'.$fullname.'
    </td>
    </tr>
    <tr>
    <td colspan="2" align="left" valign="top" style="font-size:21px; padding-top:20px; color: white;">
    Your Tickets have been generated please find a copy of the tickets for the future referance, Please do not delete this e-mail otherwise no objections will be appreciated in case of any conflict.
    </td>
    </tr>';
    $tickets=getUserTickets($conn,$user_id);
    $i=0;
    foreach ($tickets as $ticket) {
        $mailContent.='<tr><td><br><h4 style="color:white">TICKET ID : '.$ticket['id'].'</h4>'.printTambolaTicketObjforMail(json_decode(base64_decode($ticket['ticket_obj'])),$i).'</td></tr>'. "\r\n";
        $i++;
    }
    $mailContent.='<tr><td colspan="2" align="left" valign="top" style="font-size:21px; padding-top:20px; color: white;">
    The next step is to keep checking the numbers being declared. You can
    find the link from here: 
    </td>
    </tr>
    <tr>
    <td colspan="2" align="left" valign="top" style="font-size:26px; padding-top:40px; color: #FFB216; font-weight: 500">
    <a href="'.$application_url.'" style="font-size:26px; color: #FFB216; font-weight: 500;text-decoration:none">'.$application_url.'</a> 
    </td>
    </tr>
    <tr>
    <td colspan="2" align="left" valign="top" style="font-size:32px; padding-top:50px; color: white;">
    All the Best! 
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    <td width="100" style="min-width:100px;width: 100px;">
    <span style="width:100px;min-width:100px;max-width:100px;">
    </td>
    </tr>'. "\r\n".'<tr>
    <td align="center" colspan="3" valign="top" style="padding-top:10px; color: white;">
    <img src="'.$application_url.'/mail/footer.png">
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </table>
    </body>';

    $to = $email;
    $subject = $tickets_email_subject;
    $message = '<style>body{font-family:"Calibri";}</style>'.$mailContent;
    $headers = 'From:'.$sender_email. "\r\n";
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    mail($to, $subject, $message, $headers);
}
function UniqueRandomNumbersWithinRange($min, $max, $quantity) {
    $numbers = range($min, $max);
    shuffle($numbers);
    return array_slice($numbers, 0, $quantity);
}
function encrypt_decrypt($action, $string) {
    global $ssl_encryption_key,$ssl_encryption_iv;
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = $ssl_encryption_key;
    $secret_iv = $ssl_encryption_iv;
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ( $action == 'encrypt' ) {
      $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
      $output = base64_encode($output);
  } else if( $action == 'decrypt' ) {
      $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
  }
  return $output;
}
function generateTambolaTicket(){
    $empty_index=array();
    $tambola=array();
    for ($i=0; $i <3 ; $i++) { 
        $empty_index[$i][]=UniqueRandomNumbersWithinRange(0,8,4);
    }
    while(array_intersect($empty_index[0][0],$empty_index[1][0],$empty_index[2][0])){
        $empty_index[2][0]=UniqueRandomNumbersWithinRange(0,8,4);
    }
    $n=0;
    for ($i=0; $i <9 ; $i++) { 
        if(!in_array($i, $empty_index[0][0])&&!in_array($i, $empty_index[1][0])){
            $empty_index[2][0][$n]=$i;
            $n++;
        }
    }
    $empty_count=count(array_unique($empty_index[2][0]));
    while($empty_count<4){
        for ($i=$empty_count; $i <4 ; $i++) { 
            $temp=rand(0,8);
            while(in_array($temp,array_intersect($empty_index[0][0],$empty_index[1][0]))){
                $temp=rand(0,8);
            }
            $empty_index[2][0][$i]=$temp;
            $empty_count=count(array_unique($empty_index[2][0]));
        }
    }
    $list=array();
    for ($row=0; $row <3 ; $row++) { 
        for ($col=0; $col <9 ; $col++) {
            $min=$col*10+1;
            $max=$col*10+10;
            $tambola[$row][$col]['id']=$row.$col;
            if(!in_array($col, $empty_index[$row][0])){
                $temp=rand($min,$max);
                while (in_array($temp, $list)) {
                    $temp=rand($min,$max);
                }
                $list[]=$temp;
                $tambola[$row][$col]['value']=$temp;
            }
            else{
                $tambola[$row][$col]['value']='';   
            }
            $tambola[$row][$col]['meta_checked']=0;
        }
    }
    return $tambola;
}

function printTambolaTicket($tambola){
    echo '<div class="table-wrapper"><table>';
    $table=$tambola;
    for ($j=0; $j <3 ; $j++) { 
        echo '<tr>';
        for ($k=0; $k <9 ; $k++) { 
            echo '<td>'.$table[$j][$k]['value'].'</td>';
        }
        echo '</tr>';
    }
    echo '</table></div>';
}

function printTambolaTicketObj($tambola){
    echo '<div class="table-wrapper"><table cellpadding="5" cellspacing="10" class="table-borderless">';
    $table=$tambola;
    for ($j=0; $j <3 ; $j++) { 
        echo '<tr>';
        for ($k=0; $k <9 ; $k++) { 
            if (isset($table[$j][$k]->value)) {
               echo '<td><div>'.$table[$j][$k]->value.'</div></td>';
           }
       }
       echo '</tr>';
   }
   echo '</table></div>';
}

function printTambolaTicketObjWithChekboxes($tambola){
    echo '<div class="table-wrapper"><table cellpadding="5" cellspacing="10" class="table-borderless">';
    $table=$tambola;
    for ($j=0; $j <3 ; $j++) { 
        echo '<tr>';
        for ($k=0; $k <9 ; $k++) { 
            if (isset($table[$j][$k]->meta_checked)&&isset($table[$j][$k]->value)) {
                if($table[$j][$k]->meta_checked==1){
                    $checked='checked';
                    $class='number_ticked before-old';
                }
                else{
                    $checked='';   
                    $class='';
                }
                echo '<td>';
                if($table[$j][$k]->value!=''){
                    echo '<div class="checkable_div '.$class.'">';
                    echo '<input type="checkbox" class="d-none" name="'.encrypt_decrypt('encrypt',$table[$j][$k]->id).'" '.$checked.'>';
                }
                else{
                    echo '<div>';
                }
                echo $table[$j][$k]->value.'</div></td>';
            }
            else{
                $GLOBALS['temper']=true;
            }
        }
        echo '</tr>';
    }
    if ($GLOBALS['temper']==true) {
        echo "Don't Try to Tamper the Ticket";
    }
    echo '</table></div>';
}

function getNoOfTicketsByUser($conn,$username){
    $sql=$conn->prepare("SELECT no_tickets from user where username=?");
    $sql->bind_param('s',$username);
    $sql->execute();
    $result=$sql->get_result();
    $row=$result->fetch_assoc();
    return $row['no_tickets'];
}

function getUserStatus($conn,$username){
    $sql=$conn->prepare("SELECT status from user where username=?");
    $sql->bind_param('s',$username);
    $sql->execute();
    $result=$sql->get_result();
    $row=$result->fetch_assoc();
    return $row['status'];   
}

function insertTambolaTicket($conn,$tambola,$username){
    $ticket_obj=base64_encode(json_encode($tambola));
    $encrypted = encrypt_decrypt('encrypt',$ticket_obj);
    
    $sql=$conn->prepare("INSERT INTO `tickets`(`username`, `ticket_obj`, `status`) VALUES (?,?,'new')");
    $sql->bind_param('ss',$username,$encrypted);
    if($sql->execute()){
        return true;
    }
    else{
        return false;
    }

}
function updateUserStatus($conn,$username,$status){
    $sql=$conn->prepare("UPDATE `user` SET status=? where username=?");
    $sql->bind_param('ss',$status,$username);
    if($sql->execute()){
        return true;
    }
    else{
        return false;
    }
}

function getUserTickets($conn,$username){
    $sql=$conn->prepare("SELECT * FROM `tickets` WHERE username=?");
    $sql->bind_param('s',$username);
    $sql->execute();
    $result=$sql->get_result();
    $tickets=array();
    $i=0;
    while($row=$result->fetch_assoc()){
        $tickets[$i]['id']=$row['id'];
        $tickets[$i]['ticket_obj']= encrypt_decrypt('decrypt',$row['ticket_obj']);
        $tickets[$i]['claim']=$row['claim'];
        $tickets[$i]['status']=$row['status'];
        $tickets[$i]['comment']=$row['comment'];
        $i++;
    }
    return $tickets;
}
function getTicketByID($conn,$username,$ticket_id){
    $sql=$conn->prepare("SELECT * FROM `tickets` WHERE username=? AND id=?");
    $sql->bind_param('si',$username,$ticket_id);
    $sql->execute();
    $result=$sql->get_result();
    $tickets=array();
    $row=$result->fetch_assoc();
    $tickets['id']=$row['id'];
    $tickets['ticket_obj']=encrypt_decrypt('decrypt',$row['ticket_obj']);
    $tickets['claim']=$row['claim'];
    $tickets['status']=$row['status'];
    $tickets['comment']=$row['comment'];
    return $tickets;
}
function updateTicketByID($conn,$username,$ticket_id,$ticket_array){
    $ticket_string=encrypt_decrypt('encrypt',base64_encode(json_encode($ticket_array)));

    $sql=$conn->prepare("UPDATE `tickets` SET `ticket_obj`=? WHERE username=? AND id=?");
    $sql->bind_param('ssi',$ticket_string,$username,$ticket_id);

    if($sql->execute()){
        return true;
    }
    else{
        return false;
    }
}

function buyTickets($conn,$username,$ticketno){
    $sql=$conn->prepare("UPDATE `user` SET no_tickets=? where username=?");
    $sql->bind_param('ss',$ticketno,$username);

    if($sql->execute()){
        return true;
    }
    else{
        return false;
    }
}

function claimPrize($conn,$username,$ticket_id_val,$claim_category){
    $sql=$conn->prepare("UPDATE `tickets` SET claim=?,status='claimed',claim_time=CURRENT_TIMESTAMP() WHERE username=? AND id=?");
    $sql->bind_param('sss',$claim_category,$username,$ticket_id_val);

    if($sql->execute()){
        return true;
    }
    else{
        return false;
    }
}
function getWinnersByCategory($conn,$category){
    $sql=$conn->prepare("SELECT COUNT(id) as total from tickets where claim=? AND status='winner'");
    $sql->bind_param('s',$category);
    $sql->execute();
    $result=$sql->get_result();

    $row=$result->fetch_assoc();
    if($row['total']>0){
        return $row["total"];
    }
    else{
        return 0;
    }       
}
function printStatus($claim_string){
    if ($claim_string=='top_line') {
        return 'Top Line';
    }
    else if ($claim_string=='middle_line'){
        return 'Middle Line';   
    }
    else if ($claim_string=='bottom_line'){
        return 'Bottom Line';   
    }
    else if ($claim_string=='first_seven'){
        return 'First Seven';   
    }
    else if ($claim_string=='four_corners'){
        return 'Four Corners';   
    }
    else if ($claim_string=='star'){
        return 'Star';   
    }
    else if ($claim_string=='full_house'){
        return 'Full House';   
    }
}
?>