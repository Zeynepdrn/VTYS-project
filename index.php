<?php require_once 'header.php'; ?>

<?php if ($yetki==1) { ?>


    <h2>Projelerim</h2>
    <div class="row">
        <div class="column">
            <div class="row">
                <div class="column">
                </div>
                <div style="display: flex;justify-content: end;" class="column">
                    <input  type="text" id="searchInput" placeholder="Tabloda ara...">
                </div>
            </div>

            <table id="myTable">
                <thead>
                    <tr>
                        <th width="5">#</th>
                        <th>Başlık</th>
                        <th width="100">İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    <?php   $i=0;
                    $kayitsor=$db->prepare("SELECT * FROM projeler WHERE uye={$kulcek['id']} ORDER BY id DESC");
                    $kayitsor->execute(); 
                    while ($kayitcek=$kayitsor->fetch(PDO::FETCH_ASSOC)) {$i++?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $kayitcek['baslik'] ?></td>
                            <td style="display: flex;justify-content: space-between;"><form method="get" action="projedetay.php"><input type="hidden" name="id" value="<?php echo $kayitcek['id'] ?>"><button name="projedetay">Görevler</button></form> <form method="post" action="islemler/islem.php"><input type="hidden" name="id" value="<?php echo $kayitcek['id'] ?>"><button name="projesil">Sil</button></form></td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>

            <div id="pagination"></div>
        </div>
        <div class="column giris-box">
            <p>Yeni Proje Ekle</p>
            <form method="POST" action="islemler/islem.php">
                <input type="text" name="baslik" placeholder="Proje Başlığı" required>
                <input type="hidden" name="uye" value="<?php echo $kulcek['id'] ?>">

                <button type="submit" name="projeekle">Ekle</button>
            </form>
            <?php if (isset($_GET['durum'])) {?>
                <div class="overlay">
                    <div class="alert-box">
                        <p><?php if ($_GET['durum']=='ok') {echo 'İşleminiz başarıyla tamamlandı!';}elseif ($_GET['durum']=='no') {echo 'Bir hata oluştu tekrar deneyin!';}elseif ($_GET['durum']=='sayi') {echo 'Proje içerisinde ki görevler silinmeli!';}else{echo '';} ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php }else if ($yetki==2) { ?>

    <h2>Görevlerim</h2>
    <div class="row">
        <div class="column">
            <div class="row">
                <div class="column">
                </div>
                <div style="display: flex;justify-content: end;" class="column">
                    <input  type="text" id="searchInput" placeholder="Tabloda ara...">
                </div>
            </div>

            <table id="myTable">
                <thead>
                    <tr>
                        <th width="5">#</th>
                        <th>Başlık</th>
                        <th>Proje</th>
                        <th>Durum</th>
                        <th width="10">İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    <?php   $i=0;
                    $kayitsor=$db->prepare("SELECT * FROM gorevler WHERE calisan={$kulcek['id']} ORDER BY id DESC");
                    $kayitsor->execute(); 
                    while ($kayitcek=$kayitsor->fetch(PDO::FETCH_ASSOC)) {$i++?>

                        <?php   

                        $prosor=$db->prepare("SELECT * FROM projeler WHERE id=:id");
                        $prosor->execute(array('id' => $kayitcek['proje']));
                        $procek=$prosor->fetch(PDO::FETCH_ASSOC);

                        $baslangic      = strtotime($bugun);
                        $bitis          = strtotime($kayitcek['bitis']);
                        $fark           = abs($bitis-$baslangic);

                        if ($kayitcek['durum']==3) {
                            $kalan = "Süre Bitti";
                        }else{
                            if ($bugun<=$kayitcek['bitis']) {
                                $kalan   = $fark/86400;

                                $veriguncelle=$db->prepare("UPDATE gorevler SET
                                    durum=:durum where id={$kayitcek['id']}");

                                $guncelle=$veriguncelle->execute(array(
                                    'durum' => '2'
                                ));

                                if($bugun<$kayitcek['baslangic']){
                                    $kalan = "Süre Başlamadı";
                                    $veriguncelle=$db->prepare("UPDATE gorevler SET
                                        durum=:durum where id={$kayitcek['id']}");

                                    $guncelle=$veriguncelle->execute(array(
                                        'durum' => '1'
                                    ));

                                }
                            }else{
                                $kalan = "Süre Bitti";

                                $veriguncelle=$db->prepare("UPDATE gorevler SET
                                    durum=:durum where id={$kayitcek['id']}");

                                $guncelle=$veriguncelle->execute(array(
                                    'durum' => '4'
                                ));

                            }
                        }
                        ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $kayitcek['baslik'] ?></td>
                            <td><?php echo $procek['baslik'] ?></td>
                            <td><?php if ($kayitcek['durum']==1) { echo 'Başlayacak'; }else if ($kayitcek['durum']==2) { echo 'Devam Ediyor'; }else if ($kayitcek['durum']==3) { echo 'Bitti'; }else if ($kayitcek['durum']==4) { echo 'Tamamlanamadı'; } ?></td>
                            <td style="display: flex;justify-content: space-between;"><form method="get" action="index.php"><input type="hidden" name="id" value="<?php echo $kayitcek['id'] ?>"><button name="detay">Detay</button></form></td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>

            <div id="pagination"></div>
        </div>
        <div class="column giris-box">

            <?php if (isset($_GET['detay'])) { ?>

                <?php $gorevsor=$db->prepare("SELECT * FROM gorevler WHERE id=:ad");
                $gorevsor->execute(array('ad' => $_GET['id']));
                $gorevcek=$gorevsor->fetch(PDO::FETCH_ASSOC); ?>

                <?php if ($gorevcek['durum']==4){ echo 'Görev Süresi Doldu!'; ?><br><br>
                <div class="row">
                    <div class="column">Başlangıç: <?php echo turkcetarih('j F Y',$gorevcek['baslangic']) ?></div>
                    <div class="column">Bitiş: <?php echo turkcetarih('j F Y',$gorevcek['bitis']) ?></div>
                </div>
                <textarea disabled><?php echo $gorevcek['detay'] ?></textarea> 

                <?php }else if ($gorevcek['durum']==3){ echo 'Görev Tamamlandı!'; ?><br><br>
                <div class="row">
                    <div class="column">Başlangıç: <?php echo turkcetarih('j F Y',$gorevcek['baslangic']) ?></div>
                    <div class="column">Bitiş: <?php echo turkcetarih('j F Y',$gorevcek['bitis']) ?></div>
                </div>
                <textarea disabled><?php echo $gorevcek['detay'] ?></textarea> 

                <?php }else if ($gorevcek['durum']==1){ echo 'Görev Başlamadı!'; ?><br><br>
                <div class="row">
                    <div class="column">Başlangıç: <?php echo turkcetarih('j F Y',$gorevcek['baslangic']) ?></div>
                    <div class="column">Bitiş: <?php echo turkcetarih('j F Y',$gorevcek['bitis']) ?></div>
                </div>
                <textarea disabled><?php echo $gorevcek['detay'] ?></textarea> 

                <?php }else if ($gorevcek['durum']==2){ echo 'Görev Devam Ediyor!'; ?><br><br>
                <div class="row">
                    <div class="column">Başlangıç: <?php echo turkcetarih('j F Y',$gorevcek['baslangic']) ?></div>
                    <div class="column">Bitiş: <?php echo turkcetarih('j F Y',$gorevcek['bitis']) ?></div>
                </div>
                <form method="POST" action="islemler/islem.php">
                    <textarea disabled name="detay"><?php echo $gorevcek['detay'] ?></textarea> 
                    <input type="hidden" name="id" value="<?php echo $gorevcek['id'] ?>">
                    <button type="submit" name="projebitir">Tamamla</button>
                </form>


            <?php } ?>
        <?php } ?>

        <?php if (isset($_GET['durum'])) {?>
            <div class="overlay">
                <div class="alert-box">
                    <p><?php if ($_GET['durum']=='ok') {echo 'İşleminiz başarıyla tamamlandı!';}elseif ($_GET['durum']=='no') {echo 'Bir hata oluştu tekrar deneyin!';}elseif ($_GET['durum']=='sayi') {echo 'Proje içerisinde ki görevler silinmeli!';}else{echo '';} ?></p>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<?php }else{
    header('location:islemler/cikis.php');
    exit;
} 

require_once 'footer.php'; ?>