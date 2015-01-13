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

	<title>Advandce Searching</title>

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
	<div class="visible-sm" style="height:25px">&nbsp;</div>
	<div class="visible-xs" style="height:0px">&nbsp;</div>
	<div class="container marketing" style="margin-top:125px;">

		<!-- Kontainer Utama pencarian -->
		<div class="row">
			<div class="col-lg-12" id="search_container">

				<!-- Kontainer utk bar pencari -->
				<div class="col-lg-6 col-sm-6">
					<label for="mainSearchInput">Type to Search :</label>
					<br>
					<div class="input-group">
						<input class="form-control" id="mainSearchInput" type="search" placeholder="Type to Begin Searching" autofocus autocomplete="on">

						<span class="input-group-btn">
							<button class="btn btn-default" type="button" id="cariBtn">
								<span class="glyphicon glyphicon-search"></span>
							</button>
						</span>
					</div>

				</div>

				<div class="col-xs-3 hidden-xs">
					<label for="search-check-in">Check In :</label>
					<br>
					<input class="form-control" id="search-check-in" type="date" placeholder="mm/dd/yyyy">
				</div>
				<div class="col-xs-3 hidden-xs">
					<label for="search-check-out">Check Out :</label>
					<br>
					<input class="form-control" id="search-check-out" type="date" placeholder="mm/dd/yyyy">
				</div>

			</div>

			<div class="col-lg-12">
				<hr class="feturette-devider">

				<div class="container">
					<h2 class="featurette-heading" style="text-align:center;">Just type something
						<span class="text-muted">
							<br>
							<small>to find what You want</small>
						</span>
					</h2>
					
					<div class="row" id="result">
						<p align="center"><!-- Hasil Pencarian --></p>
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

			var data_cari = {};

			var mainSearch = $('#mainSearchInput'),
				checkInSearch = $('#search-check-in'),
				checkOutSearch = $('#search-check-out'),
				cariBtn = $('button#cariBtn');


			mainSearch.on('change keypress keyup', function(e) {
				data_cari.keyword = mainSearch.val();
			});
			checkInSearch.on('change', function(e) {
				data_cari.check_in = checkInSearch.val();
			});
			checkOutSearch.on('change', function(e) {
				data_cari.check_out = checkOutSearch.val();
			});
			cariBtn.click(function(e){
				$('h2.featurette-heading').slideUp(100);
				$('div#result p').html('Sedang Mencari \" ' + data_cari[0] + ' \" ...');
				console.log('Data Cari : ' + JSON.stringify(data_cari));
				console.log( data_cari.check_out.substring(0,4));
				
				if(mainSearch.val() != "") {
					console.log(mainSearch.val());	
				} else {
					$('div#result p').html('Tidak Ada Input');	
				}
				
			});
			

		});
	</script>
</body>

</html>
