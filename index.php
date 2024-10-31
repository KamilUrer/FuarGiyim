<?php
require 'config.php'; // config ayarlarımızı yüklüyoruz.
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fuar Giyim</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>

    <header>
        <?php require 'header.php'; // header'imizi yüklüyoruz ?>
    </header>

    <main>

        <div class="welcome">
            <img src="images/urun.jpg" class="main_img" alt="Giyim Sitesi Giriş Resmi">
            <div class="container">
                <h1 style="font-weight:600;">Moda ve Kalitenin <br>Buluşma Noktası.</h1>
            </div>
        </div>
        <div class="container mt-100">

            <h2 class="mb-10">Çok Satan <b>Ürünlerimiz</b></h2>

            <div class="urunler mt-30">

                <?php
                // populer değeri 1 olan urunleri urunler tablosundan en fazla 4 tane olacak şekilde çekiyoruz
                $urunleriCek = $db->query('SELECT * FROM urunler WHERE populer = 1 LIMIT 4');
                if ($urunleriCek->num_rows == 0) { // ürün yok ise
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


            <h2 class="mt-100 mb-10">Yeni Eklenen <b>Ürünlerimiz</b></h2>

            <div class="urunler mt-30">

                <?php
                // urunler tablosundaki son 4 değeri urun_id ile büyükten küçüğe olacak şekilde seçiyoruz
                $urunleriCek = $db->query('SELECT * FROM urunler ORDER BY urun_id DESC LIMIT 4');
                if ($urunleriCek->num_rows == 0) { // değer yok ise
                    echo '<h5 class="m-auto">Gösterilecek ürün bulunamadı.</h5>';
                } else { // değer var ise
                    // while ile ürünleri tek tek yazdırıyoruz
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

            <div class="mt-30">
                <a href="urunler.php" class="button-1 mt-30">Tümünü Görüntüle</a>
            </div>

        </div>

    </main>

    <footer>
        <?php require 'footer.php' // footer'imizi yüklüyoruz ?>
    </footer>

</body>

</html>
