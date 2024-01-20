<?php 
include 'islemler/baglan.php';


if (isset($_SESSION['giris'])) {
    header('location:index.php');
} ?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
    </style>
        

</head>
<body>
    <div class="giris-box">
        <h2>Giriş Yap</h2>
        <form method="POST" action="islemler/islem.php">
            <input type="text" name="ad" placeholder="Kullanıcı Adı" required>
            <input type="password" name="sifre" placeholder="Şifre" required>
            <button type="submit" name="girisyap">Giriş</button><br><br><br>
            <a href="uyeol.php">Üye Ol</a>
        </form>


<?php if (isset($_GET['durum'])) {?>
        <div class="overlay">
            <div class="alert-box">
                <p><?php if ($_GET['durum']=='sifre') { echo 'Bilgileriniz hatalı, tekrar deneyin!';}elseif ($_GET['durum']=='no') {echo 'Bir hata oluştu tekrar deneyin!';}else{echo '';} ?></p>
            </div>
        </div>
<?php } ?>
    </div>
</body>
</html>
