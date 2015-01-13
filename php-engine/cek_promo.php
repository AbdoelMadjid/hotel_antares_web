<?php
	require('../Connections/antares_conn.php');	
	mysql_select_db($database_antares_conn, $antares_conn);
	$cari = mysql_real_escape_string($_GET['kode_promo']);
		
		$cari_status = "
		SELECT * 
		FROM  `promotion` 
		WHERE  `kode_promo` =  '".$cari."'
		LIMIT 1
		";
		

		$stat = array();
		
		$q = mysql_query($cari_status)or die(mysql_error());
		
		while($data = mysql_fetch_object($q)){
			$stat[] = $data; // Cara Simpel make mysql_fetch_object
		}

		header('Content-type: application/json');
		json_encode($stat,true);
		print_r(json_encode($stat,true));

?>