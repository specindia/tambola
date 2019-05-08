<?php
session_start();
include_once('../connect.php');
include_once('admin_functions.php');
if(getUserRole($conn,$_SESSION['username'])){
	$username_enc=encrypt_decrypt('encrypt','username');
	$action_enc=encrypt_decrypt('encrypt','action');
	$block_enc=encrypt_decrypt('encrypt','block');
	$unblock_enc=encrypt_decrypt('encrypt','unblock');
	$mark_paid_enc=encrypt_decrypt('encrypt','mark_paid');
	$accept_claim_enc=encrypt_decrypt('encrypt','accept_claim');
	$reject_claim_enc=encrypt_decrypt('encrypt','reject_claim');
	$undo_winner_string_enc=encrypt_decrypt('encrypt','undo_winner');
	$release_ticket_enc=encrypt_decrypt('encrypt','release_ticket');
	
	$action=$_GET[$action_enc];
	if($action==$block_enc){
		$username_val_enc=$_GET[$username_enc];
		$username_val=encrypt_decrypt('decrypt',$username_val_enc);
		if(blockUserByID($conn,$_SESSION['username'],$username_val)){
			header('Location:index.php?screen=all_users');
		}
		else{
			header('Location:index.php?screen=all_users&msg=Unable to Block User, Please Try Again');
		}
	}
	else if($action==$unblock_enc){
		$username_val_enc=$_GET[$username_enc];
		$username_val=encrypt_decrypt('decrypt',$username_val_enc);
		if(unblockUserByID($conn,$_SESSION['username'],$username_val)){
			header('Location:index.php?screen=all_users');
		}
		else{
			header('Location:index.php?screen=all_users&msg=Unable to unblock User, Please Try Again');
		}
	}
	else if($action==$mark_paid_enc){
		$username_val_enc=$_GET[$username_enc];
		$username_val=encrypt_decrypt('decrypt',$username_val_enc);
		if(updateUserStatus($conn,$username_val,'confirmed')){
			header('Location:index.php?screen=payment');
		}
		else{
			header('Location:index.php?screen=payment&msg=Unable to unblock User, Please Try Again');
		}
	}
	else if($action==$accept_claim_enc){
		$username_val_enc=$_GET[$username_enc];
		$username_val=encrypt_decrypt('decrypt',$username_val_enc);
		$ticket_id_enc=encrypt_decrypt('encrypt','ticket_id');
		$ticket_id=encrypt_decrypt('decrypt',$_GET[$ticket_id_enc]);
		if (updateTicketStatus($conn,$_SESSION['username'],$username_val,$ticket_id,'winner')) {
			header('Location:index.php?screen=prize_claims');
		}
		else{
			header('Location:index.php?screen=prize_claims&msg=Unable to Accept Claim, Please Try Again');	
		}
	}
	else if($action==$reject_claim_enc){
		$username_val_enc=$_GET[$username_enc];
		$username_val=encrypt_decrypt('decrypt',$username_val_enc);
		$ticket_id_enc=encrypt_decrypt('encrypt','ticket_id');
		$ticket_id=encrypt_decrypt('decrypt',$_GET[$ticket_id_enc]);
		if (updateTicketStatus($conn,$_SESSION['username'],$username_val,$ticket_id,'rejected')) {
			header('Location:index.php?screen=prize_claims');
		}
		else{
			header('Location:index.php?screen=prize_claims&msg=Unable to Reject Claim, Please Try Again');	
		}
	}
	else if($action==$undo_winner_string_enc){
		$username_val_enc=$_GET[$username_enc];
		$username_val=encrypt_decrypt('decrypt',$username_val_enc);
		$ticket_id_enc=encrypt_decrypt('encrypt','ticket_id');
		$ticket_id=encrypt_decrypt('decrypt',$_GET[$ticket_id_enc]);
		if (updateTicketStatus($conn,$_SESSION['username'],$username_val,$ticket_id,'claimed')) {
			header('Location:index.php?screen=winners');
		}
		else{
			header('Location:index.php?screen=winners&msg=Unable to Undo The Winner, Please Try Again');	
		}
	}
	else if($action==$release_ticket_enc){
		$ticket_id_enc=encrypt_decrypt('encrypt','ticket_id');
		$ticket_id=encrypt_decrypt('decrypt',$_GET[$ticket_id_enc]);
		if (releaseTicketByID($conn,$ticket_id)) {
			header('Location:index.php?screen=prize_claims');
		}
		else{
			header('Location:index.php?screen=winners&msg=Unable to Undo The Winner, Please Try Again');	
		}
	}



}
?>