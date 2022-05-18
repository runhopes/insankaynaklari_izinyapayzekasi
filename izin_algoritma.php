<?php

function resmitatilKontrol($kontroltarih,$gunsayisi,$durum)
{
	/* Veritabanınıza bağlantı ayarlarının bulunduğu baglanti.php dosyasını include etmeniz yeterli.*/
	/* include "baglanti.php"; */
	$gunler_TR = array("Pazartesi","Salı","Çarşamba","Perşembe","Cuma","Cumartesi","Pazar");
	$gunler_EN = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
	$i=0;
	$tkontrol =0;
	$sorgu = $baglanti->prepare("select * from resmitatiller");
	$sorgu->execute();
	foreach($sorgu as $row)
	{
		$rgunsayisi = $row["gunsayisi"];
		for($temp=0;$temp<$rgunsayisi;$temp++)
		{
			$resmitatiller[$i]  =  date("Y-m-d", strtotime(tarihCevir($row["tarihi"]). '+'.$temp.' days'));
			$i++;
		}		
	}
	$rcount = count($resmitatiller);
	for($t=0;$t<$gunsayisi;$t++)
	{
		$kontroltarihk = date("Y-m-d", strtotime($kontroltarih. '+'.$t.' days'));
		for($temp=0;$temp<$rcount;$temp++)
			if($resmitatiller[$temp] == $kontroltarihk)
				$tkontrol++;
	}

	for($t=0;$t<$gunsayisi;$t++)
	{
		$kontroltarihk = date("Y-m-d", strtotime($kontroltarih. '+'.$t.' days'));
		$gunadi = str_replace($gunler_EN,$gunler_TR,date('l', strtotime($kontroltarihk)));
		if($gunadi == "Pazar")
			$tkontrol++;
	}

	if($durum == 0)
	$kontroltarihk = date("Y-m-d", strtotime($kontroltarihk. '+'.$tkontrol.' days'));

	return $kontroltarihk;
}

function isresmitatilKontrol($kontroltarih)
{
	/* Veritabanınıza bağlantı ayarlarının bulunduğu baglanti.php dosyasını include etmeniz yeterli.*/
	/* include "baglanti.php"; */
	$kontroltarih = date("Y-m-d", strtotime($kontroltarih. '+1 days'));	
	$gunler_TR = array("Pazartesi","Salı","Çarşamba","Perşembe","Cuma","Cumartesi","Pazar");
	$gunler_EN = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
	$i=0;
	$tkontrol =0;
	$sorgu = $baglanti->prepare("select * from resmitatiller");
	$sorgu->execute();
	foreach($sorgu as $row)
	{
		$rgunsayisi = $row["gunsayisi"];
		for($temp=0;$temp<$rgunsayisi;$temp++)
		{
			$resmitatiller[$i]  =  date("Y-m-d", strtotime(tarihCevir($row["tarihi"]). '+'.$temp.' days'));
			$i++;
		}		
	}
	$rcount = count($resmitatiller);
	for($temp2=0;$temp2<$rcount;$temp2++)
		for($temp=0;$temp<$rcount;$temp++)
			if($resmitatiller[$temp] == $kontroltarih)
				$kontroltarih = date("Y-m-d", strtotime($kontroltarih. '+1 days'));

	$gunadi = str_replace($gunler_EN,$gunler_TR,date('l', strtotime($kontroltarih)));
	if($gunadi == "Pazar")
			$kontroltarih = date("Y-m-d", strtotime($kontroltarih. '+1 days'));
	
	return $kontroltarih;
}

function tarihCevir($tarih)
{	
	$tarih = $tarih[6].$tarih[7].$tarih[8].$tarih[9]."-".$tarih[3].$tarih[4]."-".$tarih[0].$tarih[1];
	return $tarih;
}



?>