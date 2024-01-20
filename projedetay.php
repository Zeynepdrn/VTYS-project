<?php require_once 'header.php';
if (isset($_GET['projedetay'])) {
// code...
}else{
    header("location:index.php");
} 


?>

<?php if ($yetki==1) { ?>
    <div class=" giris-box">
        <p>Yeni Görev Ekle</p>
        <form method="POST" action="islemler/islem.php">
            <div class="row">
                <div class="column">
                    <input type="text" name="baslik" placeholder="Görev Başlığı" required>
                </div>
                <div class="column">
                    <select name="calisan" required>
                        <option value="">Çalışan Seç</option>
                        <?php
                        $kayitsor=$db->prepare("SELECT * FROM uyeler WHERE tip=2 ORDER BY id DESC");
                        $kayitsor->execute(); 
                        while ($kayitcek=$kayitsor->fetch(PDO::FETCH_ASSOC)) { ?>
                            <option value="<?php echo $kayitcek['id'] ?>"><?php echo $kayitcek['isim'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="column" >
                    <label for="">Başlangıç Tarihi</label>
                    <input type="date" name="baslangic" placeholder="Proje Başlığı" required>
                </div>
                <div class="column" >
                    <label for="">Bitiş Tarihi</label>
                    <input type="date" name="bitis" placeholder="Proje Başlığı" required>
                </div>
            </div>
            <div class="row">
                <textarea name="detay"  rows="3" placeholder="Görev Detayı" required></textarea>
            </div>
            <input type="hidden" name="proje" value="<?php echo $_GET['id'] ?>">

            <button type="submit" name="gorevekle">Ekle</button>
        </form>
        <?php if (isset($_GET['durum'])) {?>
            <div class="overlay">
                <div class="alert-box">
                    <p><?php if ($_GET['durum']=='ok') {echo 'İşleminiz başarıyla tamamlandı!';}elseif ($_GET['durum']=='no') {echo 'Bir hata oluştu tekrar deneyin!';}else{echo '';} ?></p>
                </div>
            </div>
        <?php } ?>
    </div>
    <h2>Görevler</h2>
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
                <th>Çalışan</th>
                <th>Başlangıç</th>
                <th>Bitiş</th>
                <th>Kalan</th>
                <th>Durum</th>
                <th width="10">İşlem</th>
            </tr>
        </thead>
        <tbody>
            <?php   $i=0;
            $kayitsor=$db->prepare("SELECT * FROM gorevler WHERE proje={$_GET['id']} ORDER BY id DESC");
            $kayitsor->execute(); 
            while ($kayitcek=$kayitsor->fetch(PDO::FETCH_ASSOC)) {$i++?>
                <?php   

                $calsor=$db->prepare("SELECT * FROM uyeler WHERE id=:id");
                $calsor->execute(array('id' => $kayitcek['calisan']));
                $calcek=$calsor->fetch(PDO::FETCH_ASSOC);

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
                    <td><?php echo $calcek['isim'] ?></td>
                    <td><?php echo turkcetarih('j F Y',$kayitcek['baslangic']) ?></td>
                    <td><?php echo turkcetarih('j F Y',$kayitcek['bitis']) ?></td>
                    <td><?php echo $kalan ?></td>
                    <td><?php if ($kayitcek['durum']==1) { echo 'Başlayacak'; }else if ($kayitcek['durum']==2) { echo 'Devam Ediyor'; }else if ($kayitcek['durum']==3) { echo 'Bitti'; }else if ($kayitcek['durum']==4) { echo 'Tamamlanamadı'; } ?></td>
                    <td style="display: flex;justify-content: space-between;"><form method="post" action="islemler/islem.php"><input type="hidden" name="proje" value="<?php echo $_GET['id'] ?>"><input type="hidden" name="id" value="<?php echo $kayitcek['id'] ?>"><button name="gorevsil">Sil</button></form></td>
                </tr>
            <?php } ?>

        </tbody>
    </table>

    <div id="pagination"></div>
    <br>


<?php }else if ($yetki==2) { ?>
<?php  } 


require_once 'footer.php'; ?>