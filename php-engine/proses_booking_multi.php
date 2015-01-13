<?php
//Proses bookingmulti kamar utk, cek_tersedia.php

	require('../Connections/antares_conn.php');
	
	//Randomize ID Booking
	$rand_1 = rand(00,99);
	$tgl_tahun = gmdate("mYd", time()+60*60*7); //mmyydd
	$id_booking = $tgl_tahun.$rand_1;
	
	//Variable yang digunakan utk mengelola data kamar
	$id_cust = $_GET['id_cust'];
	//$no_kamar = $_GET['no_kamar']; // No Kamar tidak ada get dari cek tersedia
	$arrival = $_GET['arrival'];
	$checkout = $_GET['checkout'];
	$tipe_booking = $_GET['tipe_booking'];
	
	$nama = $_GET['nama'];
	$tgl_lahir = $_GET['tgl_lahir'];
	$telepon = $_GET['telepon'];
	$email = $_GET['email'];
	$negara = $_GET['negara'];
	$kota = $_GET['kota'];
	$alamat = $_GET['alamat'];
	
	$kk_num = $_GET['card_number'];
	$nama_pemilik = $_GET['name_on_card'];
	$expire_date = $_GET['expire'];
	$security_code = $_GET['security_code'];

	$jlh_bis = $_GET['jlh_bis'];
	$jlh_del = $_GET['jlh_del'];
	$jlh_exe = $_GET['jlh_exe'];
	$jlh_suite = $_GET['jlh_suite'];
	$jlh_sup = $_GET['jlh_sup'];
	
	if(isset($_GET['harga_diskon'])) {
		$harga_diskon = $_GET['harga_diskon'];
		$tipe_booking = "Discount";
	} else {
		$harga_diskon = 0;
	}
	
	
	$harga_multi_hari = $_GET['harga_multi_hari'];
	$total_hari = $_GET['total_hari'];
	$total_harga = $_GET['total_harga'];
	
	$executive = $_GET['executive'];
	$bussiness = $_GET['bussiness'];
	$deluxe = $_GET['deluxe'];
	$superior = $_GET['superior'];
	$suite = $_GET['suite'];

	$status = false;

	if($arrival == "" || $checkout == "" || $tipe_booking == "" || 
	   $nama == "" || $tgl_lahir == "" || $telepon == "" || $email == "" || $negara == "" || $kota == "" ||
	   $alamat == "" || $kk_num == "" || $nama_pemilik == "" || $expire_date == "" || $security_code == ""
	  ) {
		
		$respon = array ("response_word" => 'Gagal', "date" => $tgl_tahun);
		
	} else { // JIka tidak ada input form yang kosong	
		
	
		//Memilih Database
		mysql_select_db($database_antares_conn, $antares_conn);
		
		$query_insert_customer = mysql_query("
		INSERT INTO customer(`id_cust`, `id_num`, `nama`, `tgl_lahir`, `alamat`, `telepon`, `email`,  `kota`, `negara`, `kk_num`) 
		VALUES ('".$id_cust."', NULL, '".$nama."', '".$tgl_lahir."', '".$alamat."', '".$telepon."', '". $email."',  '".$kota."', '".$negara."', '".$kk_num."');
		")or die('Customer Insertion : '.mysql_error().mysql_errno());
		
		
		$query_insert_kartu_kredit = mysql_query("
		INSERT INTO kartu_kredit (`id_table`, `kk_num`, `id_cust`, `expire_date`, `nama_pemilik`, `security_code`) 
		VALUES (NULL, '".$kk_num."', '".$id_cust."', '".$expire_date."', '".$nama_pemilik."', '".$security_code."')
		")or die('Credit Card Insertion : '.mysql_error().mysql_errno());
		
		//Jika terdeteksi jumlah kamar bisnis > 0
		if($jlh_bis > 0 ) {			
			$no_kamar_bis = array();
			
			$query_no_kamar = mysql_query("Select no_kamar FROM kamar WHERE tipe = 'Bussiness' LIMIT " . $jlh_bis)or die(mysql_error());
			
			while($data = mysql_fetch_array($query_no_kamar)){
				array_push($no_kamar_bis, $data['no_kamar']);
			}
			
			foreach($no_kamar_bis as $i=>$val) {				
				
				$query_insert_booking = mysql_query("
				INSERT INTO booking(`table_id`, `id_booking`, `id_cust`, `no_kamar`, `tipe_booking`, `arrival`, `checkout`, `id_staff`, `booking_time`, `confirmation`, `checkin_time`, `charge_fee`, `harga_multi_hari`, `harga_diskon`, `total_hari`) 
				VALUES (NULL, '".$id_booking."', '".$id_cust."', '".$val."', '".$tipe_booking."', '".$arrival."', '".$checkout."', 0, CURRENT_TIMESTAMP, 0, 0,  0, ".$harga_multi_hari.", ".$harga_diskon.", ".$total_hari.")
				")or die('Booking Insertion : '.mysql_error().mysql_errno());
				
				$query_ubah_status = mysql_query("
					UPDATE kamar SET status = 'Booked' WHERE no_kamar = ".$val."
				") or die('Ubah status booking Bisnis : '.mysql_error().mysql_errno());
				
			} //End foreach			
			
			
		 //End of Bussiness : end of jlh_bis	
		} 
		
		//JIka jlh_del
		if ($jlh_del > 0 ) {			
			$no_kamar_del = array();
			
			$query_no_kamar = mysql_query("Select no_kamar FROM kamar WHERE tipe = 'Deluxe' LIMIT " . $jlh_del)or die(mysql_error());
			
			while($data = mysql_fetch_array($query_no_kamar)){
				array_push($no_kamar_del,  $data['no_kamar']);
			}
			
			foreach($no_kamar_del as $i=>$val) {
				
				$query_insert_booking = mysql_query("
				INSERT INTO booking(`table_id`, `id_booking`, `id_cust`, `no_kamar`, `tipe_booking`, `arrival`, `checkout`, `id_staff`, `booking_time`, `confirmation`, `checkin_time`, `charge_fee`, `harga_multi_hari`, `harga_diskon`, `total_hari`) 
				VALUES (NULL, '".$id_booking."', '".$id_cust."', '".$val."', '".$tipe_booking."', '".$arrival."', '".$checkout."', 0, CURRENT_TIMESTAMP, 0, 0,  0, ".$harga_multi_hari.", ".$harga_diskon.", ".$total_hari.")
				")or die('Booking Deluxe Insertion : '.mysql_error().mysql_errno());
				
				$query_ubah_status = mysql_query("
					UPDATE kamar SET status = 'Booked' WHERE no_kamar = ".$val."
				") or die('Ubah status booking Deluxe : '.mysql_error().mysql_errno());
				
			} //End foreach
			
			
		 //End of Deluxe	
		}
		
		//if Executive
		if ($jlh_exe > 0 ) {			
			$no_kamar_exe = array();
			
			$query_no_kamar = mysql_query("Select no_kamar FROM kamar WHERE tipe = 'Executive' LIMIT " . $jlh_exe)or die(mysql_error());
			
			while($data = mysql_fetch_array($query_no_kamar)){
				array_push($no_kamar_exe,  $data['no_kamar']);
			}
			
			foreach($no_kamar_exe as $i=>$val) {
				
				$query_insert_booking = mysql_query("
				INSERT INTO booking(`table_id`, `id_booking`, `id_cust`, `no_kamar`, `tipe_booking`, `arrival`, `checkout`, `id_staff`, `booking_time`, `confirmation`, `checkin_time`, `charge_fee`, `harga_multi_hari`, `harga_diskon`, `total_hari`) 
				VALUES (NULL, '".$id_booking."', '".$id_cust."', '".$val."', '".$tipe_booking."', '".$arrival."', '".$checkout."', 0, CURRENT_TIMESTAMP, 0, 0,  0, ".$harga_multi_hari.", ".$harga_diskon.", ".$total_hari.")
				")or die('Booking Suite Insertion : '.mysql_error().mysql_errno());
				
				$query_ubah_status = mysql_query("
					UPDATE `grand-antares`.`kamar` SET `status` = 'Booked' WHERE `kamar`.`no_kamar` = ".$val."
				") or die('Ubah status booking Suite : '.mysql_error().mysql_errno());
				
			} //End foreach
			
			
		 //End of Executive	
		}
		
		
		//if Suite
		if ($jlh_suite > 0 ) {			
			$no_kamar_suite = array();
			
			$query_no_kamar = mysql_query("Select no_kamar FROM kamar WHERE tipe = 'Suite' LIMIT " . $jlh_suite  )or die(mysql_error());
			
			while($data = mysql_fetch_array($query_no_kamar)){
				array_push($no_kamar_suite ,  $data['no_kamar']);
			}
			
			foreach($no_kamar_suite as $i=>$val) {
				
				$query_insert_booking = mysql_query("
				INSERT INTO booking(`table_id`, `id_booking`, `id_cust`, `no_kamar`, `tipe_booking`, `arrival`, `checkout`, `id_staff`, `booking_time`, `confirmation`, `checkin_time`, `charge_fee`, `harga_multi_hari`, `harga_diskon`, `total_hari`) 
				VALUES (NULL, '".$id_booking."', '".$id_cust."', '".$val."', '".$tipe_booking."', '".$arrival."', '".$checkout."', 0, CURRENT_TIMESTAMP, 0, 0,  0, ".$harga_multi_hari.", ".$harga_diskon.", ".$total_hari.")
				")or die('Booking Executive Insertion : '.mysql_error().mysql_errno());
				
				$query_ubah_status = mysql_query("
					UPDATE `grand-antares`.`kamar` SET `status` = 'Booked' WHERE `kamar`.`no_kamar` = ".$val."
				") or die('Ubah status booking Executive : '.mysql_error().mysql_errno());
				
			} //End foreach
			
			
		 //End of Suite	
		}
		
		
		//if Superior
		if ($jlh_sup > 0 ) {			
			$no_kamar_sup = array();
			
			$query_no_kamar = mysql_query("Select no_kamar FROM kamar WHERE tipe = 'Superior' LIMIT " . $jlh_sup  )or die(mysql_error());
			
			while($data = mysql_fetch_array($query_no_kamar)){
				array_push($no_kamar_sup ,  $data['no_kamar']);
			}
			
			foreach($no_kamar_sup as $i=>$val) {
				
				$query_insert_booking = mysql_query("
				INSERT INTO booking(`table_id`, `id_booking`, `id_cust`, `no_kamar`, `tipe_booking`, `arrival`, `checkout`, `id_staff`, `booking_time`, `confirmation`, `checkin_time`, `charge_fee`, `harga_multi_hari`, `harga_diskon`, `total_hari`) 
				VALUES (NULL, '".$id_booking."', '".$id_cust."', '".$val."', '".$tipe_booking."', '".$arrival."', '".$checkout."', 0, CURRENT_TIMESTAMP, 0, 0,  0, ".$harga_multi_hari.", ".$harga_diskon.", ".$total_hari.")
				")or die('Booking Superior Insertion : '.mysql_error().mysql_errno());
				
				$query_ubah_status = mysql_query("
					UPDATE `grand-antares`.`kamar` SET `status` = 'Booked' WHERE `kamar`.`no_kamar` = ".$val."
				") or die('Ubah status Superior Executive : '.mysql_error().mysql_errno());
				
			} //End foreach
			
			
		 //End of Superior	
		}
		
		
		
	
		$respon = array ("response_word" => 'Success', "date" => $tgl_tahun);
	}

	
	header('Content-type: application/json');
	json_encode($respon, true);
	
	print_r(json_encode($respon,true));
?>