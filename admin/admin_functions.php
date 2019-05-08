<?php
function encrypt_decrypt($action, $string) {
	$output = false;
	$encrypt_method = "AES-256-CBC";
	$secret_key = 'specTambola2018';
	$secret_iv = 'spec2018';
    // hash
	$key = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
	$iv = substr(hash('sha256', $secret_iv), 0, 16);
	if ( $action == 'encrypt' ) {
		$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
		$output = base64_encode($output);
	} else if( $action == 'decrypt' ) {
		$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
	}
	return $output;
} 
function getUserRole($conn,$username){
	$sql="SELECT role from user where username='".$username."'";
	if($result=$conn->query($sql)){
		$row=$result->fetch_assoc();
		return $row['role'];
	}
	else{
		return false;
	}
}
function getUserDetails($conn,$user){
  $sql="SELECT username,fname,lname from user where username='".$user."'";
  $result=$conn->query($sql);
  if($row=$result->fetch_assoc()){
    return $row;
  }
  else{
    return false;
  }
}
function getAllUsers($conn,$username){
	$role=getUserRole($conn,$username);
	if($role=="ADM"){
		$users=array();
		$sql="SELECT * from user order by role";
		$result=$conn->query($sql);
		$n=0;
		while($row=$result->fetch_assoc()){
			$n++;
			$users[$n]['spec_id']=$row['username'];
			$users[$n]['fname']=$row['fname'];
			$users[$n]['lname']=$row['lname'];
			// $users[$n]['vertical']=$row['vertical'];
			$users[$n]['email']=$row['email'];
			$users[$n]['no_tickets']=$row['no_tickets'];
			$users[$n]['status']=$row['status'];
		}
		return $users;
	}
	else{
		return false;
	}
}
function getAllUsersByStatus($conn,$username,$status){
	$role=getUserRole($conn,$username);
	if($role=="ADM"){
		$users=array();
		$sql="SELECT * from user where status='".$status."'";
		$result=$conn->query($sql);
		$n=0;
		while($row=$result->fetch_assoc()){
			$n++;
			$users[$n]['spec_id']=$row['username'];
			$users[$n]['fname']=$row['fname'];
			$users[$n]['lname']=$row['lname'];
			// $users[$n]['vertical']=$row['vertical'];
			$users[$n]['email']=$row['email'];
			$users[$n]['no_tickets']=$row['no_tickets'];
		}
		return $users;
	}
	else{
		return false;
	}
}
function getTicketsByStatus($conn,$username,$status){
	$role=getUserRole($conn,$username);
	if($role=="ADM"){
		$sql="SELECT * from tickets where status='".$status."'";
		$result=$conn->query($sql);
		$tickets=array();
		$n=0;
		while($row=$result->fetch_assoc()){
			$n++;
			$tickets[$n]['id']=$row['id'];
			$tickets[$n]['username']=$row['username'];
			$tickets[$n]['ticket_obj']=encrypt_decrypt('decrypt',$row['ticket_obj']);
			$tickets[$n]['claim_category']=$row['claim'];
			$tickets[$n]['claim_time']=$row['claim_time'];
		}
		return $tickets;
	}
}
function getUserByID($conn,$user_id){
	$sql="SELECT * FROM user where username='".$user_id."'";
	$result=$conn->query($sql);
	$row=$result->fetch_assoc();
	return $row;
}

function printTambolaTicketObj($tambola){
	echo '<div class="table-wrapper ticket-table"><table cellpadding="5" cellspacing="10" class="table table-bordered table-sm">';
	$table=$tambola;
	for ($j=0; $j <3 ; $j++) { 
		echo '<tr>';
		for ($k=0; $k <9 ; $k++) { 
			if(isset($table[$j][$k]->meta_checked)&&isset($table[$j][$k]->value)){
				if($table[$j][$k]->meta_checked==1){
					$class="number_ticked";
				}
				else{
					$class="";
				}
				echo '<td  class="'.$class.'"><div>'.$table[$j][$k]->value.'</div></td>';
			}
			else{
				$tempering=true;
			}
		}
		echo '</tr>';
	}
	if (isset($tempering)) {
		echo 'Tampered Ticket';
	}
	echo '</table></div>';
}
function updateUserStatus($conn,$username,$status){
	$sql="UPDATE `user` SET status='".$status."' where username='".$username."'";
	if($conn->query($sql)){
		return true;
	}
	else{
		return false;
	}
}
function deleteTicketsByUserID($conn,$admin_username,$username){
	$role=getUserRole($conn,$admin_username);
	if($role=="ADM"){
		$sql="DELETE FROM `tickets` WHERE username='".$username."'";
		if($conn->query($sql)){
			return true;
		}
		else{
			return false;
		}
	}
}
function blockUserByID($conn,$admin_username,$username){
	$role=getUserRole($conn,$admin_username);
	if($role=="ADM"){
		if(updateUserStatus($conn,$username,'blocked')){
			if (getUserTickets($conn,$username)) {
				if(deleteTicketsByUserID($conn,$admin_username,$username)){
					return true;
				}
				else{
					return false;
				}	
			}
		}
		else{
			return false;	
		}
	}
	else{
		return false;
	}
}
function getNoOfTicketsByUser($conn,$username){
	$sql="SELECT no_tickets from user where username='".$username."'";
	$result=$conn->query($sql);
	$row=$result->fetch_assoc();
	return $row['no_tickets'];
}
function getUserTickets($conn,$username){
	$sql="SELECT * FROM `tickets` WHERE username='".$username."'";
	$tickets=array();
	$result=$conn->query($sql);
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
function unblockUserByID($conn,$admin_username,$user_id){
	$role=getUserRole($conn,$admin_username);
	if($role=="ADM"){
		if (getNoOfTicketsByUser($conn,$user_id)==0) {
			if(updateUserStatus($conn,$user_id,'new')){
				return true;
			}
			else{
				return false;	
			}	
		}
		else{
			if(updateUserStatus($conn,$user_id,'payment_pending')){
				return true;
			}
			else{
				return false;	
			}	
		}
	}
	else{
		return false;
	}
}

function updateTicketStatus($conn,$admin_username,$username,$ticket_id,$status){
	$role=getUserRole($conn,$admin_username);
	if($role=="ADM"){
		$sql="UPDATE `tickets` SET status='".$status."' WHERE username='".$username."' AND id=".$ticket_id;
		echo $sql;
		if($conn->query($sql)){
			return true;
		}
		else{
			return false;
		}
	}
}

function getTotalNoOfUsers($conn){
	$sql="SELECT COUNT('username') as total from user where role='USR'";
	$result=$conn->query($sql);
	$row=$result->fetch_assoc();
	if($row['total']>0){
		return $row["total"];
	}
	else{
		return 0;
	}
}

function getNoOfUserByStatus($conn,$status){
	$sql="SELECT COUNT('username') as total from user where status='".$status."' AND role='USR'";
	$result=$conn->query($sql);
	$row=$result->fetch_assoc();
	if($row['total']>0){
		return $row["total"];
	}
	else{
		return 0;
	}
}

function getTotalTickets($conn){
	$sql="SELECT COUNT('id') as total from tickets";
	$result=$conn->query($sql);
	$row=$result->fetch_assoc();
	if($row['total']>0){
		return $row["total"];
	}
	else{
		return 0;
	}
}

function getNoOfTicketsByStatus($conn,$status){
	$sql="SELECT COUNT('id') as total from tickets where status='".$status."'";
	$result=$conn->query($sql);
	$row=$result->fetch_assoc();
	if($row['total']>0){
		return $row["total"];
	}
	else{
		return 0;
	}
}

function getTotalIncome($conn){
	$sql="SELECT SUM(no_tickets) as total from user where role='USR'";
	$result=$conn->query($sql);
	$row=$result->fetch_assoc();
	if($row['total']>0){
		return $row["total"];
	}
	else{
		return 0;
	}
}

function getPaidCount($conn){
	$sql="SELECT SUM(no_tickets) as total from user where status='confirmed' OR status='tickets_generated'";
	$result=$conn->query($sql);
	$row=$result->fetch_assoc();
	if($row['total']>0){
		return $row["total"];
	}
	else{
		return 0;
	}	
}

function getUnpaidCount($conn){
	$sql="SELECT SUM(no_tickets) as total from user where status='new' OR status='payment_pending'";
	$result=$conn->query($sql);
	$row=$result->fetch_assoc();
	if($row['total']>0){
		return $row["total"];
	}
	else{
		return 0;
	}		
}


function getWinnersByCategory($conn,$category){
	$sql="SELECT COUNT(id) as total from tickets where claim='".$category."' AND status='winner'";
	$result=$conn->query($sql);
	$row=$result->fetch_assoc();
	if($row['total']>0){
		return $row["total"];
	}
	else{
		return 0;
	}		
}

function releaseTicketByID($conn,$ticket_id){
	$sql="UPDATE tickets SET claim='',claim_time=NULL,status='new' WHERE id=".$ticket_id;
	if($conn->query($sql)){
		return true;
	}
	else{
		return false;
	}
}
?>
