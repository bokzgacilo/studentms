<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>
<!doctype html>
<html>

<head>
	<link rel="icon" href="../images/logo.png" type="image/png">
	<title>STUDENT HANDBOOK ASSISTANCE | Contact Us Page</title>
	<script
		type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	<!--bootstrap-->
	<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
	<!--coustom css-->
	<link href="css/style.css" rel="stylesheet" type="text/css" />
	<!--script-->
	<script src="js/jquery-1.11.0.min.js"></script>
	<!-- js -->
	<script src="js/bootstrap.js"></script>
	<!-- /js -->
	<!--fonts-->
	<link
		href='//fonts.googleapis.com/css?family=Open+Sans:300,300italic,400italic,400,600,600italic,700,700italic,800,800italic'
		rel='stylesheet' type='text/css'>
	<!--/fonts-->
	<script type="text/javascript" src="js/move-top.js"></script>
	<script type="text/javascript" src="js/easing.js"></script>
	<!--script-->
	<script type="text/javascript">
		jQuery(document).ready(function ($) {
			$(".scroll").click(function (event) {
				event.preventDefault();
				$('html,body').animate({ scrollTop: $(this.hash).offset().top }, 900);
			});
		});
	</script>
	<!--/script-->
</head>

<body>
	<!--header-->
	<?php include_once('includes/header.php'); ?>
	<!-- Top Navigation -->
	<!--header-->
	<!-- contact -->
	<div class="testimonials">
		<!-- container -->
		<div class="container" style="color: #fff !important;">
			<h2>Contact</h2>

			<div class="contact-info">
				<h3 class="c-text">Feel Free to contact with us!!!</h3>
			</div>

			<div class="contact-grids">
				<?php
				$sql = "SELECT * from tblpage where PageType='contactus'";
				$query = $dbh->prepare($sql);
				$query->execute();
				$results = $query->fetchAll(PDO::FETCH_OBJ);

				$cnt = 1;
				if ($query->rowCount() > 0) {
					foreach ($results as $row) { ?>
						<div class="col-md-4 contact-grid-left">
							<h3>Address :</h3>
							<p><?php echo htmlentities($row->PageDescription); ?>
							</p>
						</div>
						<div class="col-md-4 contact-grid-middle">
							<h3>Phones :</h3>
							<p><?php echo htmlentities($row->MobileNumber); ?>
							</p>
						</div>
						<div class="col-md-4 contact-grid-right">
							<h3>E-mail :</h3>
							<p><?php echo htmlentities($row->Email); ?>
							</p>
						</div>
						<div class="clearfix"> </div>
						<?php $cnt = $cnt + 1;
					}
				} ?>
			</div>
		</div>
		<!-- //container -->
	</div>
	<!-- //contact -->
	<?php include_once('includes/footer.php'); ?>
	<!--/copy-rights-->
</body>

</html>