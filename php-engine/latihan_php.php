<?php
	require('../Connections/antares_conn.php');	
	mysql_select_db($database_antares_conn, $antares_conn);
		


	$cari_status = "Select no_kamar from kamar where tipe = 'Suite' LIMIT 5";
		

		$stat = array();
		
		$q = mysql_query($cari_status)or die(mysql_error());
		
		while($data = mysql_fetch_array($q)){
			echo $data['no_kamar'] . '<br>';
			array_push($stat, $data['no_kamar']);
		}

		$jlh_data =  count($stat);

		foreach($stat as $x=>$x_val) {
			echo $x . " : " . $x_val . "<br>";
		}

		print_r($stat);

		$babi = -1;
		$babu = 7;

		if($babi > 0){
			echo 'Babi : ' . $babi;
			
		} 

		if($babu > 0) {
			echo 'Babu : ' . $babu;
		}

	

?>