<?php
require 'config.php'; // config ayarlarımızı yüklüyoruz

// iletisim GET'i var ise
if (isset($_GET["iletisim"])) {

    // POST değerlerini değişkenlerimize atıyoruz
    $ad = $_POST["ad"];
    $mail = $_POST["mail"];
    $mesaj = $_POST["mesaj"];

    // mesajlar tablosuna girilen içeriğin olduğu değeri INSERT ile ekliyoruz.
    $db->query("INSERT INTO mesajlar (mesaj_ad, mesaj_mail, mesaj_icerik, mesaj_tarih) VALUES ('$ad', '$mail', '$mesaj', $time)");

    // iletisim sayfasına success GET'i ile yönlendiriyoruz
    header("Location:iletisim.php?success");
    exit; // sayfamızı burada sonlandırıyoruz.
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İletişim | Fuar Giyim</title>
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
                <h1>İletişim</h1>
            </div>
        </div>

        <div class="container mt-100">

            <h3>Bize Ulaşın</h3>

            <form action="?iletisim" method="POST" class="iletisim_form">
                <input type="text" name="ad" placeholder="Adınız" required>
                <input type="text" name="mail" placeholder="E-Mail" required>
                <textarea placeholder="İstediğiniz Ürün, Adresiniz vb. bilgiler" name="mesaj" required></textarea>
                <button class="button-1">Gönder</button>

                <?php if (isset($_GET['success']))
                    echo '<h6 style="color:green">Mesajınız bize ulaştı, en kısa sürede dönüş yapacağız.</h6>'; ?>
            </form>
        </div>

    </main>

    <footer>
        <?php require 'footer.php' // footer'imizi çekiyoruz ?>
    </footer>

</body>

</html>
