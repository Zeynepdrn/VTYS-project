<?php require_once 'header.php';

?>

<?php if ($yetki==1) { ?>
    
    <h2>Çalışanlar</h2>
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
                <th>İsim</th>
                <th>Kullanıcı Adı</th>
                <th>Başarılı</th>
                <th>Başarısız</th>
                <th>Devam Eden</th>
                <th>Toplam</th>
            </tr>
        </thead>
        <tbody>
            <?php   $i=0;
            $kayitsor=$db->prepare("SELECT * FROM uyeler WHERE tip=2 ORDER BY id DESC");
            $kayitsor->execute(); 
            while ($kayitcek=$kayitsor->fetch(PDO::FETCH_ASSOC)) {$i++?>
                <?php   

                $toplamsor=$db->prepare("SELECT * FROM gorevler WHERE calisan=:ad");
                $toplamsor->execute(array('ad' => $kayitcek['id']));
                $toplam=$toplamsor->rowCount();

                $baslayacaksor=$db->prepare("SELECT * FROM gorevler WHERE calisan=:ad AND durum=:durum ");
                $baslayacaksor->execute(array('ad' => $kayitcek['id'], 'durum' => '1'));
                $baslayacak=$baslayacaksor->rowCount(); 

                $devamsor=$db->prepare("SELECT * FROM gorevler WHERE calisan=:ad AND durum=:durum ");
                $devamsor->execute(array('ad' => $kayitcek['id'], 'durum' => '2'));
                $devam=$devamsor->rowCount();

                $basarilisor=$db->prepare("SELECT * FROM gorevler WHERE calisan=:ad AND durum=:durum ");
                $basarilisor->execute(array('ad' => $kayitcek['id'], 'durum' => '3'));
                $basarili=$basarilisor->rowCount();

                $basarisizsor=$db->prepare("SELECT * FROM gorevler WHERE calisan=:ad AND durum=:durum ");
                $basarisizsor->execute(array('ad' => $kayitcek['id'], 'durum' => '4'));
                $basarisiz=$basarisizsor->rowCount();

                ?>
                <tr>
                    <td><?php echo $i ?></td>
                    <td><?php echo $kayitcek['isim'] ?></td>
                    <td><?php echo $kayitcek['ad'] ?></td>
                    <td><?php echo $basarili ?></td>
                    <td><?php echo $basarisiz ?></td>
                    <td><?php echo $baslayacak+$devam ?></td>
                    <td><?php echo $toplam ?></td>
                   
                </tr>
            <?php } ?>

        </tbody>
    </table>

    <div id="pagination"></div>
    <br>


<?php }else if ($yetki==2) { ?>
<?php  } 


require_once 'footer.php'; ?>