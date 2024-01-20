<?php 
include 'islemler/baglan.php';
include 'islemler/fonksiyonlar.php';
if (empty($_SESSION['giris'])) {
    header('location:giris.php');
    exit;
} 

$kullanicisor=$db->prepare("SELECT * FROM uyeler WHERE ad=:ad");
$kullanicisor->execute(array('ad' => $_SESSION['giris']));
$kulcek=$kullanicisor->fetch(PDO::FETCH_ASSOC);

$yetki=$kulcek['tip'];
$bugun=date('Y-m-d');


?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VTYS Final Projesi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="top-bar">
        <div class="user-info" onclick="toggleUserMenu()">
            <span class="user-icon"><img src="img/user.svg" alt=""></span>
            <span class="user-name"><?php echo $kulcek['isim'] ?></span> 
            <div class="user-menu" id="userMenu">
                <a href="islemler/cikis.php">Çıkış Yap</a>
            </div>
        </div>
        <div class="menu-btn" onclick="toggleMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <div class="sidebar" id="sidebar">
        <div class="menu-item">
            <a href="index.php">Ana Sayfa</a>
        </div>
        <?php if ($yetki==1) { ?>
        <div class="menu-item">
            <a href="calisanlar.php">Çalışanlar</a>
        </div>
        <?php } ?>
      
    </div>

    <div class="content" onclick="closeMenu()">
        <div class="container">