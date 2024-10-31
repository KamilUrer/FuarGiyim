<?php
require 'config.php';

// Sayfanın bu kısmından sonra giriş yok ise ana sayfaya yönlendiriyoruz.
if (!$girisVarmi) {
    header("Location:index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil | Fuar Giyim</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>

    <header>
        <?php require 'header.php'; // header'imizi yüklüyoruz ?>
    </header>

    <main>
        <div class="container mt-100">

            <h2><b>Beğendiğiniz</b> Ürünler</h2>

            <div class="urunler mt-30">

                <?php
                // favoriler tablosundan kullanici_id'miz ile olan değerleri çekiyoruz
                $urunlerCek = $db->query("SELECT * FROM favoriler WHERE favori_kullanici = $kullanici_id");
                if ($urunlerCek->num_rows == 0) { // değer yok ise
                    echo '<h5 class="m-auto">Gösterilecek ürün bulunamadı.</h5>';
                } else { // var ise
                    // while ile değerleri tek tek yazdırıyoruz
                    while ($favori = $urunlerCek->fetch_assoc()) {
                        // urunler bilgilerini favori_urun değerinden çekiyoruz
                        $urun = $db->query("SELECT * FROM urunler WHERE urun_id = {$favori["favori_urun"]}")->fetch_assoc();
                        echo '<div class="urun">
                        <div class="urun_icerik">
                            <img src="images/urun/' . $urun["urun_id"] . '.jpg" alt="' . $urun["urun_isim"] . '">
                            <div class="urun_detay">
                                <h5>' . $urun["urun_isim"] . '</h5>
                                <h6>' . number_format($urun["urun_fiyat"], 0, ',', '.') . '₺<b>' . $urun["urun_kategori"] . '</b></h6>
                                <a href="urun-detay.php?urun_id=' . $urun["urun_id"] . '"><button class="button-1">Detaylar</button></a>
                            </div>
                        </div>
                    </div>';
                    }
                }
                ?>

            </div>

        </div>

		        <div class="container mt-100">

            <h2 class="mb-10">Diğer <b>Popüler</b> Ürünlerimize Göz atın</h2>

            <div class="urunler mt-30">

                <?php
                // populer değeri 1 olan urunleri urunler tablosundan en fazla 4 tane olacak şekilde çekiyoruz
                $urunleriCek = $db->query('SELECT * FROM urunler WHERE populer = 1 LIMIT 4');
                if ($urunleriCek->num_rows == 0) { // urun yok ise
                    echo '<h5 class="m-auto">Gösterilecek ürün bulunamadı.</h5>';
                } else { // var ise
                    // while ile tek tek yazdırıyoruz
                    while ($urun = $urunleriCek->fetch_assoc()) {
                        echo '<div class="urun">
            <div class="urun_icerik">
                <img src="images/urun/' . $urun["urun_id"] . '.jpg" alt="' . $urun["urun_isim"] . '">
                <div class="urun_detay">
                    <h5>' . $urun["urun_isim"] . '</h5>
                    <h6>' . number_format($urun["urun_fiyat"], 0, ',', '.') . '₺<b>' . $urun["urun_kategori"] . '</b></h6>
                    <a href="urun-detay.php?urun_id=' . $urun["urun_id"] . '"><button class="button-1">Detaylar</button></a>
                </div>
            </div>
        </div>';
                    }
                }
                ?>

            </div>
    </main>

    <footer>
        <?php require 'footer.php' // footer'ımızı çekiyoruz ?>
    </footer>

</body>

</html>
