<?php
	require('../Connections/antares_conn.php');
	
	//Randomize ID Booking
	$rand_1 = rand(00,99);
	$tgl_tahun = gmdate("mYd", time()+60*60*7); //mmyydd
	$id_booking = $tgl_tahun.$rand_1;
	
	//Variable yang digunakan utk mengelola data kamar

	$id_cust = $_GET['id_cust'];
	$no_kamar = $_GET['no_kamar']; // No Kamar tidak ada get dari cek tersedia
	$arrival = $_GET['arrival'];
	$checkout = $_GET['checkout'];
	$tipe_booking = $_GET['tipe_booking'];
	
	$nama = $_GET['nama'];
	$tgl_lahir = $_GET['tgl_lahir'];
	$telepon = $_GET['telepon'];
	$negara = $_GET['negara'];
	$kota = $_GET['kota'];
	$alamat = $_GET['alamat'];
	
	$kk_num = $_GET['card_number'];
	$nama_pemilik = $_GET['name_on_card'];
	$expire_date = $_GET['expire'];
	$security_code = $_GET['security_code'];

	if($arrival == "" || $checkout == "" || $tipe_booking == "" || 
	   $nama == "" || $tgl_lahir == "" || $telepon == "" || $negara == "" || $kota == "" ||
	   $alamat == "" || $kk_num == "" || $nama_pemilik == "" || $expire_date == "" || $security_code == ""
	  ) {
		
		$respon = array ("response_word" => 'Gagal', "date" => $tgl_tahun);
		
	} else { // JIka tidak ada input form yang kosong		
	
		//Memilih Database
		mysql_select_db($database_antares_conn, $antares_conn);
		
		$query_insert_customer = "
			INSERT INTO `grand-antares`.`customer` (`id_cust`, `id_num`, `nama`, `tgl_lahir`, `alamat`, `telepon`, `kota`, `negara`, `kk_num`) 
			VALUES ('".$id_cust."', NULL, '".$nama."', '".$tgl_lahir."', '".$alamat."', '".$telepon."', '".$kota."', '".$negara."', '".$kk_num."');
		";
		
		
		$query_insert_booking = "
			INSERT INTO `grand-antares`.`booking` (`table_id`, `id_booking`, `id_cust`, `no_kamar`, `tipe_booking`, `arrival`, `checkout`, `id_staff`) 
			VALUES (NULL, '".$id_booking."', '".$id_cust."', '".$no_kamar."', '".$tipe_booking."', '".$arrival."', '".$checkout."', '0')
		";
		
		$query_insert_kartu_kredit = "
			INSERT INTO `grand-antares`.`kartu_kredit` (`id_table`, `kk_num`, `id_cust`, `expire_date`, `nama_pemilik`, `security_code`) 
			VALUES (NULL, '".$kk_num."', '".$id_cust."', '".$expire_date."', '".$nama_pemilik."', '".$security_code."')
		";
		
		
		$insert_c = mysql_query($query_insert_customer) or die(mysql_error().mysql_errno());
		$insert_b = mysql_query($query_insert_booking) or die(mysql_error().mysql_errno());
		$insert_k = mysql_query($query_insert_kartu_kredit) or die(mysql_error().mysql_errno());
		
		if($insert_c && $insert_b && $insert_k ) {
			$respon = array ("response_word" => 'Success', "date" => $tgl_tahun);
		} else {
			$respon = array ("response_word" => 'Gagal', "date" => $tgl_tahun);
		}
		
	}

	
	header('Content-type: application/json');
	json_encode($respon, true);
	
	print_r(json_encode($respon,true));
	//echo ("{ \"people\" :\n " . json_encode($mhs,true) . " \n} ");
?>