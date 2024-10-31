<?php
require 'config.php'; // config ayarlarımızı yüklüyoruz

// favori_ekle GET'imiz var ise ve kullanıcı giriş yapmışsa
if (isset($_GET["favori_ekle"]) && $kullanici_id !== null) {
    $urun_id = intval($_GET["favori_ekle"]); // GET değerini değişkene atıyoruz
    // favoriler tablosuna kullanici_id'miz ve urun_id değerlerini ekliyoruz
    $stmt = $db->prepare("INSERT INTO favoriler (favori_kullanici, favori_urun) VALUES (?, ?)");
    $stmt->bind_param("ii", $kullanici_id, $urun_id);
    $stmt->execute();

    // urun sayfasına geri yönlendiriyoruz.
    header("Location:urun-detay.php?urun_id=" . $urun_id);
    exit; // sayfayı burada bitiriyoruz
}


// favori_kaldir GET'imiz var ise ve kullanıcı giriş yapmışsa
if (isset($_GET["favori_kaldir"]) && $kullanici_id !== null) {
    $urun_id = intval($_GET["favori_kaldir"]); // GET değerini değişkene atıyoruz
    // favoriler tablosundan kullanici_id'miz ve urun_id ile eşleşen değeri siliyoruz
    $stmt = $db->prepare("DELETE FROM favoriler WHERE favori_kullanici = ? AND favori_urun = ?");
    $stmt->bind_param("ii", $kullanici_id, $urun_id);
    $stmt->execute();

    // urun sayfasına geri yönlendiriyoruz
    header("Location:urun-detay.php?urun_id=" . $urun_id);
    exit; // sayfayı burada bitiriyoruz.
}

// yorum_kaldir GET'imiz var ise ve kullanıcı giriş yapmışsa
if (isset($_GET["yorum_sil"]) && $kullanici_id !== null) {
    $yorum_id = intval($_GET["yorum_sil"]); // GET değerini değişkene atıyoruz
    // yorumlar tablosundan kullanici_id'miz ve yorum_id ile eşleşen değeri siliyoruz
    if ($kullanici_id == 1) { //Eğer kullanıcı admin ise yorumu silebilir
        $stmt = $db->prepare("DELETE FROM yorumlar WHERE yorum_id = ?");
        $stmt->bind_param("i", $yorum_id);
    } else { //Değilse sadece kendi yorumunu silebilir
        $stmt = $db->prepare("DELETE FROM yorumlar WHERE yorum_kullanici_id = ? AND yorum_id = ?");
        $stmt->bind_param("ii", $kullanici_id, $yorum_id);
    }
    $stmt->execute();

    // urun sayfasına geri yönlendiriyoruz
    header("Location:urun-detay.php?urun_id=" . $_GET["urun_id"]);
    exit; // sayfayı burada bitiriyoruz.
}

// yorum_ekle GET'imiz var ise ve kullanıcı giriş yapmışsa
if (isset($_GET["yorum_ekle"]) && $kullanici_id !== null) {
    $yorum_urunid = intval($_GET["urun_id"]); // GET değerini değişkene atıyoruz
    $yorum_kullanici = intval($_GET["yorum_kullanici"]); // GET değerini değişkene atıyoruz
    $yorum_icerik = htmlspecialchars($_GET["yorum_icerik"]); // GET değerini değişkene atıyoruz
    // yorumlar tablosuna yorum_urunid, yorum_kullanici_id ve yorum_icerik değerlerini ekliyoruz
    $stmt = $db->prepare("INSERT INTO yorumlar (yorum_urunid, yorum_kullanici_id, yorum_icerik) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $yorum_urunid, $yorum_kullanici, $yorum_icerik);
    $stmt->execute();

    // urun sayfasına geri yönlendiriyoruz
    header("Location:urun-detay.php?urun_id=" . $yorum_urunid);
    exit; // sayfayı burada bitiriyoruz.
}

// yorum_kaldir Post datamız var ise ve kullanıcı giriş yapmışsa
if (isset($_GET["yorum_sil"]) && $kullanici_id !== null) {
    $yorum_id = intval($_GET["yorum_sil"]); // GET değerini değişkene atıyoruz
    // yorumlar tablosundan kullanici_id'miz ve yorum_id ile eşleşen değeri siliyoruz
    $stmt = $db->prepare("DELETE FROM yorumlar WHERE yorum_kullanici_id = ? AND yorum_id = ?");
    $stmt->bind_param("ii", $kullanici_id, $yorum_id);
    $stmt->execute();

    // urun sayfasına geri yönlendiriyoruz
    header("Location:urun-detay.php?urun_id=" . $_GET["urun_id"]);
    exit; // sayfayı burada bitiriyoruz.
}

// favori_ekle GET'imiz var ise ve kullanıcı giriş yapmışsa
if (isset($_GET["favori_ekle"]) && $kullanici_id !== null) {
    $urun_id = intval($_GET["favori_ekle"]); // GET değerini değişkene atıyoruz
    // favoriler tablosuna kullanici_id'miz ve urun_id değerlerini ekliyoruz
    $stmt = $db->prepare("INSERT INTO favoriler (favori_kullanici, favori_urun) VALUES (?, ?)");
    $stmt->bind_param("ii", $kullanici_id, $urun_id);
    $stmt->execute();

    // urun sayfasına geri yönlendiriyoruz.
    header("Location:urun-detay.php?urun_id=" . $urun_id);
    exit; // sayfayı burada bitiriyoruz
}

?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ürünler | Fuar Giyim</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>

<header>
    <?php require 'header.php'; // header'ı yazdırıyoruz. ?>
</header>

<main>
    <div class="welcome small">
        <div class="dark"></div>
        <img src="images/urun.jpg" class="main_img" alt="Giyim Sitesi Giriş Resmi">
        <div class="container">
            <h1>Ürün Detayı</h1>
        </div>
    </div>

    <?php
    if (isset($_GET["urun_id"])) {
        $urun_id = intval($_GET["urun_id"]);
        // urunler tablosunda urun_id'mize ait olan değeri çekiyoruz.
        $stmt = $db->prepare("SELECT * FROM urunler WHERE urun_id = ?");
        $stmt->bind_param("i", $urun_id);
        $stmt->execute();
        $urun = $stmt->get_result()->fetch_assoc();

        // urun_id favoriler tablosunda kullanici_id'miz ile var mı diye kontrol ediyoruz.
        $favorideMi = false;
        if ($kullanici_id !== null) {
            $stmt = $db->prepare("SELECT * FROM favoriler WHERE favori_urun = ? AND favori_kullanici = ?");
            $stmt->bind_param("ii", $urun_id, $kullanici_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows != 0) {
                $favorideMi = true;
            }
        }

        if ($urun == null) {
            echo '<h5 class="m-auto">Gösterilecek ürün bulunamadı.</h5>';
        } else {
    ?>
    <div class="container mt-100">
        <div class="urun_bilgileri">
            <div class="d-flex">
                <div class="side-2">
                    <img src="images/urun/<?= $urun_id ?>.jpg" alt="<?= htmlspecialchars($urun["urun_isim"]) ?>">
                </div>
                <div class="side-2">
                    <div class="urun_bilgi">
                        <div class="bilgi">
                            <?= htmlspecialchars($urun["urun_isim"]) ?>
                            <img src="images/kiyafet.png">
                        </div>
                        <div class="bilgi">
                            <?= number_format($urun["urun_fiyat"], 0, ',', '.') ?>₺
                            <img src="images/fiyat.png">
                        </div>
                        <div class="bilgi">
                            <?= htmlspecialchars($urun["urun_kategori"]) ?>
                            <img src="images/konum.png">
                        </div>
                        <div class="bilgi small">
                            <?= htmlspecialchars($urun["urun_renk"]) ?>
                            <img src="images/m2.png">
                        </div>
                        <div class="bilgi small">
                            <?= htmlspecialchars($urun["urun_stok"]) ?>
                            <img src="images/ev.png">
                        </div>
                    </div>
                    <div class="mt-30 d-flex a-center j-right">
                        <?php if ($kullanici_id !== null): ?>
                            <?= ($favorideMi ? '<a class="button-1 mr-10" href="?favori_kaldir=' . $urun_id . '">Favorilerden Kaldır</a>' : '<a class="button-1 mr-10" href="?favori_ekle=' . $urun_id . '">Favorilere Ekle</a>') ?>
                        <?php endif; ?>
                        <a href="/iletisim.php" class="button-1">Sipariş Ver</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-30 d-flex a-center j-right">
        <?php

// SQL sorgusu, Yorumları Çekmek için
$yorum = "
SELECT yorumlar.yorum_id, yorumlar.yorum_urunid, yorumlar.yorum_icerik, kullanicilar.kullanici_id, kullanicilar.kullanici_isim, kullanicilar.kullanici_mail
FROM yorumlar
INNER JOIN kullanicilar ON yorumlar.yorum_kullanici_id = kullanicilar.kullanici_id
";

// Sorguyu çalıştır
$result = $db->query($yorum);

// Sonuçları kontrol et ve ekrana yazdır
if ($result->num_rows > 0) {
    // Her satır için verileri yazdır
    while($row = $result->fetch_assoc()) {
        if ($row["yorum_urunid"] == $_GET["urun_id"]) {
            echo '
                <div class="comment-card">
                    <div class="comment-header">
                        <img src="/images/kullanicilar/' . htmlspecialchars($row["kullanici_id"]) . '.jpg" onerror="this.src=\'images/kullanicilar/kullanicilar.png\'" alt="Kullanıcı Fotoğrafı" class="user-photo">
                        <h3 class="user-name">' . htmlspecialchars($row["kullanici_isim"]) . '</h3>
                    </div>
                    <div class="comment-body">
                        <p>' . htmlspecialchars($row["yorum_icerik"]) . '</p>
                    </div>';
                    if ($kullanici_id == $row["kullanici_id"] || $kullanici_id == 1)
                    {
                    echo '
                    <div class="comment-footer">
                        <a href="?yorum_sil=' . $row["yorum_id"] . '&urun_id=' . $_GET["urun_id"] . '" class="button-1">Yorumu Sil</a>
                    </div>';
                    }
                echo '
                </div>';
        }
    }
} else {
    echo "Yorum bulunamadı.";
}
    ?>
         <div class="comment-card">
            <div class="comment-header">
                <h3 class="user-name">Yorum Ekle</h3>
            </div>
            <form action="?urun_id=<?=$urun_id?>" method="GET">
            <?php if ($kullanici_id != null) { ?>
            <div class="comment-body">
            <!-- Yorum eklemek için gizli -->
            <input type="hidden" name="yorum_ekle" value="1">
            <input type="hidden" name="urun_id" value="<?= $_GET["urun_id"] ?>">
            <input type="hidden" name="yorum_kullanici" value="<?= $kullanici_id ?>">
            <textarea style="width:100%; height:100px;" name="yorum_icerik" placeholder="Yorumunuzu buraya yazın..." required></textarea>
            </div>
            <div class="comment-footer">
            <button class="button-1" type="submit">Yorum Yap</button>
            </div>
            <?php } else { echo 'Lütfen Giriş Yapın.'; ?>
            <div class="comment-footer">
                <a href="login.php">
                <button style="margin-top:10px;" class="button-1" type="submit">Giriş Yap</button>
                </a>
            </div>
            <?php } ?>
        </div>

    </div>
    </div>
    <?php
        }
    }
    ?>
</main>

<footer>
    <?php require 'footer.php'; // footer'ı yüklüyoruz. ?>
</footer>

</body>

</html>
