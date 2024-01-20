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
    <title>Üye Ol</title>

    <style>
        body {
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

    </style>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <div class="giris-box">
        <h2>Üye Ol</h2>
        <form method="POST" action="islemler/islem.php">
            <input type="text" name="isim" placeholder="Ad Soyad" required>
            <input type="text" name="ad" placeholder="Kullanıcı Adı" required>
            <input type="password" name="sifre1" placeholder="Şifre" required>
            <input type="password" name="sifre2" placeholder="Şifre Tekrarı" required>
            <div class="radio-group">
                <label>
                    <input type="radio" name="uyetip" value="1" required>
                    Üye
                </label>
                <label>
                    <input type="radio" name="uyetip" value="2" required>
                    Çalışan
                </label>
            </div>
            <button type="submit" name="uyeol">Kayıt Ol</button><br><br><br>
            <a href="giris.php">Giriş Yap</a>
        </form>

<?php if (isset($_GET['durum'])) {?>
        <div class="overlay">
            <div class="alert-box">
                <p><?php if ($_GET['durum']=='adi') {echo 'Kullanıcı adı, sistemde kayıtlı!';}elseif ($_GET['durum']=='sifre') { echo 'Şifreler uyuşmuyor, tekar deneyin!';}elseif ($_GET['durum']=='no') {echo 'Bir hata oluştu tekrar deneyin!';}else{echo '';} ?></p>
            </div>
        </div>
<?php } ?>


    </div>
</body>
</html>
