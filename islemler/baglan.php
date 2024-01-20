<?php 
ob_start();
session_start();



$host="localhost"; 
$veritabani_ismi="final"; 
$kullanici_adi="root"; 
$sifre=""; 
try {
	$db=new PDO("mysql:host=$host;dbname=$veritabani_ismi;charset=utf8",$kullanici_adi,$sifre);
}

catch (PDOExpception $e) {
	echo 'Hata: '.$e->getMessage();
}

date_default_timezone_set('Europe/Istanbul');

?>
