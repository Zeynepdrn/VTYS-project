<?php 
require_once 'baglan.php';
error_reporting(E_ALL);




/***********************************************************************/


if (isset($_POST['uyeol'])) {

	$sifre1=$_POST['sifre1'];
	$sifre2=$_POST['sifre2'];

	if ($sifre2==$sifre1) {
		$kulsor=$db->prepare("SELECT * FROM uyeler WHERE ad=:ad ");
		$kulsor->execute(array('ad' => $_POST['ad']));
		$ksayi=$kulsor->rowCount();
		if ($ksayi==0) {
			$sifre=sha1(md5($sifre1));

			$kulekle=$db->prepare("INSERT INTO uyeler SET
				ad=:ad,
				isim=:isim,
				sifre=:sifre,
				tip=:tip
				");

			$ekleme=$kulekle->execute(array(
				'ad' => $_POST['ad'],
				'isim' => $_POST['isim'],
				'sifre' => $sifre,
				'tip' => $_POST['uyetip']

			));

			if ($ekleme) {
				header("location:../giris.php");
				exit;
			} else {
				header("location:../uyeol.php?durum=no");
				exit;
			}
		}else{
			header("location:../uyeol.php?durum=adi");
		}
	}else{
		header("location:../uyeol.php?durum=sifre");
		exit;
	}

	exit;
}


/***********************************************************************/


if (isset($_POST['girisyap'])) {

	$sifre=sha1(md5($_POST['sifre']));

	$kulsor=$db->prepare("SELECT * FROM uyeler WHERE ad=:ad AND sifre=:sifre ");
	$kulsor->execute(array('ad' => $_POST['ad'], 'sifre' => $sifre));
	$ksayi=$kulsor->rowCount();



	if ($ksayi==1) {
		$_SESSION['giris']=$_POST['ad'];
		header("location:../index.php");

	}else{
		header("location:../giris.php?durum=sifre");
	}


	exit;
}

/***********************************************************************/


if (isset($_POST['projeekle'])) {

	$projeekle=$db->prepare("INSERT INTO projeler SET
		baslik=:baslik,
		uye=:uye
		");

	$ekleme=$projeekle->execute(array(
		'baslik' => $_POST['baslik'],
		'uye' => $_POST['uye']

	));

	if ($ekleme) {
		header("location:../index.php?durum=ok");
		exit;
	} else {
		header("location:../index.php?durum=no");
		exit;
	}
}

/***********************************************************************/

if (isset($_POST['projesil'])) {

	$id=$_POST['id'];

	$prosor=$db->prepare("SELECT * FROM gorevler WHERE proje=:ad");
	$prosor->execute(array('ad' => $id));
	$psayi=$prosor->rowCount();
	if ($psayi==0) {

		$sil=$db->prepare("DELETE from projeler where id=:id");
		$kontrol=$sil->execute(array(
			'id' => $id
		));
	}else{
		header("location:../index.php?durum=sayi");
		exit;
	}

	if ($kontrol) {
		header("location:../index.php?durum=ok");
		exit;
	}else{
		header("location:../index.php?durum=no");
		exit;
	}
}

/***********************************************************************/


if (isset($_POST['gorevekle'])) {

	$gorevekle=$db->prepare("INSERT INTO gorevler SET
		baslik=:baslik,
		proje=:proje,
		calisan=:calisan,
		baslangic=:baslangic,
		bitis=:bitis,
		detay=:detay,
		durum=:durum
		");

	$ekleme=$gorevekle->execute(array(
		'baslik' => $_POST['baslik'],
		'proje' => $_POST['proje'],
		'calisan' => $_POST['calisan'],
		'baslangic' => $_POST['baslangic'],
		'bitis' => $_POST['bitis'],
		'detay' => $_POST['detay'],
		'durum' => '1'

	));

	if ($ekleme) {
		header("location:../projedetay.php?durum=ok&id=".$_POST['proje']."&projedetay=");
		exit;
	} else {
		header("location:../projedetay.php?durum=no&id=".$_POST['proje']."&projedetay=");
		exit;
	}
}


/***********************************************************************/

if (isset($_POST['gorevsil'])) {

	$id=$_POST['id'];



	$sil=$db->prepare("DELETE from gorevler where id=:id");
	$kontrol=$sil->execute(array(
		'id' => $id
	));

	if ($kontrol) {
		header("location:../projedetay.php?durum=ok&id=".$_POST['proje']."&projedetay=");
		exit;
	}else{
		header("location:../projedetay.php?durum=no&id=".$_POST['proje']."&projedetay=");
		exit;
	}
}

/***********************************************************************/

if (isset($_POST['projebitir'])) {
	$veriguncelle=$db->prepare("UPDATE gorevler SET
		durum=:durum where id={$_POST['id']}");

	$guncelle=$veriguncelle->execute(array(
		'durum' => '3'
	));

	if ($guncelle) {
		header("location:../index.php?durum=ok&id=".$_POST['id']."&detay=");
		exit;
	}else{
		header("location:../index.php?durum=no&id=".$_POST['id']."&detay=");
		exit;
	}
}