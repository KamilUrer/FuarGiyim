<?php
// config.php'yi çekiyoruz.
require 'config.php';

// Kullanıcı admin değil veya giriş yapmamışsa index.php'ye yönlendir.
if (!$admin || !$girisVarmi) {
    header("Location:index.php");
    exit;
}

// urunler_ekle diye GET var ise
if (isset($_GET["urun_ekle"])) {

    // POST ettiğimiz değerleri değişkenlere atıyoruz.
    $urun_isim = $_POST["urun_isim"];
    $urun_kategori = $_POST["urun_kategori"];
    $urun_fiyat = $_POST["urun_fiyat"];
    $urun_stok = $_POST["urun_stok"];
    $urun_renk = $_POST["urun_renk"];

    // urunler tablosuna ürünümüzü ekliyoruz.
    $db->query("INSERT INTO urunler (urun_isim, urun_kategori, urun_fiyat, urun_stok, urun_renk) VALUES ('$urun_isim', '$urun_kategori', $urun_fiyat, $urun_stok, '$urun_renk')");
    $son_id = $db->insert_id; // Son eklenen verinin id'sini alıyoruz.

    if (isset($_FILES["urun_fotograf"])) { // Fotoğraf seçilmiş ise
        // Yüklenen fotoğrafı klasöre taşıyoruz.
        move_uploaded_file($_FILES["urun_fotograf"]["tmp_name"], "images/urun/" . $son_id . ".jpg");
    }

    // Admin sayfasına yönlendiriyoruz.
    header("Location:admin.php");

    exit; // exit ile sayfayı burada bitiriyoruz.
}


// kullanici_ekle diye GET var ise
if (isset($_GET["kullanici_ekle"])) {

    // POST'tan gelen veriyi değişkenlere atıyoruz.
    $kullanici_isim = $_POST["kullanici_isim"];
    $kullanici_mail = $_POST["kullanici_mail"];
    $kullanici_sifre = $_POST["kullanici_sifre"];

    // kullanicilar tablosuna kullanıcıyı ekliyoruz.
    $db->query("INSERT INTO kullanicilar (kullanici_isim, kullanici_mail, kullanici_sifre, kullanici_kayit) VALUES ('$kullanici_isim', '$kullanici_mail', '$kullanici_sifre', $time)");
    $son_id = $db->insert_id; // Son eklenen verinin id'sini alıyoruz.

    if (isset($_FILES["kullanici_fotograf"])) { // Fotoğraf seçilmiş ise
        // Yüklenen fotoğrafı kullanicilar klasörüne taşıyoruz.
        move_uploaded_file($_FILES["kullanici_fotograf"]["tmp_name"], "images/kullanicilar/" . $son_id . ".jpg");
    }

    // Admin sayfasına yönlendiriyoruz.
    header("Location:admin.php");

    exit; // Sayfayı burada bitiriyoruz.
}

if (isset($_GET["urun_kaydet"])) {

    // POST'tan gelen veriyi değişkenlere atıyoruz.
    $urun_id = $_GET["urun_kaydet"];
    $urun_isim = $_POST["urun_isim"];
    $urun_kategori = $_POST["urun_kategori"];
    $urun_fiyat = $_POST["urun_fiyat"];
    $urun_stok = $_POST["urun_stok"];
    $urun_renk = $_POST["urun_renk"];

    // populer checkbox'ı seçilmiş ise
    if (isset($_POST["populer"]))
        $pop = 1; // $pop değişkenine 1 değerini veriyoruz
    else
        $pop = 0; // seçilmemiş ise 0 değerini veriyoruz

    // urunler tablosundaki ürünümüzü urun_id ile seçerek düzenliyoruz.
    $db->query("UPDATE urunler SET urun_isim = '$urun_isim', urun_kategori = '$urun_kategori', urun_fiyat = '$urun_fiyat', urun_renk = '$urun_renk', urun_stok = '$urun_stok', populer = '$pop' WHERE urun_id = $urun_id");

    if (isset($_FILES["urun_fotograf"])) { // Fotoğraf yüklenmiş ise
        // Yüklenen fotoğrafı urun klasörüne urun_id.jpg şeklinde taşıyoruz.
        move_uploaded_file($_FILES["urun_fotograf"]["tmp_name"], "images/urun/" . $urun_id . ".jpg");
    }

    // urun_duzenle GET'i ile admin sayfasına yönlendiriyoruz.
    header("Location:admin.php?urun_duzenle=" . $urun_id);

    exit; // Sayfayı burada bitiriyoruz.
}

if (isset($_GET["kullanici_kaydet"])) {

    // POST'tan gelen veriyi değişkenlere atıyoruz.
    $kullanici_id = $_GET["kullanici_kaydet"];
    $kullanici_isim = $_POST["kullanici_isim"];
    $kullanici_mail = $_POST["kullanici_mail"];
    $kullanici_sifre = $_POST["kullanici_sifre"];

    // kullanicilar tablosundaki kullanıcımızı kullanici_id ile seçerek, UPDATE ile güncelliyoruz.
    $db->query("UPDATE kullanicilar SET kullanici_isim = '$kullanici_isim', kullanici_mail = '$kullanici_mail', kullanici_sifre = '$kullanici_sifre' WHERE kullanici_id = $kullanici_id");

    if (isset($_FILES["kullanici_fotograf"])) { // Fotoğraf yüklenmiş ise
        // Yüklenmiş olan fotoğrafı kullanicilar klasörümüze taşıyoruz.
        move_uploaded_file($_FILES["kullanici_fotograf"]["tmp_name"], "images/kullanicilar/" . $kullanici_id . ".jpg");
    }

    // admin sayfasına kullanici_duzenle GET'i ile yönlendiriyoruz.
    header("Location:admin.php?kullanici_duzenle=" . $kullanici_id);

    exit; // Sayfayı burada bitiriyoruz.
}


// urun_sil GET'i var ise
if (isset($_GET["urun_sil"])) {

    $urun_id = $_GET["urun_sil"]; // urun_sil'den gelen GET verisini değişkene atıyoruz.

    // DELETE kullanarak urun_id'ye ait olan veriyi siliyoruz.
    $db->query("DELETE FROM urunler WHERE urun_id = $urun_id");

    // admin sayfasına yönlendiriyoruz.
    header("Location:admin.php");

    exit; // sayfayı burada bitiriyoruz.
}


// kullanici_sil GET'i var ise
if (isset($_GET["kullanici_sil"])) {

    $kullanici_id = $_GET["kullanici_sil"]; // kullanici_sil'den gelen GET verisini değişkene atıyoruz.

    // DELETE kullanarak kullanici_id'ye ait olan veriyi siliyoruz.
    $db->query("DELETE FROM kullanicilar WHERE kullanici_id = $kullanici_id");

    // admin sayfasına yönlendiriyoruz.
    header("Location:admin.php");

    exit; // sayfayı burada bitiriyoruz.
}

?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Fuar Giyim</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>

    <header>
        <?php require 'header.php'; ?>
    </header>

    <main>

        <div class="welcome small">
            <img src="images/urun.jpg" class="main_img" alt="Giysi Sitesi Giriş Resmi">
            <div class="container">
                <h1>Admin Paneli</h1>
            </div>
        </div>

        <?php if (isset($_GET["urun_duzenle"])) { // urun_duzenle GET'i var ise bu kısmı yüklüyoruz.

                $urun_id = $_GET["urun_duzenle"]; // urun_duzenle GET'inden gelen değeri değişkene atıyoruz.
                // urun_id'mize ait olan veriyi seçiyoruz.
                $urun = $db->query("SELECT * FROM urunler WHERE urun_id = $urun_id")->fetch_assoc();
                ?>

            <div class="container mt-100">

                <h2>Ürün Düzenle</h2>

                <div class="container mt-100">

                    <div class="urun_bilgileri">

                        <div class="d-flex">

                            <div class="side-2">
                                <img src="images/urun/<?= $urun_id ?>.jpg?v=<?= $time ?>"
                                    alt="<?= $urun["urun_isim"] ?>">
                            </div>

                            <div class="side-2">
                                <form action="?urun_kaydet=<?= $urun_id ?>" method="POST" enctype="multipart/form-data">
                                    <div class="urun_bilgi has_inputs">
                                        <div class="bilgi">
                                            <input type="file" name="urun_fotograf" style="width:200px;">
                                            <img src="images/img.png">
                                        </div>
                                        <div class="bilgi">
                                            <input type="text" name="urun_isim" value="<?= $urun["urun_isim"] ?>">
                                            <img src="images/kiyafet.png">
                                        </div>
                                        <div class="bilgi">
                                            <input type="text" name="urun_fiyat" style="margin-right:3px"
                                                value="<?= $urun["urun_fiyat"] ?>">₺
                                            <img src="images/fiyat.png">
                                        </div>
                                        <div class="bilgi">
                                            <input type="text" name="urun_kategori" value="<?= $urun["urun_kategori"] ?>">
                                            <img src="images/konum.png">
                                        </div>
                                        <div class="bilgi small">
                                            <input type="text" name="urun_renk" value="<?= $urun["urun_renk"] ?>">
                                            <img src="images/m2.png">
                                        </div>
                                        <div class="bilgi small">
                                            <input type="text" name="urun_stok" value="<?= $urun["urun_stok"] ?>">
                                            <img src="images/ev.png">
                                        </div>
                                        <div class="bilgi small">
                                            <label class="d-flex a-center"><input type="checkbox" <?= ($urun["populer"] == "1" ? 'checked' : '') ?> style="margin-right:5px"
                                                    name="populer">Popüler</label>
                                        </div>
                                    </div>

                                    <div class="mt-30 d-flex a-center j-right">
                                        <a href="?urun_sil=<?= $urun["urun_id"] ?>" class="button-1 mr-10">Sil</a>
                                        <button class="button-1">Kaydet</button>
                                    </div>
                                </form>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        <?php } else if (isset($_GET["kullanici_duzenle"])) { // kullanici_duzenle GET'i var ise bu kısmı yüklüyoruz.

                $kullanici_id = $_GET["kullanici_duzenle"]; // kullanici_duzenle GET'inden gelen veriyi değişkene atıyoruz.
                // kullanici_id'ye ait olan veriyi seçip değerleri $kullanicilar array'ına yazdırıyoruz.
                $kullanicilar = $db->query("SELECT * FROM kullanicilar WHERE kullanici_id = $kullanici_id")->fetch_assoc();
                ?>

                <div class="container mt-100">

                    <h2>Kullanıcı Düzenle</h2>

                    <div class="container mt-100">

                        <div class="urun_bilgileri">

                            <div class="d-flex">

                                <div class="side-2">
                                    <img src="images/kullanicilar/<?= $kullanici_id ?>.jpg?v=<?= $time ?>"
                                        onerror="this.src='images/kullanicilar/kullanicilar.png'"
                                        alt="<?= $kullanicilar["kullanici_isim"] ?>">
                                </div>

                                <div class="side-2">
                                    <form action="?kullanici_kaydet=<?= $kullanici_id ?>" method="POST"
                                        enctype="multipart/form-data">
                                        <div class="urun_bilgi has_inputs">
                                            <div class="bilgi">
                                                <input type="file" name="kullanici_fotograf" style="width:200px;">
                                                <img src="images/img.png">
                                            </div>
                                            <div class="bilgi">
                                                <input type="text" name="kullanici_isim"
                                                    value="<?= $kullanicilar["kullanici_isim"] ?>">
                                                    <i style="margin-left:5px;"class="fa-solid fa-pen-to-square"></i>
                                            </div>
                                            <div class="bilgi">
                                                <input type="text" name="kullanici_mail"
                                                    value="<?= $kullanicilar["kullanici_mail"] ?>">
                                                    <i style="margin-left:5px;" class="fa-regular fa-envelope"></i>
                                            </div>
                                            <div class="bilgi">
                                                <input type="text" name="kullanici_sifre"
                                                    value="<?= $kullanicilar["kullanici_sifre"] ?>">
                                                    <i style="margin-left:5px;" class="fa-solid fa-key"></i>
                                            </div>
                                            <div class="bilgi small">
                                            <?= date("d.m.Y H:i", $kullanicilar["kullanici_kayit"]) ?>
                                                 <i style="margin-left:5px;" class="fa-solid fa-clock"></i>
                                            </div>
                                        </div>

                                        <div class="mt-30 d-flex a-center j-right">
                                            <a href="?kullanici_sil=<?= $kullanicilar["kullanici_id"] ?>"
                                                class="button-1 mr-10">Sil</a>
                                            <button class="button-1">Kaydet</button>
                                        </div>
                                    </form>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>

        <?php } else { // Yukarıdaki iki GET yok ise ana sayfayı yüklüyoruz. ?>

                <div class="container mt-100">

                    <h2>İletişim Mesajları</h2>

                    <div class="container">

                        <div class="urunler mt-30">

                            <div class="kullanicilar mt-30">

                                <?php
                                // mesajlar tablosunu query ile seçiyoruz.
                                $mesajlariCek = $db->query('SELECT * FROM mesajlar');

                                // tabloda veri yok ise
                                if ($mesajlariCek->num_rows == 0) {
                                    echo '<h5 class="m-auto">Gösterilecek mesaj bulunamadı.</h5>';
                                } else { // veri var ise

                                    // while ile tüm verileri tek tek yazdırıyoruz.
                                    while ($mesaj = $mesajlariCek->fetch_assoc()) {
                                        echo '<div class="kullanici">
                                        <div>
                                            <h5>' . $mesaj["mesaj_ad"] . '</h5>
                                            <h6>' . $mesaj["mesaj_mail"] . '</h6>
                                            <span style="font-size:12px">' . $mesaj["mesaj_icerik"] . '</span>
                                            <span style="font-size:12px;display:block;margin-top:20px">' . date("d.m.Y H:i", $mesaj["mesaj_tarih"]) . '</span>
                                        </div>
                                        </div>';
                                    }
                                }
                                ?>

                            </div>

                        </div>

                    </div>

                    <h2 class="mt-100">Ürünleri Yönet</h2>

                    <div class="p-10 d-flex a-center border linear-left ekle">
                        <span>Ürün Ekle</span>
                        <form action="?urun_ekle" enctype="multipart/form-data" method="POST">
                        <img src="images/img.png" onclick="document.getElementById('kullanici_fotograf').click()"
                                title="Fotoğraf Seç">
                            <input type="file" id="urun_fotograf" name="urun_fotograf" style="display:block" required>
                            <input style="width:100px;"  type="text" name="urun_isim" placeholder="Ürün Adı" required>
                            <input style="width:100px;"  type="text" name="urun_renk" placeholder="Renk" required>
                            <input style="width:100px;"  type="number" name="urun_fiyat" placeholder="Fiyat" required>
                            <input type="text" name="urun_kategori" placeholder="Kategori" required>
                            <input style="width:100px;"  type="number" name="urun_stok" placeholder="Adet" required>
                            <button class="button-1">Ekle</button>
                        </form>
                    </div>

                    <div class="container">

                        <div class="urunler mt-30">

                            <?php
                            // urunler tablosundaki verileri query ile seçiyoruz.
                            $urunleriCek = $db->query('SELECT * FROM urunler');

                            // veri yok ise
                            if ($urunleriCek->num_rows == 0) {
                                echo '<h5 class="m-auto">Gösterilecek ürün bulunamadı.</h5>';
                            } else { // veri var ise

                                // while kullanarak tüm verileri tek tek yazdırıyoruz.
                                while ($urun = $urunleriCek->fetch_assoc()) {
                                    echo '<div class="urun">
            <div class="urun_icerik">
                <img src="images/urun/' . $urun["urun_id"] . '.jpg?v=' . $time . '" alt="' . $urun["urun_isim"] . '">
                <div class="urun_detay">
                    <h5>' . $urun["urun_isim"] . '</h5>
                    <h6>' . number_format($urun["urun_fiyat"], 0, ',', '.') . '₺<b>' . $urun["urun_kategori"] . '</b></h6>
                    <a href="?urun_duzenle=' . $urun["urun_id"] . '"><button class="button-1">Düzenle</button></a>
                </div>
            </div>
        </div>';
                                }
                            }
                            ?>

                        </div>

                    </div>

                </div>


                <div class="container mt-100">

                    <h2>Kullanıcıları Yönet</h2>

                    <div class="p-10 d-flex a-center border linear-left ekle">
                        <span>Kullanıcı Ekle</span>
                        <form action="?kullanici_ekle" enctype="multipart/form-data" method="POST">
                            <img src="images/img.png" onclick="document.getElementById('kullanici_fotograf').click()"
                                title="Fotoğraf Seç">
                            <input type="file" id="kullanici_fotograf" name="urun_fotograf" style="display:block" required>
                            <input type="text" name="kullanici_mail" placeholder="Kullanıcı Mail" required>
                            <input type="text" name="kullanici_isim" value="" placeholder="Kullanıcı Ad Soyad" required>
                            <input type="password" name="kullanici_sifre" placeholder="Kullanıcı Şifre" required>
                            <button class="button-1">Ekle</button>
                        </form>
                    </div>

                    <div class="kullanicilar mt-30">

                        <?php
                        // kullanicilar tablosundaki tüm verileri seçiyoruz.
                        $kullanicilariCek = $db->query('SELECT * FROM kullanicilar');
                        if ($kullanicilariCek->num_rows == 0) { // veri yok ise
                            echo '<h5 class="m-auto">Gösterilecek kullanıcı bulunamadı.</h5>';
                        } else { // veri var ise

                            // while kullanarak tüm verileri tek tek yazdırıyoruz.
                            while ($kullanicilar = $kullanicilariCek->fetch_assoc()) {
                                echo '<div class="kullanici">
                                <img src="images/kullanicilar/' . $kullanicilar["kullanici_id"] . '.jpg?v=' . $time . '" onerror="this.src=\'images/kullanicilar/kullanicilar.png\'" alt="' . $kullanicilar["kullanici_isim"] . '">
                                <div>
                                    <h5>' . $kullanicilar["kullanici_isim"] . '</h5>
                                    <h6>' . $kullanicilar["kullanici_mail"] . '</h6>
                                </div>
                                <a href="?kullanici_duzenle=' . $kullanicilar["kullanici_id"] . '" class="button-1">Düzenle</a>
                            </div>';
                            }
                        }
                        ?>

                    </div>

                </div>

        <?php } ?>

    </main>

    <footer>
        <?php require 'footer.php' // footer'ı yazdırıyoruz. ?>
    </footer>

</body>

</html>
