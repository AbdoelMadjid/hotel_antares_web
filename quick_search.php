<?php 

require_once('Connections/antares_conn.php'); 

		$check_in = $_GET['check-in'];
		$check_out = $_GET['check-out'];
		$room = $_GET['room-num'];
		$adult_num = $_GET['adult-num'];
		$children_num = $_GET['children-num'];

		$ck_in = $_GET['check-in'];
		$ck_out = $_GET['check-out'];

//	if(!isset($_GET['ck_in']) && ) {
//		$ck_in = $_GET['ck_in'];
//	}


if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_antares_conn, $antares_conn);
$query_quick_reservation = 
"SELECT * FROM kamar 
WHERE status = 'Available'
AND adult_num = ". $adult_num ." 
AND children_num = ".$children_num."
GROUP BY tipe
";

$quick_reservation = mysql_query($query_quick_reservation, $antares_conn) or die(mysql_error());
$row_quick_reservation = mysql_fetch_assoc($quick_reservation);
$totalRows_quick_reservation = mysql_num_rows($quick_reservation);



?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1.0" />
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Utk icon browser -->
	<link rel="shortcut icon" href="favicon.ico">
	<link rel="icon" href="favicon.png">

	<!-- Utk iPad -->
	<link rel="apple-touch-icon" href="img/icon/icon-144.png" sizes="144x144">
	<link rel="apple-touch-icon" href="img/icon/icon-72.png" sizes="72x72">

	<!-- Utk iPhone -->
	<link rel="apple-touch-icon" href="img/icon/icon-57.png" sizes="57x57">
	<link rel="apple-touch-icon" href="img/icon/icon-114.png" sizes="114x114">

	<title>Quick Reservation Result</title>

	<!-- Bootstrap core CSS -->
	<link href="css/bootstrap.css" rel="stylesheet">

	<!-- Just for debugging purposes. Don't actually copy this line! -->
	<!--[if lt IE 9]><script src="js/ie8-responsive-file-warning.js"></script><![endif]-->

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->

	<!-- Custom styles for this template -->
	<link href="css/carousel.css" rel="stylesheet">
	<link href="css/search.css" rel="stylesheet">
</head>
<!-- NAVBAR
================================================== -->

<body>
	<div class="navbar-wrapper">
		<div class="container">

			<div class="navbar navbar-inverse navbar-static-top" role="navigation">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand visible-lg visible-md" href="index.php">
							<img src="img/logo-antares.svg">
							<span id="hotel_name">Grand Antares Medan</span>
						</a>
						<a class="navbar-brand visible-sm" href="index.php" style="width:80px;">
							<img src="img/logo-antares.svg">
						</a>
						<a class="navbar-brand visible-xs" href="index.php">
							<img src="img/logo-antares.svg" style="height:50px;">
							<span id="hotel_name"></span>
						</a>
					</div>

					<div class="navbar-collapse collapse">

						<ul class="nav navbar-nav">

							<li>
								<a href="index.php">Home</a>
							</li>
							<li class="active">
								<a href="search.php">Search</a>
							</li>
							<li>
								<a href="rooms.php">Rooms</a>
							</li>
							<li>
								<a href="gallery.php">Gallery</a>
							</li>
							<li>
								<a href="reservation.php">Reservation</a>
							</li>
							<li>
								<a href="info.php">Information</a>
							</li>

						</ul>

					</div>


				</div>
			</div>

		</div>
	</div>

	<!-- Bagian utk membuat jarak dari navbar ke konten pada Tablet dan Phone -->
	<div class="visible-md visible-lg" style="height:5px">&nbsp;</div>
	<div class="visible-sm" style="height:25px">&nbsp;</div>
	<div class="visible-xs" style="height:0px">&nbsp;</div>
	<div class="container" style="margin-top:100px;">

		<!-- Kontainer Utama pencarian -->
		<div class="row">			

			<div class="col-lg-12">				

				<div class="container">				
					
					<div class="row" id="result">
						<div class="col-lg-12" style="padding:0px; margin:0px;">
							<h2 align="left" ><span class="text-muted">Search result</span> for Quick Reservation</h2>
						</div>
						
						<div id="hasil_query" class="col-lg-12" style="padding:0px; margin-top:30px;">
							
							<?php 
								while($hasil_query = mysql_fetch_array($quick_reservation)) {
									
									$no_kamar = $hasil_query['no_kamar'];
									$deskripsi_kamar = $hasil_query['deskripsi'];									
									$harga_kamar = $hasil_query['harga'];
									$tipe_kamar = $hasil_query['tipe'];
									
									$foto_kamar = "";
									//Menentukan gambar utk setiap tipe kamar
									if($tipe_kamar == "Superior") {								
										$foto_kamar = "img/room-img/superior.jpg";									
									} else if($tipe_kamar == "Deluxe") {
										$foto_kamar = "img/room-img/deluxe.jpg";
									} else if($tipe_kamar == "Bussiness") {
										$foto_kamar = "img/room-img/business.jpg";
									} else if($tipe_kamar == "Executive") {
										$foto_kamar = "img/room-img/executive.jpg";
									} else if($tipe_kamar == "Suite") {
										$foto_kamar = "img/room-img/suite.jpg";
									}
									
									$data_link = 'reservation.php?no_kamar='.$no_kamar.'&ck_in='.$ck_in.'&ck_out='.$ck_out;
									
							?>
							<div class="col-sm-4">
								
								<div class="media">
									<a class="pull-left" href="#">
										<img class="media-object" alt="64x64" src="<?php echo $foto_kamar; ?>" style="width: 64px; height: 64px;">
									</a>
									<div class="media-body">
										<h4 class="media-heading"><?php echo $tipe_kamar; ?></h4>
										<?php echo $deskripsi_kamar; ?>
										<br>
										<p style="margin-top:10px;">
											<a href="<?php echo $data_link; ?>" class="btn btn-success">Book Now</a>
										</p>
									</div>
									
								</div>
								
							</div>
								<?php 
									}
								?>
							
							
						</div>
						
						
					</div>

				</div>
			</div>



		</div>

		<!-- /.row -->

		<!-- FOOTER -->
		<footer>
			<p class="pull-right">
				<a href="#">Back to top</a>
			</p>
			<p>
				&copy; 2013 Hotel Grand ANTARES
				<br>Jalan Sisingamangaraja
				<br>No. 328 Medan 20152
				<br>North Sumatera, Indonesia
				<br>Telp : (62-61) 788 3555
				<br>
			</p>
		</footer>

	</div>
	<!-- /.container -->

	<!-- Bootstrap core JavaScript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script>
		$(document).ready(function(e) {

			

		});
	</script>
</body>

</html>
<?php
mysql_free_result($quick_reservation);
?>
