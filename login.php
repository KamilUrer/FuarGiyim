<?php
require 'config.php'; // config değerini yüklüyoruz.

// giris GET değişkeni var ise
if (isset($_GET["giris"])) {

    // POST'tan gelen veriyi değişkenlere atıyoruz
    $kullanici_mail = $_POST["kullanici_mail"];
    $kullanici_sifre = $_POST["kullanici_sifre"];

    // mail ve şifre ile eşleşen bir veri var mı kontrol ediyoruz
    $kontrol = $db->query("SELECT kullanici_id FROM kullanicilar WHERE kullanici_mail = '$kullanici_mail' AND kullanici_sifre = '$kullanici_sifre'");
    if ($kontrol->num_rows > 0) { // var ise

        // çerezlerimizi oluşturup mail ve şifre değerlerini atıyoruz
        setcookie("kullanici_mail", $kullanici_mail, time() + (3600 * 24), "/");
        setcookie("kullanici_sifre", $kullanici_sifre, time() + (3600 * 24), "/");

        // ana sayfaya yönlendiriyoruz.
        header("Location:index.php");
    } else { // yok ise

        // login sayfasına err GET'i ile yönlendiriyoruz
        header("Location:login.php?err=1");
    }

    exit;
}


// kayıt GET'i var ise
if (isset($_GET["kayit"])) {

    // POST'tan gelen verileri değişkenlere atıyoruz
    $kullanici_mail = $_POST["kullanici_mail"];
    $kullanici_sifre = $_POST["kullanici_sifre"];
    $kullanici_isim = $_POST["kullanici_isim"];

    // girdiğimiz mail adresi zaten kayıtlı mı kontrol ediyoruz
    $kontrol = $db->query("SELECT kullanici_id FROM kullanicilar WHERE kullanici_mail = '$kullanici_mail'");
    if ($kontrol->num_rows > 0) { // mail adresi veritabanında var ise
        // login sayfasına err GET'i ile yönlendirip hata veriyoruz.
        header("Location:login.php?register&err");
    } else { // yok ise

        // kullanicilar tablosuna kaydımızı oluşturuyoruz.
        $db->query("INSERT INTO kullanicilar (kullanici_mail, kullanici_sifre, kullanici_isim, kullanici_kayit) VALUES ('$kullanici_mail', '$kullanici_sifre', '$kullanici_isim', $time)");

        // mail ve şifremiz ile çerezlerimizi oluşturuyoruz.
        setcookie("kullanici_mail", $kullanici_mail, time() + (3600 * 24), "/");
        setcookie("kullanici_sifre", $kullanici_sifre, time() + (3600 * 24), "/");

        // ana sayfaya yönlendiriyoruz.
        header("Location:index.php");
    }

    exit; // sayfayı burada bitiriyoruz
}

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
        <?php require 'header.php'; ?>
    </header>

    <main>

        <?php if (isset($_GET["register"])) { // register GET'i var ise bu içeriği yüklüyoruz ?>

            <div class="container mt-100">
                <h1>Kayıt Ol</h1>
                <form class="login" method="POST" action="?kayit">
                    <input type="text" name="kullanici_mail" placeholder="E-Mail" required>
                    <input type="password" name="kullanici_sifre" placeholder="Şifre" required>
                    <input type="text" name="kullanici_isim" placeholder="Ad ve Soyad" required>
                    <button class="button-1">Kayıt Ol</button>
                </form>

                <?= (isset($_GET["err"]) ? '<h6 style="color:red">Bu mail adresine kayıtlı bir hesap zaten var!</h6>' : '') ?>

            </div>

        <?php } else { // yok ise bu içeriği yüklüyoruz ?>

            <div class="container mt-100">
                <h1>Giriş Yap</h1>
                <form class="login" method="POST" action="?giris">
                    <input type="text" name="kullanici_mail" placeholder="E-Mail">
                    <input type="password" name="kullanici_sifre" placeholder="Şifre">
                    <button class="button-1">Giriş Yap</button>
                </form>

                <?= (isset($_GET["err"]) ? '<h6 style="color:red">Kullanıcı adı veya şifre hatalı!</h6>' : '') ?>

            </div>

        <?php } ?>

    </main>

    <footer>
        <?php require 'footer.php' // footer'ımızı yüklüyoruz ?>
    </footer>

</body>

</html>
