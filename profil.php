<?php
require 'config.php';

// logout GET'i var ise
if (isset($_GET["logout"])) {

    // çerezlerimizi siliyoruz
    setcookie("kullanici_mail", "", time() - 1, "/");
    setcookie("kullanici_sifre", "", time() - 1, "/");

    // ana sayfaya yönlendiriyoruz.
    header("Location:index.php");
    exit;
}

// Sayfanın bu kısmından sonra giriş yok ise ana sayfaya yönlendiriyoruz.
if (!$girisVarmi) {
    header("Location:index.php");
    exit;
}

// duzenle GET'i var ise
if (isset($_GET["duzenle"])) {

    // POST'tan gelen değerleri değişkenlerimize atıyoruz
    $kullanici_id = $kullanici["kullanici_id"];
    $kullanici_isim = $_POST["kullanici_isim"];
    $kullanici_mail = $_POST["kullanici_mail"];
    $kullanici_sifre = $_POST["kullanici_sifre"];

    // kullanicilar tablosundaki kullanici_id'miz ile olan veriyi UPDATE ile değiştiriyoruz
    $db->query("UPDATE kullanicilar SET kullanici_isim = '$kullanici_isim', kullanici_mail = '$kullanici_mail', kullanici_sifre = '$kullanici_sifre' WHERE kullanici_id = $kullanici_id");

    if (isset($_FILES["kullanici_fotograf"]) && $_FILES["kullanici_fotograf"]["error"] == 0) { // fotoğraf yüklenmiş ise
        // yüklenen fotoğrafı kullanicilar sayfasına taşıyoruz.
        move_uploaded_file($_FILES["kullanici_fotograf"]["tmp_name"], "images/kullanicilar/" . $kullanici_id . ".jpg");
    }

    // profil sayfasına success GET'i ile yönlendiriyoruz
    header("Location:profil.php?success");

    exit; // sayfamızı burada bitiriyoruz.
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

        <div class="welcome small">
            <div class="dark"></div>
            <img src="images/urun.jpg" class="main_img" alt="Giyim Sitesi Giriş Resmi">
            <div class="container">
                <h1>Profil</h1>
            </div>
        </div>

        <div class="container mt-100">


        <div class="container mt-100">

            <h3>Bilgilerini Düzenle</h3>

            <img style="width:128px;height:128px;border-radius:50%"
                src="images/kullanicilar/<?= $kullanici["kullanici_id"] ?>.jpg" onerror="this.src='images/kullanicilar/kullanicilar.png'"
                 alt="Kullanıcı Fotoğrafı">

            <form action="?duzenle" enctype="multipart/form-data" method="POST" class="iletisim_form">
                <input type="file" name="kullanici_fotograf" class="mt-10">
                <input type="text" class="mt-30" name="kullanici_isim" value="<?= $kullanici["kullanici_isim"] ?>"
                    placeholder="Adınız" required>
                <input type="text" name="kullanici_mail" value="<?= $kullanici["kullanici_mail"] ?>"
                    placeholder="E-Mail" required>
                <input type="password" name="kullanici_sifre" value="<?= $kullanici["kullanici_sifre"] ?>"
                    placeholder="Şifre" required>

                <button class="button-1 mt-30">Kaydet</button>

                <?php if (isset($_GET['success']))
                    echo '<h6 style="color:green">Bilgileriniz güncellendi.</h6>'; // success GET'i var ise mesajı gösteriyoruz ?>
            </form>
        </div>

            <h3 style="margin-top:100px;">Beğendiğiniz Ürünler</h3>

            <div class="urunler">

                <?php
                // favoriler tablosundan kullanici_id'miz ile olan değerleri çekiyoruz
                $urunlerCek = $db->query("SELECT * FROM favoriler WHERE favori_kullanici = $kullanici_id");
                if ($urunlerCek->num_rows == 0) { // değer yok ise
                    echo '<h5 class="m-auto">Gösterilecek ürün bulunamadı.</h5>';
                } else { // var ise
                    // while ile değerleri tek tek yazdırıyoruz
                    while ($favori = $urunlerCek->fetch_assoc()) {
                        // ürün bilgilerini favori_urun değerinden çekiyoruz
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

    </main>

    <footer>
        <?php require 'footer.php' // footer'ımızı çekiyoruz ?>
    </footer>

</body>

</html>
