<?php
session_start();
if(!isset($_SESSION['username'])){
	header('Location:../index.php');
}
if ($_SESSION['role']!='USR') {
	header('Location:../');
}
include_once('../config.php');
include_once('../connect.php');
include_once('functions.php');
if (isset($_POST['buy_tickets'])) {
	if($_POST['tickets']<=$ticket_purchase_limit&&$_POST['tickets']>0)
	{
		$result=buyTickets($conn,$_SESSION['username'],$_POST['tickets']);
		if($result){
			updateUserStatus($conn,$_SESSION['username'],'payment_pending');
		}
	}
	header('Refresh:0');
	exit;
}
if(isset($_POST['updateTicketBtn'])){
	$ticket_id=encrypt_decrypt('encrypt','ticket_id');
	$ticket_id_val=encrypt_decrypt('decrypt',$_POST[$ticket_id]);
	$ticket=getTicketByID($conn,$_SESSION['username'],$ticket_id_val);
	if($ticket['status']!='claimed'&&$ticket['status']!='winner'&&$ticket['status']!='rejected'){
		$ticket_array=json_decode(base64_decode($ticket['ticket_obj']));
		for ($i=0; $i <3 ; $i++) { 
			for ($j=0; $j <9 ; $j++) { 
				$id=encrypt_decrypt('encrypt',$ticket_array[$i][$j]->id);
				if(isset($_POST[$id])){
					if($_POST[$id]=='on'){
						$ticket_array[$i][$j]->meta_checked=true;
					}
				}
				else if($ticket_array[$i][$j]->meta_checked==true&&!isset($_POST[$id])){
					$ticket_array[$i][$j]->meta_checked=false;
				}
			}
		}
		if(updateTicketByID($conn,$_SESSION['username'],$ticket_id_val,$ticket_array)){
			$_SESSION['message']="Ticket Updated Sucessfully";
		}
		else{
			$_SESSION['message']="Something Went Wrong. Please try again after some time.";
		}
	}
	else{
		$_SESSION['message']="Ticket Can Not Be Updated At This Stage";
	}
	$printed=false;
	header('Refresh:0');
	exit;
}
if(isset($_POST['claim_prize'])){
	$ticket_id=encrypt_decrypt('encrypt','ticket_id');
	$ticket_id_val=encrypt_decrypt('decrypt',$_POST[$ticket_id]);
	$claim_category=encrypt_decrypt('decrypt',$_POST[encrypt_decrypt('encrypt','claim_category')]);
	$ticket_status=getTicketByID($conn,$_SESSION['username'],$ticket_id_val);
	if($ticket_status['status']!='claimed'&&$ticket_status['status']!='winner'&&$ticket_status['status']!='rejected'){
		if(claimPrize($conn,$_SESSION['username'],$ticket_id_val,$claim_category)){
			$_SESSION['message']="Prize Claim has been done";
		}
		else{
			$_SESSION['message']="Something Went Wrong. Please try again after some time.";
		}
	}
	else{
		$_SESSION['message']='Ticket Already Claimed';
	}
	$printed=false;
	header('Refresh:0');
	exit;
}
$status=getUserStatus($conn,$_SESSION['username']);
if($status=="confirmed"){
	$n=getNoOfTicketsByUser($conn,$_SESSION['username']);
	for ($i=0; $i <$n ; $i++) {
		$tambola=generateTambolaTicket();
		insertTambolaTicket($conn,$tambola,$_SESSION['username']);
	}
	updateUserStatus($conn,$_SESSION['username'],'tickets_generated');
	ticketsMail($conn,$_SESSION['email'],$_SESSION['fname'].' '.$_SESSION['lname'],$_SESSION['username']);
	header('Refresh:0');
	exit;
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Tambola</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/font-awesome-all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
	<link rel="stylesheet" href="../css/jquery-ui.css" />
	<link rel="stylesheet" href="../css/swiper.min.css" />
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link rel="stylesheet" href="../css/style.css" />	
</head>
<?php
if($status=="new"){
	?>
	<body class="home new">
		<div class="logout text-right">
			Hi, <?php echo $_SESSION['fname'].' '.$_SESSION['lname']; ?><a href="../logout.php" class="px-3">Logout</a>
		</div>
		<div class="container-fluid h-100">
			<div class="row align-items-center h-100">
				<div class="col-4 offset-4">
					<form method="POST" class="d-flex flex-column justify-content-center align-items-center">
						<h2 class="text-center">Select The Number of Tickets You Want</h2>
						<div>
							<div class="d-flex align-items-center">
								<button class="btn btn-primary fab" id="minus" disabled="disabled">-</button>
								<input type="hidden" name="tickets" id="tickets" value="1">
								<h1 class="tickets d-inline p-5" id="tickets_val">1</h1>
								<button class="btn btn-primary fab" id="plus">+</button>
							</div>
						</div>
						<div class="">
							<button type="submit" name="buy_tickets" class="btn btn-primary">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<?php
	}
	else if($status=="payment_pending"){
		?>
		<body class="home new">
			<div class="logout text-right">
				Hi, <?php echo $_SESSION['fname'].' '.$_SESSION['lname']; ?><a href="../logout.php" class="px-3">Logout</a>
			</div>
			<div class="container-fluid h-100">
				<div class="row align-items-center h-100">
					<div class="col-4 offset-4">
						<div class="text-center">
							<?php $n=getNoOfTicketsByUser($conn,$_SESSION['username']); ?>
							<h3>Your Payment is Pending</h3>
							<h5>Tickets : <?php echo $n; ?></h5>
							<h5>Payment : Rs. <?php echo $n*$ticket_rate; ?></h5>
							<h3 class="pt-5"><small>Please Pay The Fees to</small><br><strong><?php echo $payment_collecter?></strong><br><small>to Continue</small></h3>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
		else if($status=="blocked"){?>
			<body class="home new">
				<div class="logout text-right">
					Hi, <?php echo $_SESSION['fname'].' '.$_SESSION['lname']; ?><a href="../logout.php" class="px-3">Logout</a>
				</div>
				<div class="container-fluid">
					<div class="row">
						<div class="col-4 offset-4">
							<div id="svgContainer"></div>
							<div class="text-center">
								<h3>Your Account has been blocked</h3>
								<h3 class="pt-5"><small>Please Contact</small><br><strong>Niraj Gohel (DZN)</strong><br><small>to Continue</small></h3>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
			else if($status=="tickets_generated"){
				$userTickets=getUserTickets($conn,$_SESSION['username']);
				?>
				<body class="home tickets_generated">
					<div class="logout text-right">
						Hi, <?php echo $_SESSION['fname'].' '.$_SESSION['lname']; ?><a href="../logout.php" class="px-3">Logout</a>
					</div>
					<div class="header pt-5 mt-3 mt-lg-0 pt-lg-4 text-center font-weight-bold">
						<div class="d-flex align-items-center justify-content-center">
							<?php
							$sql=$conn->prepare("SELECT * FROM numbers where status='declared' order by declaration_time desc limit ?");
							$sql->bind_param('i',$max_declared_numbers_to_display);
							$sql->execute();
							if($result=$sql->get_result()){
								while ($row=$result->fetch_assoc()) {
									?>
									<span class="number px-3 active"><?php echo $row['number']; ?><small><?php echo $row['tag_line']; ?></small></span>		
									<?php
								}
							}
							?>
						</div>
						<?php 
						if (isset($_SESSION['message'])) {
							echo '<div class="py-2">'.$_SESSION['message'].'</div>';
							$printed=true;
							if($printed){
								$_SESSION['message']='';
							}
						}
						?>
					</div>
					<div class="swiper-container gallery-top">
						<div class="swiper-wrapper pt-5">
							<?php
							
							foreach ($userTickets as $singleTicket) {
								$ticket_id=encrypt_decrypt('encrypt','ticket_id');
								$ticket_id_val=encrypt_decrypt('encrypt',$singleTicket['id']);
								?>
								<div class="swiper-slide">
									<?php if($singleTicket['status']=='new'){ ?>
										<form action="" method="POST" class="px-3">
											<?php
											$GLOBALS['temper']=false;
											echo printTambolaTicketObjWithChekboxes(json_decode(base64_decode($singleTicket['ticket_obj'])));
											?>
											<?php if ($GLOBALS['temper']==false){ ?>
												<input name="<?php echo $ticket_id ?>" type="hidden" value="<?php echo $ticket_id_val; ?>">
												<div class="mt-4 d-flex justify-content-center flex-wrap">
													<button class="btn btn-primary m-2" name="updateTicketBtn">Save</button>
													<button class="btn btn-primary m-2 claim_prize" type="button" data-toggle="modal" data-target="#<?php echo $ticket_id_val ?>">Claim the Prize !</button>
												</div>
											<?php } ?>
										</form>
									<?php }
									else if($singleTicket['status']=='winner'||$singleTicket['status']=='rejected'||$singleTicket['status']=='claimed'){ ?>
										<div class="<?php echo $singleTicket['status']; ?>"> 
											<?php echo printTambolaTicketObj(json_decode(base64_decode($singleTicket['ticket_obj']))); ?>
										</div>
										<div class="py-2">
											<?php echo 'Category : '.printStatus($singleTicket['claim']); ?>
										</div>
									<?php } 
									?>
								</div>
							<?php } ?>
						</div>
					</div>
					<!-- <div class="row">
						<div class="col-10 offset-1 min-150"> -->
							<div class="container-fluid">
								<div class="swiper-container gallery-thumbs">
									<div class="swiper-wrapper">
										<?php  
										foreach ($userTickets as $singleTicket) {
											?><div class="swiper-slide"><?php
											if($singleTicket['status']=='new'){?>
												<div class="new">
												<?php echo printTambolaTicketObj(json_decode(base64_decode($singleTicket['ticket_obj']))); ?>
												</div>
											<?php }
											else if($singleTicket['status']=='claimed'){ ?>
												<div class="claimed"> 
													<?php echo printTambolaTicketObj(json_decode(base64_decode($singleTicket['ticket_obj']))); ?>
												</div>	
											<?php }
											else if($singleTicket['status']=='winner'){ ?>
												<div class="winner">
													<?php echo printTambolaTicketObj(json_decode(base64_decode($singleTicket['ticket_obj']))); ?>
												</div>
											<?php }
											else if($singleTicket['status']=='rejected'){ ?>
												<div class="rejected">
													<?php echo printTambolaTicketObj(json_decode(base64_decode($singleTicket['ticket_obj']))); ?>
												</div>
											<?php }
											?></div><?php
										}
										?>
									</div>
								</div>
							</div>
						<!-- </div>
						</div> -->
						<?php
						foreach ($userTickets as $singleTicket) {
							$ticket_id=encrypt_decrypt('encrypt','ticket_id');
							$ticket_id_val=encrypt_decrypt('encrypt',$singleTicket['id']);
							?>
							<div id="<?php echo $ticket_id_val ?>" class="modal fade" role="dialog">
								<div class="modal-dialog">

									<!-- Modal content-->
									<div class="modal-content text-dark">
										<form action="" method="POST">
											<input name="<?php echo $ticket_id ?>" type="hidden" value="<?php echo $ticket_id_val; ?>">
											<div class="modal-header">
												<h4 class="modal-title">Claim The Prize !</h4>
												<button type="button" class="close" data-dismiss="modal">&times;</button>
											</div>
											<div class="modal-body">
												<p>Once you claim the prize, The Ticket will be freezed and no longer be available for modification so please make sure everything is correct.</p>
												<select name="<?php echo encrypt_decrypt('encrypt','claim_category'); ?>" class="form-control">
													<option selected disabled>Select Category</option>
													<?php 

													if ($allow_top_line) {
														if(getWinnersByCategory($conn,'top_line')<$max_top_line_winners){
															?>
															<option value="<?php echo encrypt_decrypt('encrypt','top_line'); ?>">
																Top Line
															</option>
															<?php 
														}
													}  ?>

													<?php 

													if ($allow_middle_line) {
														if(getWinnersByCategory($conn,'middle_line')<$max_middle_line_winners){ ?>
															<option value="<?php echo encrypt_decrypt('encrypt','middle_line'); ?>">
																Middle Line
															</option>
															<?php 
														} 
													}
													?>


													<?php  
													if ($allow_bottom_line) {
														if(getWinnersByCategory($conn,'bottom_line')<$max_bottom_line_winners){?>
															<option value="<?php echo encrypt_decrypt('encrypt','bottom_line'); ?>">
																Bottom Line
															</option>
															<?php 
														}
													} 
													?>

													<?php
													if ($allow_four_corners) {  
														if(getWinnersByCategory($conn,'four_corners')<$max_four_corners_winners){?>
															<option value="<?php echo encrypt_decrypt('encrypt','four_corners'); ?>">
																4 Corners
															</option>
															<?php 
														}
													} 
													?>

													<?php
													if ($allow_star) {  
														if(getWinnersByCategory($conn,'star')<$max_star_winners){?>
															<option value="<?php echo encrypt_decrypt('encrypt','star'); ?>">
																Star
															</option>
															<?php 
														}
													} 
													?>

													<?php
													if ($allow_full_house) {
														if(getWinnersByCategory($conn,'full_house')<$max_full_house_winners){?>
															<option value="<?php echo encrypt_decrypt('encrypt','full_house'); ?>">
																Full House
															</option>
														<?php }
													} ?>
												</select>
											</div>
											<div class="modal-footer">
												<button type="submit" class="btn btn-primary" name="claim_prize">Submit</button>
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											</form>
										</div>
									</div>

								</div>
							</div>
							<?php
						}
					}
					?>
					<script src="../js/jquery.min.js"></script>
					<script src="../js/jquery-ui.min.js"></script>
					<script src="../js/popper.min.js"></script>
					<script src="../js/bootstrap.min.js"></script>
					<script src="../js/swiper.min.js"></script>
					<script src="../js/lottie.min.js"></script>
					<script src="../js/custom.js"></script>
					<script>
						$tickets=1;
						$("#plus").click(function(e){
							e.preventDefault();
							$tickets++;
							if($tickets>=2){
								$("#minus").removeAttr("disabled");
							}
							if($tickets==<?php echo $ticket_purchase_limit;?>){
								$("#plus").attr("disabled","disabled");
							}
							$("#tickets").val($tickets);
							$("#tickets_val").html($tickets);
						});
						$("#minus").click(function(e){
							e.preventDefault();
							$tickets--;
							if($tickets>=1){
								$("#plus").removeAttr("disabled");
							}
							if($tickets==1){
								$("#minus").attr("disabled","disabled");
							}
							$("#tickets").val($tickets);
							$("#tickets_val").html($tickets);
						});
						var galleryThumbs = new Swiper('.gallery-thumbs', {
							slidesPerView: 5,
							freeMode:false,
							centeredSlides: true,
							spaceBetween: 30,
							// breakpoints:{
							// 	768:{
							// 		slidesPerView:5,	
							// 	}
							// },
						});
						var galleryTop = new Swiper('.gallery-top', {
							touchRatio: 0,
							speed:600,
							thumbs: {
								swiper: galleryThumbs
							},

						});
						galleryTop.on('slideChange',function(){
							localStorage.setItem('currentSlide',this.activeIndex);
						});
						if(localStorage.getItem('currentSlide')!=''){
							galleryTop.slideTo(localStorage.getItem('currentSlide'),0,false);
						}
					</script>
				</body>
				</html>