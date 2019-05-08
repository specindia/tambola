<?php
session_start();
if ($_SESSION['role']!='ADM') {
	header('Location:../');
}
include_once('../connect.php');
include_once('admin_functions.php');
if(isset($_POST['declare_numbers'])){
	$string='eTambola Numbers Declared : ';
	$n=1;
	foreach ($_POST['number'] as $key => $value) {
		$no=encrypt_decrypt('decrypt',$key);
		if($n==1){
			$string.=$no;
		}
		else
		{
			$string.=', '.$no;	
		}
		if ($value=='on') {
			$sql="UPDATE `numbers` SET `status`='declared',`declaration_time`=CURRENT_TIMESTAMP() WHERE `number`=".$no."";
			$conn->query($sql);
		}
		$n++;
	}
	// $subject = 'eTambola Numbers Declared';
	// $message = '';
	// $headers = "From: niraj.gohel@spec-india.com". "\r\n";
	// $headers .= "MIME-Version: 1.0" . "\r\n";
	// $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	// mail('spec-group@spec-india.com', $subject, $message, $headers);
}
if(!isset($_GET['screen'])){
	header('Location:index.php?screen=dashboard');
}
$ticket_price=$ticket_rate;
?>
<html>
<head>
	<meta charset="UTF-8">
	<title><?php echo $application_title; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/font-awesome-all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
	<link rel="stylesheet" href="../css/jquery-ui.css" />
	<link rel="stylesheet" href="../css/swiper.min.css" />
	<link rel="stylesheet" href="../css/dataTables.bootstrap4.min.css"/>
	<!-- <link rel = "stylesheet" href = "http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css"> -->
	<link rel="stylesheet" href="style.css">
	<style>
	table.reflow {
		width: 100%;
	}
	table.reflow th, table.reflow td {
		text-align: left;
		border-bottom: 1px dashed silver;
	}
	table.reflow .cell-label {
		display: none;
	}

	@media screen and (max-width: 480px) {
		table.reflow th {
			display: none;
		}
		table.reflow tr td {
			float: left;
			clear: left;
			display: block;
			width: 100%;
		}
		table.reflow tr td:last-child {
			padding-bottom: 20px;
			border-bottom: 0;
		}
		table.reflow .cell-label {
			display: block;
			float: left;
		}
		table.reflow .cell-content {
			display: block;
			float: right;
		}
	}

</style>
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 p-0">
				<nav class="navbar navbar-expand-sm bg-white navbar-light justify-content-between">
					<a class="navbar-brand">
						<?php echo $application_title; ?>
					</a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse justify-content-end" id="collapsibleNavbar">
						<ul class="navbar-nav d-block d-md-none">
							<li class="nav-item mt-3 border-bottom">
								<label for="">General</label>
							</li>
							<li class="nav-item">
								<a class="nav-link active" href="?screen=dashboard">Dashboard</a>
							</li>
							<li class="nav-item mt-3 border-bottom">
								<label for="">Users</label>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="?screen=all_users">All Users</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="?screen=payment">Payment</a>
							</li>
							<li class="nav-item mt-3 border-bottom">
								<label for="">Tickets</label>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="?screen=prize_claims">Prize Claims</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="?screen=winners">Winners</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="?screen=rejected">Rejected Tickets</a>
							</li>
							<li class="nav-item mt-3 border-bottom">
								<label for="">Number Declaration</label>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="?screen=numbers">Declare Number</a>
							</li>
							<li class="nav-item mt-3 border-bottom">
								<label for="">Secret Santa</label>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="?screen=santa">List</a>
							</li>
						</ul>
						<ul class="navbar-nav pt-5 pt-md-0">
							<li class="nav-item">
								<a class="nav-link" href="../logout.php">Logout</a>
							</li>
						</ul>
					</div>
				</nav>
			</div>
		</div>
		<div class="row h-100">
			<div class="col-12 d-none d-md-block col-md-2 bg-light">
				<ul class="nav flex-column">
					<li class="nav-item mt-5 border-bottom">
						<label for="">General</label>
					</li>
					<li class="nav-item">
						<a class="nav-link active" href="?screen=dashboard">Dashboard</a>
					</li>
					<li class="nav-item mt-5 border-bottom">
						<label for="">Users</label>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="?screen=all_users">All Users</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="?screen=payment">Payment</a>
					</li>
					<li class="nav-item mt-5 border-bottom">
						<label for="">Tickets</label>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="?screen=prize_claims">Prize Claims</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="?screen=winners">Winners</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="?screen=rejected">Rejected Tickets</a>
					</li>
					<li class="nav-item mt-5 border-bottom">
						<label for="">Number Declaration</label>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="?screen=numbers">Declare Number</a>
					</li>
				</ul>
			</div>
			<div class="col-12 col-md-10">
				<?php if (isset($_GET['msg'])) {
					echo '<div class="my-3">'.$_GET['msg'].'</div>';
					unset($_GET['msg']);
				} ?>
				<?php if(isset($_GET['screen'])){
					if($_GET['screen']=='all_users'){
						$users=getAllUsers($conn,$_SESSION['username']);
						?>
<!-- 						<div class="row">
							<div class="col-4 offset-8">
								<input type="text" id="search" class="form-control my-3" placeholder="Search">
							</div>
						</div> -->
						<table class = "table table-sm reflow">
							<thead>
								<th>ID</th>
								<th>First Name</th>
								<th>Last Name</th>
								<!-- <th>Vertical</th> -->
								<th>Email Address</th>
								<th>Tickets</th>
								<th>Actions</th>
							</thead>
							<tbody>
								<?php
								foreach ($users as $user) {?>
									<tr>
										<td><?php echo $user['spec_id']; ?></td>
										<td><?php echo $user['fname']; ?></td>
										<td><?php echo $user['lname']; ?></td>
										<td><?php echo $user['email']; ?></td>
										<td><?php echo $user['no_tickets']; ?></td>
										<?php $blockactionstring=encrypt_decrypt('encrypt','action')."=".encrypt_decrypt('encrypt','block'); ?>
										<?php $unblockactionstring=encrypt_decrypt('encrypt','action')."=".encrypt_decrypt('encrypt','unblock'); ?>
										<?php $payactionstring=encrypt_decrypt('encrypt','action')."=".encrypt_decrypt('encrypt','mark_paid'); ?>
										<?php $userstring=encrypt_decrypt('encrypt','username')."=".encrypt_decrypt('encrypt',$user['spec_id']); ?>
										<td>
											<?php if($user['status']=='payment_pending'){ ?>
												<a class="btn btn-primary mr-2 text-white" href="action.php?<?php echo $payactionstring;?>&<?php 
												echo $userstring;
												?>">Mark Paid</a>
											<?php } ?>
											<?php if($user['status']=='blocked'){ ?>
												<a class="btn btn-default" href="action.php?<?php echo $unblockactionstring; ?>&<?php 
												echo $userstring;
												?>">Unblock</a>
											<?php } else { ?>
												<a class="btn btn-default" href="action.php?<?php echo $blockactionstring; ?>&<?php 
												echo $userstring;
												?>">Block</a>
											<?php } ?>
										</td>
									</tr>
									<?php
								}
								?>
							</tbody>
						</table>
						<?php
					}
					else if($_GET['screen']=='winners'){
						$tickets=getTicketsByStatus($conn,$_SESSION['username'],'winner');
						?>
						<div class="row">
							<div class="col-12">
								<div class="card m-2 mt-3 bg-light p-2">
									Declared Numbers:
									<?php 
									$sql="SELECT * from numbers where status='declared' order by `number`";
									$delcared_num_result=$conn->query($sql);
									while ($row=$delcared_num_result->fetch_assoc()) {
										echo $row['number'].',';
									}
									?>
								</div>
							</div>
						</div>
						<table class="table">
							<thead>
								<th>Ticket ID</th>
								<th>SPEC ID</th>
								<th>Full Name</th>
								<!-- <th>Vertical</th> -->
								<th>Email Address</th>
								<th>Time of Claim</th>
								<th>Ticket</th>
								<th>Claim Category</th>
								<th>Action</th>
							</thead>
							<tbody>
								<?php
								foreach ($tickets as $ticket) {
									?>
									<tr>
										<td><?php echo $ticket['id'];?></td>
										<?php 
										$user=getUserByID($conn,$ticket['username']);
										?>
										<td><?php echo $user['username']; ?></td>
										<td><?php echo $user['fname'].' '.$user['lname']; ?></td>
										<td><?php echo $user['email']; ?></td>
										<td><?php echo $ticket['claim_time']; ?></td>
										<td><?php printTambolaTicketObj(json_decode(base64_decode($ticket['ticket_obj']))); ?></td>
										<td><?php 
										if($ticket['claim_category']=='top_line')
										{
											echo 'Top Line';
										}
										else if($ticket['claim_category']=='middle_line'){
											echo 'Middle Line';
										}
										else if($ticket['claim_category']=='bottom_line'){
											echo 'Bottom Line';
										}
										else if($ticket['claim_category']=='first_seven'){
											echo 'First 7';
										}
										else if($ticket['claim_category']=='four_corners'){
											echo '4 Corners';
										}
										else if($ticket['claim_category']=='star'){
											echo 'Star';
										}
										else if($ticket['claim_category']=='full_house'){
											echo 'Full House';
										}


										?></td>
										<td>
											<?php $undo_winner_string=encrypt_decrypt('encrypt','action')."=".encrypt_decrypt('encrypt','undo_winner'); ?>
											<?php $userstring=encrypt_decrypt('encrypt','username')."=".encrypt_decrypt('encrypt',$user['username']); ?>
											<?php $ticketstring=encrypt_decrypt('encrypt','ticket_id')."=".encrypt_decrypt('encrypt',$ticket['id']); ?>
											<a href="action.php?<?php echo $undo_winner_string; ?>&<?php echo $userstring; ?>&<?php echo $ticketstring;?>" class="btn btn-primary">Undo</a>
										</td>
									</tr>
									<?php
								}
								?>
							</tbody>
						</table>
						<?php
					}
					else if($_GET['screen']=='payment'){
						$users=getAllUsersByStatus($conn,$_SESSION['username'],'payment_pending');
						?>
<!-- 						<div class="row">
							<div class="col-4 offset-8">
								<input type="text" id="search" class="form-control my-3" placeholder="Search">
							</div>
						</div> -->
						<table class="table">
							<thead>
								<th>SPEC ID</th>
								<th>First Name</th>
								<th>Last Name</th>
								<th>Email Address</th>
								<th>No of Tickets</th>
								<th>Amount</th>
								<th>Actions</th>
							</thead>
							<tbody>
								<?php
								foreach ($users as $user) {?>
									<tr>
										<td><?php echo $user['spec_id']; ?></td>
										<td><?php echo $user['fname']; ?></td>
										<td><?php echo $user['lname']; ?></td>
										<td><?php echo $user['email']; ?></td>
										<td><?php echo $user['no_tickets']; ?></td>
										<td><?php echo $ticket_price*$user['no_tickets']; ?></td>
										<?php $payactionstring=encrypt_decrypt('encrypt','action')."=".encrypt_decrypt('encrypt','mark_paid'); ?>
										<?php $userstring=encrypt_decrypt('encrypt','username')."=".encrypt_decrypt('encrypt',$user['spec_id']); ?>
										<td><a class="btn btn-primary mr-2 text-white" href="action.php?<?php echo $payactionstring;?>&<?php 
										echo $userstring;
										?>">Mark Paid</a><a class="btn btn-default mr-2">Decline</a></td>
									</tr>
									<?php
								}
								?>
							</tbody>
						</table>
						<?php

					}
					else if($_GET['screen']=='prize_claims'){
						$tickets=getTicketsByStatus($conn,$_SESSION['username'],'claimed');
						?>
						<div class="row">
							<div class="col-12">
								<div class="card m-2 mt-3 bg-light p-2">
									Declared Numbers:
									<?php 
									$sql="SELECT * from numbers where status='declared' order by `number`";
									$delcared_num_result=$conn->query($sql);
									while ($row=$delcared_num_result->fetch_assoc()) {
										echo $row['number'].',';
									}
									?>
								</div>
							</div>
						</div>
						<table class="table">
							<thead>
								<th>Ticket ID</th>
								<th>SPEC ID</th>
								<th>Full Name</th>
								<th>Email Address</th>
								<th>Time of Claim</th>
								<th>Ticket</th>
								<th>Claim Category</th>
								<th>Actions</th>
							</thead>
							<tbody>
								<?php
								foreach ($tickets as $ticket) {
									?>
									<tr>
										<td><?php echo $ticket['id'];?></td>
										<?php 
										$user=getUserByID($conn,$ticket['username']);
										?>
										<td><?php echo $user['username']; ?></td>
										<td><?php echo $user['fname'].' '.$user['lname']; ?></td>
										<td><?php echo $user['email']; ?></td>
										<td><?php echo $ticket['claim_time']; ?></td>
										<td><?php printTambolaTicketObj(json_decode(base64_decode($ticket['ticket_obj']))); ?></td>
										<td><?php 
										if($ticket['claim_category']=='top_line')
										{
											echo 'Top Line';
										}
										else if($ticket['claim_category']=='middle_line'){
											echo 'Middle Line';
										}
										else if($ticket['claim_category']=='bottom_line'){
											echo 'Bottom Line';
										}
										else if($ticket['claim_category']=='first_seven'){
											echo 'First 7';
										}
										else if($ticket['claim_category']=='four_corners'){
											echo '4 Corners';
										}
										else if($ticket['claim_category']=='star'){
											echo 'Star';
										}
										else if($ticket['claim_category']=='full_house'){
											echo 'Full House';
										}

										?></td>
										<td>
											<?php $accept_claim_string=encrypt_decrypt('encrypt','action')."=".encrypt_decrypt('encrypt','accept_claim'); ?>
											<?php $reject_claim_string=encrypt_decrypt('encrypt','action')."=".encrypt_decrypt('encrypt','reject_claim'); ?>
											<?php $release_ticket_string=encrypt_decrypt('encrypt','action')."=".encrypt_decrypt('encrypt','release_ticket'); ?>
											<?php $userstring=encrypt_decrypt('encrypt','username')."=".encrypt_decrypt('encrypt',$user['username']); ?>
											<?php $ticketstring=encrypt_decrypt('encrypt','ticket_id')."=".encrypt_decrypt('encrypt',$ticket['id']); ?>
											<a href="action.php?<?php echo $accept_claim_string; ?>&<?php echo $userstring; ?>&<?php echo $ticketstring;?>" class="btn btn-primary">Accept</a>
											<a href="action.php?<?php echo $reject_claim_string; ?>&<?php echo $userstring; ?>&<?php echo $ticketstring; ?>" class="btn btn-default">Reject</a>
											<a href="action.php?<?php echo $release_ticket_string; ?>&<?php echo $ticketstring; ?>" class="btn btn-default">Release</a>
										</td>
									</tr>
									<?php
								}
								?>
							</tbody>
						</table>
						<?php
					}
					else if($_GET['screen']=='rejected'){
						$tickets=getTicketsByStatus($conn,$_SESSION['username'],'rejected');
						?>
						<div class="row">
							<div class="col-12">
								<div class="card m-2 mt-3 bg-light p-2">
									Declared Numbers:
									<?php 
									$sql="SELECT * from numbers where status='declared' order by `number`";
									$delcared_num_result=$conn->query($sql);
									while ($row=$delcared_num_result->fetch_assoc()) {
										echo $row['number'].',';
									}
									?>
								</div>
							</div>
						</div>
						<table class="table">
							<thead>
								<th>Ticket ID</th>
								<th>SPEC ID</th>
								<th>Full Name</th>
								<th>Email Address</th>
								<th>Time of Claim</th>
								<th>Ticket</th>
								<th>Claim Category</th>
								<th>Actions</th>
							</thead>
							<tbody>
								<?php
								foreach ($tickets as $ticket) {
									?>
									<tr>
										<td><?php echo $ticket['id'];?></td>
										<?php 
										$user=getUserByID($conn,$ticket['username']);
										?>
										<td><?php echo $user['username']; ?></td>
										<td><?php echo $user['fname'].' '.$user['lname']; ?></td>
										<td><?php echo $user['email']; ?></td>
										<td><?php echo $ticket['claim_time']; ?></td>
										<td><?php printTambolaTicketObj(json_decode(base64_decode($ticket['ticket_obj']))); ?></td>
										<td><?php 
										if($ticket['claim_category']=='top_line')
										{
											echo 'Top Line';
										}
										else if($ticket['claim_category']=='middle_line'){
											echo 'Middle Line';
										}
										else if($ticket['claim_category']=='bottom_line'){
											echo 'Bottom Line';
										}
										else if($ticket['claim_category']=='first_seven'){
											echo 'First 7';
										}
										else if($ticket['claim_category']=='four_corners'){
											echo '4 Corners';
										}
										else if($ticket['claim_category']=='star'){
											echo 'Star';
										}
										else if($ticket['claim_category']=='full_house'){
											echo 'Full House';
										}

										?></td>
										<td>
											<?php $undo_winner_string=encrypt_decrypt('encrypt','action')."=".encrypt_decrypt('encrypt','undo_winner'); ?>
											<?php $userstring=encrypt_decrypt('encrypt','username')."=".encrypt_decrypt('encrypt',$user['username']); ?>
											<?php $ticketstring=encrypt_decrypt('encrypt','ticket_id')."=".encrypt_decrypt('encrypt',$ticket['id']); ?>
											<a href="action.php?<?php echo $undo_winner_string; ?>&<?php echo $userstring; ?>&<?php echo $ticketstring;?>" class="btn btn-primary">Undo</a>
										</td>
									</tr>
									<?php
								}
								?>
							</tbody>
						</table>
						<?php
					}
					else if($_GET['screen']=='numbers'){
						?>
						<div class="row">
							<div class="col-6 py-3">
								<h6>Declare Numbers</h6>
								<form action="" method="POST">
									<div class="row">
										<?php
										$sql="SELECT * From numbers";
										$result=$conn->query($sql);
										while($row=$result->fetch_assoc()){
											?>
											<div class="col-3">
												<?php
												if($row['status']=='not_declared'){
													?>
													<input type="checkbox" class="declaration_checkbox" name="number[<?php echo encrypt_decrypt('encrypt',$row['number']); ?>]">
													<?php 
													echo $row['number'];
												}
												?>
											</div>
											<?php
										}?>
									</div>
									<button type="submit" name="declare_numbers" class="btn btn-primary">Submit</button>
								</form>
							</div>
							<div class="col-6 py-3">
								<h6>Declared Numbers</h6>
								<table class="table">
									<thead>
										<th>Number</th>
										<th>Declaration Date Time</th>
									</thead>
									<tbody>
										<?php 
										$sql="SELECT * from numbers where status='declared' order by declaration_time DESC";
										$result=$conn->query($sql);
										while ($row=$result->fetch_assoc()) {
											?>
											<tr>
												<td>
													<?php echo $row['number']; ?>
												</td>
												<td><?php echo $row['declaration_time']; ?></td>
											</tr>
											<?php
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
						<?php
					}
					else if($_GET['screen']=='dashboard'){
						?>
						<h5 class="py-2 pt-4">Users</h5>
						<div class="row">
							<div class="col-12 col-md-3 mb-3 stats">
								<div class="bg-light p-3">
									Total Registered
									<h4><?php echo getTotalNoOfUsers($conn); ?></h4>
								</div>
							</div>
							<div class="col-12 col-md-3 mb-3 stats">
								<div class="bg-light p-3">
									Payment Pending
									<h4><?php echo getNoOfUserByStatus($conn,'payment_pending'); ?></h4>
								</div>
							</div>
							<div class="col-12 col-md-3 mb-3 stats">
								<div class="bg-light p-3">
									Payment Recieved
									<h4><?php echo getNoOfUserByStatus($conn,'confirmed\' OR status=\'tickets_generated'); ?></h4>
								</div>
							</div>
							<div class="col-12 col-md-3 mb-3 stats">
								<div class="bg-light p-3">
									Tickets Generated For
									<h4><?php echo getNoOfUserByStatus($conn,'tickets_generated'); ?></h4>
								</div>
							</div>
						</div>

						<h5 class="py-2 pt-4">Tickets</h5>
						<div class="row">
							<div class="col-12 col-md-3 mb-3 stats">
								<div class="bg-light p-3">
									Total Generated
									<h4><?php echo getTotalTickets($conn); ?></h4>
								</div>
							</div>
							<div class="col-12 col-md-3 mb-3 stats">
								<div class="bg-light p-3">
									Claimed
									<h4><?php echo getNoOfTicketsByStatus($conn,'claimed'); ?></h4>
								</div>
							</div>
							<div class="col-12 col-md-3 mb-3 stats">
								<div class="bg-light p-3">
									Winners Declared
									<h4><?php echo getNoOfTicketsByStatus($conn,'winner'); ?></h4>
								</div>
							</div>
							<div class="col-12 col-md-3 mb-3 stats">
								<div class="bg-light p-3">
									Rejected
									<h4><?php echo getNoOfTicketsByStatus($conn,'rejected'); ?></h4>
								</div>
							</div>
						</div>

						<h5 class="py-2 pt-4">Payment</h5>
						<div class="row">
							<div class="col-12 col-md-3 mb-3 stats">
								<div class="bg-light p-3">
									Total Income
									<h4><?php echo $ticket_price*getTotalIncome($conn); ?></h4>
								</div>
							</div>
							<div class="col-12 col-md-3 mb-3 stats">
								<div class="bg-light p-3">
									Payment Done
									<h4><?php echo $ticket_price*getPaidCount($conn); ?></h4>
								</div>
							</div>
							<div class="col-12 col-md-3 mb-3 stats">
								<div class="bg-light p-3">
									Pending Payment
									<h4><?php echo $ticket_price*getUnpaidCount($conn); ?></h4>
								</div>
							</div>
						</div>

						<h5 class="py-2 pt-4">Winners</h5>
						<div class="row">
							<div class="col-12 col-md-3 mb-3 stats">
								<div class="bg-light p-3">
									Top Line
									<h4><?php echo getWinnersByCategory($conn,'top_line'); ?></h4>
								</div>
							</div>
							<div class="col-12 col-md-3 mb-3 stats">
								<div class="bg-light p-3">
									Middle Line
									<h4><?php echo getWinnersByCategory($conn,'middle_line'); ?></h4>
								</div>
							</div>
							<div class="col-12 col-md-3 mb-3 stats">
								<div class="bg-light p-3">
									Bottom Line
									<h4><?php echo getWinnersByCategory($conn,'bottom_line'); ?></h4>
								</div>
							</div>
							<div class="col-12 col-md-3 mb-3 stats">
								<div class="bg-light p-3">
									First 7
									<h4><?php echo getWinnersByCategory($conn,'first_seven'); ?></h4>
								</div>
							</div>
							<div class="col-12 col-md-3 mb-3 stats">
								<div class="bg-light p-3">
									4 Corners
									<h4><?php echo getWinnersByCategory($conn,'four_corners'); ?></h4>
								</div>
							</div>
							<div class="col-12 col-md-3 mb-3 stats">
								<div class="bg-light p-3">
									Star
									<h4><?php echo getWinnersByCategory($conn,'star'); ?></h4>
								</div>
							</div>
							<div class="col-12 col-md-3 stats">
								<div class="bg-light p-3">
									Full House
									<h4><?php echo getWinnersByCategory($conn,'full_house'); ?></h4>
								</div>
							</div>
						</div>
						<?php
					}
					else if($_GET['screen']=='santa'){ ?>
						<div class="row">
							<div class="col-6">
								<h5 class="py-2 pt-4">Pairs</h5>
								<table class="table table-lg">
									<thead>
										<th>Sender</th>
										<th>Reciever</th>
									</thead>
									<tbody>
										<?php 
										$sql="SELECT * FROM USER WHERE send_to!=''";
										$result=$conn->query($sql);
										while ($row=$result->fetch_assoc()) {
											$reciever=getUserDetails($conn,$row['send_to']);
											echo '<tr><td>'.$row['username'].' - '.$row['fname'].' '.$row['lname'].' ('.$row['vertical'].')</td><td>'.$reciever['username'].' - '.$reciever['fname'].' '.$reciever['lname'].' ('.$reciever['vertical'].')</td></tr>';
										}
										?>
									</tbody>
								</table>
							</div>
							<div class="col-6">
								<h5 class="py-2 pt-4">Left</h5>
								<table class="table table-lg">
									<thead>
										<th>SPEC ID</th>
										<th>Name</th>
										<th>Vertical</th>
									</thead>
									<tbody>
										<?php 
										$sql="SELECT * from user where recieve_from=''";
										$result=$conn->query($sql);
										while ($row=$result->fetch_assoc()) {
											echo '<tr><td>'.$row['username'].'</td><td>'.$row['fname'].' '.$row['lname'].'</td><td>'.$row['vertical'].'</td></tr>';
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
					<?php }
					else{
					}
				}
				?>
			</div>
		</div>
	</div>
	<script src="../js/jquery.min.js"></script>
	<script src="../js/jquery-ui.min.js"></script>
	<script src="../js/popper.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/jquery.dataTables.min.js"></script>
	<script src="../js/dataTables.bootstrap4.min.js"></script>
	<script src = "http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
	<script>
		$(document).ready(function(){
			$('table:not(.ticket-table table)').DataTable({
				"dom":'<"row mt-4"<"col-12 col-md-9"f><"col-12 col-md-3"l>><t><"row"<"col-12 text-center mb-2 mb-md-0 col-md-4"i><"col-12 col-md-4 text-center"p>>',
			});
			$('.declaration_checkbox').change(function(){
				if($('.declaration_checkbox:checked').length>=3){
					$('.declaration_checkbox:not(:checked)').attr('disabled',true);
				}
				else{
					$('.declaration_checkbox:not(:checked)').removeAttr('disabled');
				}
			})
		});
		$('table.reflow').find('th').each(function(index, value){

			var $this = $(this),
			title = '<b class="cell-label">' + $this.html() + '</b>';

		// add titles to cells
		$('table.reflow')
		.find('tr').find('td:eq('+index+')').wrapInner('<span class="cell-content"></span>').prepend( title );
	});
</script>
</body>
</html>
